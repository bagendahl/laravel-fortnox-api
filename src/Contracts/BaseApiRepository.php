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
     * @return $this
     */
    public function setQueryKey($key, $value);

    /**
     * It’s possible to filter the results so that only specific items will be returned. The available filters is listed under the section “Filters” in the documentation for each resource.
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
     * Because of performance reasons both on our side and on yours, we encourage you to use the parameter limit as much as possible. This method correspond to they key "Limit"
     * @param $number
     * @return $this
     */
    public function skip($number);
    /**
     * Because of performance reasons both on our side and on yours, we encourage you to use the parameter limit as much as possible. This method correspond to they key "Offset"
     * @param $number
     * @return $this
     */
    public function page($number);
    /**
     * A result can be sorted, either ascending or descending, by specific fields. These fields are listed in the table under the section “Fields” in the documentation for each resource.
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
