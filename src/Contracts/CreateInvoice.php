<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-22
 * Time: 22:09
 */

namespace Tarre\Fortnox\Contracts;

use Illuminate\Support\Collection;

interface CreateInvoice
{
    /**
     * @param $DocumentNumber
     * @return Collection
     */
    public function createInvoice($DocumentNumber): Collection;
}
