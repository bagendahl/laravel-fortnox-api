<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-21
 * Time: 21:47
 */

namespace Tarre\Fortnox\Traits;


trait Update
{
    /**
     * @param $DocumentNumber
     * @param array $attributes
     * @return mixed|void
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function update($DocumentNumber, array $attributes)
    {
        $request = [
            $this->resourceSingular => $attributes
        ];

        $this->makeRequest('put', 'orders', $DocumentNumber, $request);
    }
}
