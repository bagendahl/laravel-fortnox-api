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
use Tarre\Fortnox\Traits\Cancel;
use Tarre\Fortnox\Traits\CommonDocumentActions;
use Tarre\Fortnox\Traits\CreateInvoice;
use Tarre\Fortnox\Traits\Get;
use Tarre\Fortnox\Traits\Store;
use Tarre\Fortnox\Traits\Update;

class Order extends BaseApi implements FortnoxOrder
{
    use Get, Store, Update, Cancel, CreateInvoice, CommonDocumentActions;

}
