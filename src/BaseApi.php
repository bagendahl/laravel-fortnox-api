<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 18:12
 */

namespace Tarre\Fortnox;


use Cache;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Psr\SimpleCache\InvalidArgumentException;
use Tarre\Fortnox\Contracts\BaseApiRepository;
use Tarre\Fortnox\Exceptions\FortnoxQueryException;
use Tarre\Fortnox\Exceptions\FortnoxRequestException;

/**
 * @property Client client
 */
class BaseApi implements BaseApiRepository
{
    static $lastError;
    protected $client = null;
    protected $query = [];
    protected $resource = null;
    protected $resourceSingular = null;
    protected $action = '';
    protected $requestData = [];

    protected $config;

    /**
     * BaseApi constructor.
     * @param Client $client
     * @throws FortnoxRequestException
     * @throws FortnoxQueryException
     */
    public function __construct()
    {
        static $client, $config;

        if (!$client) {

            $config = [
                'base_uri' => config('laravel-fortnox.base_uri') . '/',
                'Access-Token' => config('laravel-fortnox.fortnox_access_token'),
                'Client-Secret' => config('laravel-fortnox.fortnox_client_secret')
            ];

            $client = new Client([
                'base_uri' => $config['base_uri'],
                'headers' => [
                    'Access-Token' => $config['Access-Token'],
                    'Client-Secret' => $config['Client-Secret'],
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            ]);

        }
        // set default query limit for 500
        $this->take(config('laravel-fortnox.fortnox_default_limit', 500));
        $this->resource = strtolower(str_plural(class_basename($this)));
        // Allow for class overriding (Example TaxReduction.php)
        if (!$this->resourceSingular) {
            $this->resourceSingular = ucfirst(str_singular($this->resource));
        }
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setQueryKey($key, $value)
    {
        if (isset($this->query[$key])) {
            $this->query[$key] = $value;
        } else {
            $this->query = array_merge($this->query, [$key => $value]);
        }
        return $this;
    }

    /**
     * @param $number
     * @return BaseApi
     * @throws FortnoxQueryException
     */
    public function take($number)
    {
        if ($number > 500) {
            throw new FortnoxQueryException('The record limit for queries is 500');
        }
        return $this->setQueryKey('limit', $number);
    }

    /**
     * @param $number
     * @return BaseApi
     */
    public function skip($number)
    {
        return $this->setQueryKey('offset', $number);
    }

    /**
     * @param $number
     * @return BaseApi
     */
    public function page($number)
    {
        return $this->setQueryKey('page', $number);
    }

    /**
     * @param string $column
     * @param string $sortOrder
     * @return $this
     * @throws FortnoxQueryException
     */
    public function sortBy(string $column, $sortOrder = 'ascending')
    {
        if (!in_array($sortOrder, ['ascending', 'descending'])) {
            throw new FortnoxQueryException(sprintf('Invalid $sortOrder "%s"', $sortOrder));
        }
        return $this
            ->setQueryKey('sortby', $column)
            ->setQueryKey('sortorder', $sortOrder);
    }

    /**
     * @param string $column
     * @param string $sortOrder
     * @return $this
     * @throws FortnoxQueryException
     */
    public function orderBy(string $column, $sortOrder = 'ascending')
    {
        return $this->sortBy($column, $sortOrder);
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param $key
     * @return $this
     */
    public function filter($key)
    {
        return $this->setQueryKey('filter', $key);
    }

    /**
     * @return array
     */
    public function getLastError(): array
    {
        return self::$lastError ?: ['message' => 'No error set', 'code' => -1];
    }

    /**
     * @param $message
     * @param $code
     */
    protected function setLastError($message, $code)
    {
        self::$lastError = [
            'message' => $message,
            'code' => $code
        ];
    }

    /**
     * @param array $data
     * @return $this
     */
    protected function withRequestOptions(array $data)
    {
        /*
        array_walk_recursive($data, function (&$item) {
            $item = is_null($item) ? '' : $item;
        });
        */

        $this->requestData = $data;
        return $this;
    }

    /**
     * @return bool
     */
    protected function hasRequestData()
    {
        return count($this->requestData) > 0;
    }

    /**
     * @param null $resource
     * @return null|string
     */
    protected function parseResource($resource = null)
    {
        return !$resource ? $this->resource : $resource;
    }


    /**
     * @param string|null $resource
     * @param array$ args
     * @param string $action
     * @return null|string
     */
    protected function makeUri(string &$resource = null, $args = [], string $action = null)
    {
        $this->action = $action;

        if (!$resource) {
            $resource = $this->resource;
        }

        $uri = $resource;

        if (count($args) > 0) {
            $uri .= sprintf('/%s', implode('/', $args));
        }

        $uri .= sprintf('?%s',
            http_build_query($this->query));

        return $uri;
    }


    /**
     * @param $data
     * @param $uri
     * @return string
     */
    protected function handleError($data, $uri)
    {
        $errorCode = data_get($data, 'ErrorInformation.code', data_get($data, 'ErrorInformation.Code', 'Unknown code'));
        $errorMessage = data_get($data, 'ErrorInformation.message', data_get($data, 'ErrorInformation.Message', 'Unknown error'));
        $requestData = json_encode($this->requestData);

        $qtUri = sprintf('%s%s', $this->config['base_uri'], $uri);
        $qtReq = $this->hasRequestData() ? $qtUri . '. ' . $requestData : $qtUri;

        $this->setLastError($errorMessage, $errorCode);

        return sprintf('Error %s. %s. %s %s.',
            $errorCode,
            $errorMessage,
            strtoupper($this->action),
            $qtReq);
    }

    /**
     * @param string $action
     * @param string $resource
     * @param mixed ...$args
     * @return FortnoxResponse
     * @throws FortnoxRequestException
     * @throws InvalidArgumentException
     */
    protected function makeRequest(string $action, string $resource = null, ...$args): FortnoxResponse
    {
        $uri = $this->makeUri($resource, $args, $action);

        // see if we are allowed to process next request
        while ($this->canProcessNextRequest()) {
            usleep(250000);
        }

        do {
            $tryAgain = false;
            $error = false;

            try {

                // prep request options
                if ($this->hasRequestData()) {
                    $requestOptions = [
                        RequestOptions::JSON => $this->requestData
                    ];
                } else {
                    $requestOptions = [];
                }

                // perform request
                $request = $this->getClient()->request($action, $uri, $requestOptions);

                // fetch result
                $content = $request->getBody()->getContents();
            } catch (ClientException $exception) {

                // see if we hit to many requests. Then we don't throw, but we wait 1 second and try again
                if ($exception->getResponse()->getStatusCode() == 429) {
                    $tryAgain = true;
                    sleep(1);
                } else {
                    $content = $exception->getResponse()->getBody()->getContents();
                    $error = true;
                }

            } catch (Exception $exception) {
                throw new FortnoxRequestException(sprintf('General error: %s', $exception->getMessage()));
            }

            if (!$tryAgain) {

                $decodedContent = json_decode($content, true);

                if ($error) {
                    throw new FortnoxRequestException($this->handleError($decodedContent, $uri));
                }

                return new FortnoxResponse($decodedContent, $resource);
            }

        } while ($tryAgain);
    }


    /**
     * @param string $action
     * @param string|null $resource
     * @param mixed ...$args
     * @return FortnoxFileResponse
     * @throws FortnoxRequestException
     */
    protected function makeFileRequest(string $action, string $resource = null, ...$args): FortnoxFileResponse
    {
        $uri = $this->makeUri($resource, $args, $action);

        $curl = curl_init();

        $curlOpt = [
            CURLOPT_URL => $this->config['base_uri'] . $uri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => strtoupper($action),
            CURLOPT_HTTPHEADER => [
                sprintf("Access-Token: %s", $this->config['Access-Token']),
                sprintf("Client-Secret: %s", $this->config['Client-Secret']),
                "Cache-Control: no-cache"
            ]
        ];

        curl_setopt_array($curl, $curlOpt);
        $response = curl_exec($curl);
        curl_close($curl);

        try {
            $decodedContent = json_decode($response, true);
            $error = data_get($decodedContent, 'ErrorInformation.error', false) == 1;
        } catch (Exception $exception) {
            $error = true;
        }

        if ($error) {
            throw new FortnoxRequestException($this->handleError($decodedContent, $uri));
        }

        return new FortnoxFileResponse($response);
    }

    /**
     * Determine if any request slots are available. We use this in conjunction with 429 status code to distribute requests all over the platform
     * This prevent 1 process to hog all fortnox requests
     * @return bool
     */
    protected function canProcessNextRequest()
    {
        $maxSlots = 4;

        for ($i = 0; $i < $maxSlots; $i++) {

            $requestSlotId = 'FortnoxRequestSlot' . $i;

            // slot not occupied? then reserve it and allow the request
            if (!Cache::has($requestSlotId)) {
                Cache::put($requestSlotId, 1, now()->addSeconds(2));
                return true;
            }
        }

        // no slots available
        return false;
    }

}
