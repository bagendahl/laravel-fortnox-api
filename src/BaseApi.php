<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 18:12
 */

namespace Tarre\Fortnox;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Tarre\Fortnox\Exceptions\FortnoxRequestException;

/**
 * @property Client client
 */
class BaseApi
{
    const SINGULAR_REQUEST = 0;
    const PLURAL_REQUEST = 1;

    protected $client = null;
    protected $query = [];

    /**
     * BaseApi constructor.
     * @param Client $client
     */
    public function __construct()
    {
        static $client;

        if (!$client) {
            $client = new Client([
                'base_uri' => 'https://api.fortnox.se/3/',
                'headers' => [
                    'Access-Token' => env('FORTNOX_ACCESS_TOKEN'),
                    'Client-Secret' => env('FORTNOX_CLIENT_SECRET'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            ]);
        }

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
     */
    public function take($number)
    {
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
     * @return BaseApi
     */
    public function orderBy(string $column, $sortOrder = 'ascending')
    {
        return $this->sortBy($column, $sortOrder);
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }


    /**
     * @param string $method
     * @param string $resource
     * @param mixed ...$args
     * @return FortnoxResponse
     * @throws FortnoxRequestException
     */
    protected function makeRequest(string $method, string $resource, ...$args): FortnoxResponse
    {
        $uri = sprintf('%s?%s',
            implode('/', $args),
            http_build_query($this->query));

        try {
            $request = $this->getClient()->request($method, $resource . $uri);
            $content = $request->getBody()->getContents();
            return new FortnoxResponse($content, $resource);
        } catch (GuzzleException $e) {
            throw new FortnoxRequestException('Whoops');
        }

    }

}
