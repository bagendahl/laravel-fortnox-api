<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-23
 * Time: 10:28
 */

namespace Tarre\Fortnox\Api\Invoices;

use Illuminate\Support\Collection;
use Tarre\Fortnox\Contracts\BaseApiRepository;
use Tarre\Fortnox\Contracts\Cancel;
use Tarre\Fortnox\Contracts\CommonDocumentActions;
use Tarre\Fortnox\Contracts\RestGet;
use Tarre\Fortnox\Contracts\RestStore;
use Tarre\Fortnox\Contracts\RestUpdate;

interface FortnoxInvoice extends BaseApiRepository, Cancel, CommonDocumentActions, RestGet, RestStore, RestUpdate
{

    public function bookKeep($documentNumber): Collection;
}
