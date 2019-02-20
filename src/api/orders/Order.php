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

    /**
     * @param $DocumentNumber
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function getByDocumentNumber($DocumentNumber): Collection
    {
        return $this->makeRequest('get', 'orders', $DocumentNumber)->toCollection();

    }

    /**
     * @param array $attributes
     * @return mixed|void
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function store(array $attributes)
    {
        $request = [
            'Order' => $attributes
        ];

        $this->makeRequest('post', 'orders', $request);
    }

    /**
     * @param $DocumentNumber
     * @param array $attributes
     * @return mixed|void
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function update($DocumentNumber, array $attributes)
    {
        $request = [
            'Order' => $attributes
        ];

        $this->makeRequest('put', 'orders', $DocumentNumber, $request);
    }
}
