<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-23
 * Time: 01:55
 */

namespace Tarre\Fortnox\api\Customers;


use Tarre\Fortnox\Contracts\RestDelete;
use Tarre\Fortnox\Contracts\RestUpdate;
use Tarre\Fortnox\Contracts\RestStore;
use Tarre\Fortnox\Contracts\RestGet;
use Tarre\Fortnox\Contracts\BaseApiRepository;

interface FortnoxCustomer extends BaseApiRepository, RestGet, RestStore, RestUpdate, RestDelete
{

}
