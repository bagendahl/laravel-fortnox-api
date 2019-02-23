<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-23
 * Time: 10:22
 */

namespace Tarre\Fortnox\Api\Articles;

use Tarre\Fortnox\Api\Customers\FortnoxCustomer;
use Tarre\Fortnox\BaseApi;
use Tarre\Fortnox\Traits\Delete;
use Tarre\Fortnox\Traits\Get;
use Tarre\Fortnox\Traits\Store;
use Tarre\Fortnox\Traits\Update;

class Articles  extends BaseApi implements FortnoxCustomer
{
    use Store, Get, Update, Delete;
}
