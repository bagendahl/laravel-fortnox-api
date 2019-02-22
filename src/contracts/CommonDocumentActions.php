<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-22
 * Time: 21:59
 */

namespace Tarre\Fortnox\Contracts;


use Illuminate\Support\Collection;

interface CommonDocumentActions
{
    /**
     * Sends an e-mail to the customer with an attached PDF document of the offer. You can use the fieldEmailInformation to customize the e-mail message on each offer.
     * @param $DocumentNumber
     * @return Collection
     */
    public function email($DocumentNumber): Collection;

    /**
     * This action returns a PDF document with the current template that is used by the specific document. Note that this action also sets the field Sent as true.
     * @param $DocumentNumber
     * @return Collection
     */
    public function print($DocumentNumber): Collection;

    /**
     * This action is used to set the field Sent as true from an external system without generating a PDF.
     * @param $DocumentNumber
     * @return Collection
     */
    public function externalPrint($DocumentNumber): Collection;

    /**
     * This action returns a PDF document with the current template that is used by the specific document. Apart from the action print, this action doesn’t set the field Sent as true.
     * @param $DocumentNumber
     * @return Collection
     */
    public function preview($DocumentNumber): Collection;
}
