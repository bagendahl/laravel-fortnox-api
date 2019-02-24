<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-24
 * Time: 13:51
 */

namespace Tarre\Fortnox\Api\AbsenceTransactions;


use Illuminate\Support\Collection;
use Tarre\Fortnox\Contracts\BaseApiRepository;
use Tarre\Fortnox\Contracts\RestStore;

interface FortnoxAbsenceTransaction extends BaseApiRepository, RestStore
{
    /**
     * @param $employeeId
     * @param $date
     * @param $causeCode
     * @return Collection
     */
    public function getBy($employeeId, $date, $causeCode): Collection;

    /**
     * @param $employeeId
     * @param $date
     * @param $causeCode
     * @return Collection
     */
    public function update($employeeId, $date, $causeCode): Collection;

    /**
     * @param $employeeId
     * @param $date
     * @param $causeCode
     * @return Collection
     */
    public function delete($employeeId, $date, $causeCode): Collection;

}
