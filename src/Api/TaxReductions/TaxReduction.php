<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-05-23
 * Time: 17:51
 */

namespace Tarre\Fortnox\Api\TaxReductions;

use Tarre\Fortnox\BaseApi;
use Tarre\Fortnox\Traits\Get;
use Tarre\Fortnox\Traits\Store;
use Tarre\Fortnox\Traits\Update;
use Tarre\Fortnox\Traits\Delete;

class TaxReduction extends BaseApi implements FortnoxTaxReduction
{
    protected $resourceSingular = 'taxReduction';
    use Get, Store, Update, Delete;
}
