<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-23
 * Time: 10:21
 */

namespace Tarre\Fortnox\Api\Articles;
use Tarre\Fortnox\Contracts\RestDelete;
use Tarre\Fortnox\Contracts\RestUpdate;
use Tarre\Fortnox\Contracts\RestStore;
use Tarre\Fortnox\Contracts\RestGet;
use Tarre\Fortnox\Contracts\BaseApiRepository;

interface FortnoxArticles extends BaseApiRepository, RestGet, RestStore, RestUpdate, RestDelete
{

}
