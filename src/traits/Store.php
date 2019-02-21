<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-21
 * Time: 21:45
 */

namespace Tarre\Fortnox\Traits;


trait Store
{

    /**
     * @param array $attributes
     * @return mixed|void
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function store(array $attributes)
    {
        $request = [
            $this->resourceSingular => $attributes
        ];

        $this->makeRequest('post', null, $request);
    }
}
