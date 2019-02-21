<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-21
 * Time: 21:47
 */

namespace Tarre\Fortnox\Traits;


use Illuminate\Support\Collection;

trait Update
{
    /**
     * @param $DocumentNumber
     * @param array $attributes
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function update($DocumentNumber, array $attributes)
    {
        $request = [
            $this->resourceSingular => $attributes
        ];

        return $this->withRequestOptions($request)->makeRequest('put', null, $DocumentNumber)->toCollection();
    }
}
