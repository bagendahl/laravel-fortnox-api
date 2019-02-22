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
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function createInvoice(): Collection
    {
        return $this->makeRequest('put', null, 'createinvoice')->toCollection();
    }
}
