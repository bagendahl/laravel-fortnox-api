<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-21
 * Time: 21:54
 */

namespace Tarre\Fortnox\Contracts;


use Illuminate\Support\Collection;

interface Cancel
{
    /**
     * @param $DocumentNumber
     * @return Collection
     */
    public function cancel($DocumentNumber);
}
