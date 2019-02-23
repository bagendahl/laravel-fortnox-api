<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-23
 * Time: 10:26
 */

namespace Tarre\Fortnox\Api\Suppliers;


use Tarre\Fortnox\Contracts\RestGet;
use Tarre\Fortnox\Contracts\RestStore;
use Tarre\Fortnox\Contracts\RestUpdate;

interface FortnoxSupplier extends RestGet, RestStore, RestUpdate
{

}
