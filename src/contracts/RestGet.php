<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 20:00
 */

namespace Tarre\Fortnox\Contracts;

use Illuminate\Support\Collection;

interface RestGet
{

    public function get(): Collection;
    public function getByDocumentNumber($DocumentNumber): Collection;

}
