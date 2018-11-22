<?php
namespace App\Repositories;

interface EmailLogRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param $oldEmail
     * @param $newEmail
     * @param $userId
     * @param $status
     * @param $validationCode
     * @param $order
     * @param $direction
     * @param $offset
     * @param $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions(
        $oldEmail,
        $newEmail,
        $userId,
        $status,
                                             $validationCode,
        $order,
        $direction,
        $offset,
        $limit
    );

    /**
     * @param $oldEmail
     * @param $newEmail
     * @param $userId
     * @param $status
     * @param $validationCode
     *
     * @return int
     */
    public function countEnabledWithConditions($oldEmail, $newEmail, $userId, $status, $validationCode);

    public function getEmailLogByValidationCode($validationCode);
}
