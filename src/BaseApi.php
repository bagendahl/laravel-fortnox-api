<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 18:12
 */

namespace Tarre\Fortnox;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Tarre\Fortnox\Contracts\BaseApiRepository;
use Tarre\Fortnox\Exceptions\FortnoxQueryException;
use Tarre\Fortnox\Exceptions\FortnoxRequestException;

/**
 * @property Client client
 */
class BaseApi implements BaseApiRepository
{
    const SINGULAR_REQUEST = 0;
    const PLURAL_REQUEST = 1;

    protected $client = null;
    protected $query = [];
    protected $resource = null;
    protected $resourceSingular = null;
    protected $action = '';
    protected $requestData = [];

    /**
     * BaseApi constructor.
     * @param Client $client
     * @throws FortnoxRequestException
     */
    public function __construct()
    {
        static $client;

        if (!$client) {
            $client = new Client([
                'base_uri' => 'https://api.fortnox.se/3/',
                'headers' => [
                    'Access-Token' => config('laravel-fortnox.fortnox_access_token'),
                    'Client-Secret' => config('laravel-fortnox.fortnox_client_secret'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            ]);
            // set default query limit for 500
            $this->take(config('laravel-fortnox.fortnox_default_limit', 500));
        }

        $this->resource = strtolower(str_plural(class_basename($this)));
        $this->resourceSingular = ucfirst(str_singular($this->resource));
        $this->client = $client;
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
     */
    public function sortBy(string $column, $sortOrder = 'ascending')
    {
        if (!in_array($sortOrder, ['ascending', 'descending'])) {
            throw new \InvalidArgumentException(sprintf('Invalid $sortOrder "%s"', $sortOrder));
        }
        return $this
            ->setQueryKey('sortby', $column)
            ->setQueryKey('sortorder', $sortOrder);
    }

    /**
     * @param string $column
     * @param string $sortOrder
     * @return $this
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
     * @param array $data
     * @return $this
     */
    public function withRequestOptions(array $data)
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
     * @param string $method
     * @param string $resource
     * @param mixed ...$args
     * @return FortnoxResponse
     * @throws FortnoxRequestException
     */
    protected function makeRequest(string $method, string $resource = null, ...$args): FortnoxResponse
    {
        if (!$resource) {
            $resource = $this->resource;
        }

        $uri = $resource;

        if (count($args) > 0) {
            $uri .= sprintf('/%s', implode('/', $args));
        }

        $uri .= sprintf('?%s',
            http_build_query($this->query));

        try {

            if ($this->hasRequestData()) {
                $requestOptions = [
                    RequestOptions::JSON => $this->requestData
                ];
            } else {
                $requestOptions = [];
            }

            $request = $this->getClient()->request($method, $uri, $requestOptions);
            $content = $request->getBody()->getContents();
            $error = false;
        } catch (ClientException $exception) {
            $content = $exception->getResponse()->getBody()->getContents();
            $error = true;
        } catch (GuzzleException $exception) {
            throw new FortnoxRequestException(sprintf('General error: %s', $exception->getMessage()));
        }

        $decodedContent = json_decode($content, true);

        if ($error) {
            throw new FortnoxRequestException(sprintf('Fortnox says: %s. Code: %d. Uri: %s',
                data_get($decodedContent, 'ErrorInformation.message'),
                data_get($decodedContent, 'ErrorInformation.code'),
                $uri));
        }

        return new FortnoxResponse($decodedContent, $resource);

    }


}
