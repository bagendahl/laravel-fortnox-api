<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 19:54
 */

namespace Tarre\Fortnox\Api\Orders;


use Tarre\Fortnox\Contracts\RestGet;
use Tarre\Fortnox\Contracts\RestStore;
use Tarre\Fortnox\Contracts\RestUpdate;

interface FortnoxOrder extends RestGet, RestStore, RestUpdate
{

}
