<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-21
 * Time: 21:47
 */

namespace Tarre\Fortnox\Traits;

use Illuminate\Support\Collection;

trait Delete
{

    /**
     * @param $DocumentNumber
     * @return Collection
     */
    public function delete($DocumentNumber): Collection
    {
        return $this->makeRequest('delete', null, $DocumentNumber)->toCollection();
    }
}
