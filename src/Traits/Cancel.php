<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-21
 * Time: 21:45
 */

namespace Tarre\Fortnox\Traits;

use Illuminate\Support\Collection;

trait Cancel
{
    /**
     * @param $DocumentNumber
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function cancel($DocumentNumber): Collection
    {
        return $this->makeRequest('put', null, $DocumentNumber, 'cancel')->toCollection();
    }
}
