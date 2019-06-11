<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-06-11
 * Time: 11:12
 */

namespace Tarre\Fortnox\Api\CostCenter;

use Tarre\Fortnox\Contracts\RestDelete;
use Tarre\Fortnox\Contracts\RestUpdate;
use Tarre\Fortnox\Contracts\RestStore;
use Tarre\Fortnox\Contracts\RestGet;
use Tarre\Fortnox\Contracts\BaseApiRepository;

interface FortnoxCostCenter extends BaseApiRepository, RestGet, RestStore, RestUpdate, RestDelete
{

}
