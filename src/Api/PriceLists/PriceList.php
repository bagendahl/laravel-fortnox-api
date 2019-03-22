<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-03-22
 * Time: 16:23
 */

namespace Tarre\Fortnox\Api\PriceLists;

use Tarre\Fortnox\BaseApi;
use Tarre\Fortnox\Traits\Get;
use Tarre\Fortnox\Traits\Store;
use Tarre\Fortnox\Traits\Update;

class PriceList extends BaseApi implements FortnoxPriceList
{
    use Get, Store, Update;
}
