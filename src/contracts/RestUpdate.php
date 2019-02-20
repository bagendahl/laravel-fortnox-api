<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 20:01
 */

namespace Tarre\Fortnox\Contracts;


interface RestUpdate
{
    public function update($DocumentNumber, array $attributes);
}
