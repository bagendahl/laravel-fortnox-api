<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 20:01
 */

namespace Tarre\Fortnox\Contracts;


use Illuminate\Support\Collection;

interface RestUpdate
{
    /**
     * @param $DocumentNumber
     * @param array $attributes
     * @return Collection
     */
    public function update($DocumentNumber, array $attributes): Collection;
}
