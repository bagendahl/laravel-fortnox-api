<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-21
 * Time: 21:43
 */

namespace Tarre\Fortnox\Traits;


use Illuminate\Support\Collection;

trait Get
{
    /**
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function get(): Collection
    {
        return $this->makeRequest('get')->toCollection();
    }

    /**
     * @param $DocumentNumber
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function getByDocumentNumber($DocumentNumber): Collection
    {
        return $this->makeRequest('get', null, $DocumentNumber)->toCollection();
    }
}
