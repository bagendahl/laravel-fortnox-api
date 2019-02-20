<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 22:45
 */

namespace Tarre\Fortnox\Contracts;

use GuzzleHttp\Client;
use Tarre\Fortnox\Exceptions\FortnoxRequestException;
use Tarre\Fortnox\FortnoxResponse;

interface BaseApiRepository
{
    public function setQueryKey($key, $value);

    /**
     * @param $number
     * @return $this
     */
    public function take($number);
    /**
     * @param $number
     * @return $this
     */
    public function skip($number);
    /**
     * @param $number
     * @return $this
     */
    public function page($number);
    /**
     * @param string $column
     * @param string $sortOrder
     * @return $this
     */
    public function sortBy(string $column, $sortOrder = 'ascending');
    /**
     * @param string $column
     * @param string $sortOrder
     * @return $this
     */
    public function orderBy(string $column, $sortOrder = 'ascending');

}
