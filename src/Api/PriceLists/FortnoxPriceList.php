<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-03-22
 * Time: 16:10
 */

namespace Tarre\Fortnox\Api\PriceLists;

use Tarre\Fortnox\Contracts\RestGet;
use Tarre\Fortnox\Contracts\RestStore;
use Tarre\Fortnox\Contracts\RestUpdate;
use Tarre\Fortnox\Contracts\BaseApiRepository;

interface FortnoxPriceList extends BaseApiRepository, RestGet, RestStore, RestUpdate
{

}
