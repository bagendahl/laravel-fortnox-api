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
    public function store(array $attributes);

}
