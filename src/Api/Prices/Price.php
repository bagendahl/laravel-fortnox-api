<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-05-04
 * Time: 16:51
 */

namespace Tarre\Fortnox\Api\Prices;

use Illuminate\Support\Collection;
use Tarre\Fortnox\BaseApi;
use Tarre\Fortnox\Traits\Store;
use Tarre\Fortnox\Traits\Update;

class Price extends BaseApi implements FortnoxPrice
{
    use Store, Update;

    /**
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function get(): Collection
    {
        return $this->makeRequest('get')->toCollection();
    }

    /**
     * Get by sublist
     * @param $priceList
     * @param null $articleNumber
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function getByPriceList($priceList, $articleNumber = null): Collection
    {
        return $this->makeRequest('get', null, 'sublist', $priceList, $articleNumber)->toCollection();
    }

}
