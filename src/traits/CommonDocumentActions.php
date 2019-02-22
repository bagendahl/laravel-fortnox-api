<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-22
 * Time: 22:05
 */

namespace Tarre\Fortnox\Traits;

use Illuminate\Support\Collection;

trait CommonDocumentActions
{

    /**
     * Sends an e-mail to the customer with an attached PDF document of the offer. You can use the fieldEmailInformation to customize the e-mail message on each offer.
     * @param $DocumentNumber
     * @return Collection
     */
    public function email($DocumentNumber): Collection
    {
        return $this->makeRequest('put', null, $DocumentNumber, 'email')->toCollection();
    }

    /**
     * This action returns a PDF document with the current template that is used by the specific document. Note that this action also sets the field Sent as true.
     * @param $DocumentNumber
     * @return Collection
     */
    public function print($DocumentNumber): Collection
    {
        return $this->makeRequest('put', null, $DocumentNumber, 'print')->toCollection();
    }

    /**
     * This action is used to set the field Sent as true from an external system without generating a PDF.
     * @return Collection
     */
    public function externalPrint($DocumentNumber): Collection
    {
        return $this->makeRequest('put', null, $DocumentNumber, 'externalprint')->toCollection();
    }

    /**
     * This action returns a PDF document with the current template that is used by the specific document. Apart from the action print, this action doesn’t set the field Sent as true.
     * @return Collection
     */
    public function preview($DocumentNumber): Collection
    {
        return $this->makeRequest('put', null, $DocumentNumber, 'preview')->toCollection();
    }
}
