<?php
namespace App\Repositories;

interface BookingRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param int    $userId
     * @param int    $teacherId
     * @param string $status
     * @param string $dateFrom
     * @param string $dateTo
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($userId, $teacherId, $statusIncluded, $statusExcluded, $dateFrom, $dateTo, $order, $direction, $offset, $limit);

    /**
     * @param int    $userId
     * @param int    $teacherId
     * @param string $status
     * @param string $dateFrom
     * @param string $dateTo
     * @param string $order
     * @param string $direction
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getAllEnabledWithConditions($userId, $teacherId, $statusIncluded, $statusExcluded, $dateFrom, $dateTo, $order, $direction);

    public function getAllBookingWithConditions(
        $userId,
        $teacherId,
        $statusIncluded,
        $statusExcluded,
        $startDateFrom,
        $startDateTo,
        $createdDateFrom,
        $createdDateTo,
        $order,
        $direction
    );

    /**
     * @param int    $userId
     * @param int    $teacherId
     * @param string $status
     * @param string $dateFrom
     * @param string $dateTo
     *
     * @return int
     */
    public function countEnabledWithConditions($userId, $teacherId, $status, $statusNot, $dateFrom, $dateTo);

    public function allBookingByPointPackageAndUserIdToday($userId, $typePurchase, $package);

    public function findBookingBonusSignup($userId);
}
