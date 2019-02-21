<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 22:45
 */

namespace Tarre\Fortnox\Contracts;


interface BaseApiRepository
{
    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setQueryKey($key, $value);

    /**
     * @param $key
     * @return mixed
     */
    public function filter($key);

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
