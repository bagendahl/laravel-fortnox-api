<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-05-04
 * Time: 16:52
 */

namespace Tarre\Fortnox\Api\Prices;

use Illuminate\Support\Collection;
use Tarre\Fortnox\Contracts\RestStore;
use Tarre\Fortnox\Contracts\RestUpdate;
use Tarre\Fortnox\Contracts\BaseApiRepository;

interface FortnoxPrice extends BaseApiRepository, RestStore, RestUpdate
{
    public function get(): Collection;
    public function getByPriceList($priceList, $articleNumber = null): Collection;
}
