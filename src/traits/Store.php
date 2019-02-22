<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-21
 * Time: 21:45
 */

namespace Tarre\Fortnox\Traits;


use Illuminate\Support\Collection;

trait Store
{

    /**
     * @param array $attributes
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function store(array $attributes): Collection
    {
        $request = [
            $this->resourceSingular => $attributes
        ];

        return $this->withRequestOptions($request)->makeRequest('post', null)->toCollection();
    }
}
