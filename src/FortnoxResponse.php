<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-20
 * Time: 18:57
 */

namespace Tarre\Fortnox;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FortnoxResponse
{

    protected $response;
    protected $metaData = [];

    public function __construct(array $response, string $resource)
    {
        $resource = ucfirst($resource);

        $this->metaData = [
            'TotalResources' => data_get($response,'MetaInformation.@TotalResources', 1),
            'TotalPages' => data_get($response,'MetaInformation.@TotalPages', 1),
            'CurrentPage' => data_get($response,'MetaInformation.@CurrentPage', 1)
        ];


        $this->response = data_get($response, str_plural($resource), data_get($response, str_singular($resource), []));
    }

    /**
     * @return Collection
     */
    public function toCollection(): Collection
    {
        return collect($this->response);
    }

    /**
     * @param int $perPage
     * @param null $currentPage
     * @return LengthAwarePaginator
     */
    public function toPagination($perPage = 50): LengthAwarePaginator
    {
        $collection = $this->toCollection();
        return new LengthAwarePaginator($collection, $collection->count(), $perPage, $this->metaData['CurrentPage']);
    }

}
