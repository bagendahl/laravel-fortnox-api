<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-24
 * Time: 13:53
 */

namespace Tarre\Fortnox\Api\AbsenceTransactions;


use Illuminate\Support\Collection;
use Tarre\Fortnox\BaseApi;
use Tarre\Fortnox\Traits\Store;

class AbsenceTransaction extends BaseApi implements FortnoxAbsenceTransaction
{
    use Store;

    /**
     * @param $employeeId
     * @param $date
     * @param $causeCode
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function getBy($employeeId, $date, $causeCode): Collection
    {
        return $this->makeRequest('get', null, $employeeId, $date, $causeCode)->toCollection();
    }

    /**
     * @param $employeeId
     * @param $date
     * @param $causeCode
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function update($employeeId, $date, $causeCode): Collection
    {
        return $this->makeRequest('put', null, $employeeId, $date, $causeCode)->toCollection();
    }

    /**
     * @param $employeeId
     * @param $date
     * @param $causeCode
     * @return Collection
     * @throws \Tarre\Fortnox\Exceptions\FortnoxRequestException
     */
    public function delete($employeeId, $date, $causeCode): Collection
    {
        return $this->makeRequest('delete', null, $employeeId, $date, $causeCode)->toCollection();

    }
}
