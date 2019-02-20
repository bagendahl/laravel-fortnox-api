<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 20:00
 */

namespace Tarre\Fortnox\Contracts;


interface RestStore
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function store(array $attributes);

}
