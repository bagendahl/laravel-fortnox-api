<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-23
 * Time: 01:52
 */

namespace Tarre\Fortnox\Contracts;

use Illuminate\Support\Collection;

interface RestDelete
{
    /**
     * @param $DocumentNumber
     * @return Collection
     */
    public function delete($DocumentNumber): Collection;

}
