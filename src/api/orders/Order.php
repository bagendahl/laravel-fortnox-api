<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 19:55
 */

namespace Tarre\Fortnox\Api\Orders;


use Illuminate\Support\Collection;
use Tarre\Fortnox\BaseApi;

class Order extends BaseApi implements FortnoxOrder
{

    /**
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function get(): Collection
    {
        return $this->makeRequest('get', 'orders')->toCollection();
    }

    public function getByDocumentNumber($DocumentNumber): Collection
    {
        // TODO: Implement getByDocumentNumber() method.
    }

    public function store(array $attributes)
    {
        // TODO: Implement store() method.
    }

    public function update($DocumentNumber, array $attributes)
    {
        // TODO: Implement update() method.
    }
}
