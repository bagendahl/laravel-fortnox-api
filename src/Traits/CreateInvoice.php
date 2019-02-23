<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-22
 * Time: 22:11
 */

namespace Tarre\Fortnox\Traits;


use Illuminate\Support\Collection;

trait CreateInvoice
{
    /**
     * @param $DocumentNumber
     * @return Collection
     */
    public function createInvoice($DocumentNumber): Collection
    {
        return $this->makeRequest('put', null, $DocumentNumber, 'createinvoice')->toCollection();
    }
}
