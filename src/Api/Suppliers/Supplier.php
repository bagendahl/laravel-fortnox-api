<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-23
 * Time: 10:26
 */

namespace Tarre\Fortnox\Api\Suppliers;


use Tarre\Fortnox\BaseApi;
use Tarre\Fortnox\Traits\Get;
use Tarre\Fortnox\Traits\Store;
use Tarre\Fortnox\Traits\Update;

class Supplier extends BaseApi implements FortnoxSupplier
{
    use Get, Update, Store;
}
