<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-05-23
 * Time: 17:51
 */

namespace Tarre\Fortnox\Api\TaxReductions;

use Tarre\Fortnox\Contracts\BaseApiRepository;
use Tarre\Fortnox\Contracts\RestGet;
use Tarre\Fortnox\Contracts\RestStore;
use Tarre\Fortnox\Contracts\RestUpdate;
use Tarre\Fortnox\Contracts\RestDelete;

interface FortnoxTaxReduction extends BaseApiRepository, RestGet, RestStore, RestUpdate, RestDelete
{

}
