<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-23
 * Time: 01:55
 */

namespace Tarre\Fortnox\api\Customers;


use Tarre\Fortnox\BaseApi;
use Tarre\Fortnox\Traits\Delete;
use Tarre\Fortnox\Traits\Get;
use Tarre\Fortnox\Traits\Store;
use Tarre\Fortnox\Traits\Update;

class Customer extends BaseApi implements FortnoxCustomer
{
    use Store, Get, Update, Delete;

}
