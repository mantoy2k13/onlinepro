<?php
namespace App\Repositories;

interface PointLogRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param string $type
     * @param int    $pointAmount
     * @param int    $userId
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\PointLog[]|\Traversable|array
     */
    public function getEnabledWithConditions($type, $pointAmount, $userId, $order, $direction, $offset, $limit);

    /**
     * @param string $type
     * @param int    $pointAmount
     * @param int    $userId
     * @param string $order
     * @param string $direction
     *
     * @return \App\Models\PointLog[]|\Traversable|array
     */
    public function getAllEnabledWithConditions($type, $pointAmount, $userId, $order, $direction);

    /**
     * @param string $type
     * @param int    $pointAmount
     * @param int    $userId
     *
     * @return int
     */
    public function countEnabledWithConditions($type, $pointAmount, $userId);

    /**
     * @param int $userId
     *
     * @return int
     */
    public function summatePointsByUser($userId);

    /**
     * @param int $purchaseLogId
     *
     * @return \App\Models\PointLog[]|\Traversable|array
     */
    public function allPointBookingTodayByPurchaseLog($purchaseLogId);
}
