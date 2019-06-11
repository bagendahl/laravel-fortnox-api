<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-06-11
 * Time: 11:12
 */

namespace Tarre\Fortnox\Api\CostCenter;

use Tarre\Fortnox\BaseApi;
use Tarre\Fortnox\Traits\Delete;
use Tarre\Fortnox\Traits\Get;
use Tarre\Fortnox\Traits\Store;
use Tarre\Fortnox\Traits\Update;

class CostCenter extends BaseApi implements FortnoxCostCenter
{
    protected $resourceSingular = 'CostCenter';
    use Store, Get, Update, Delete;
}
