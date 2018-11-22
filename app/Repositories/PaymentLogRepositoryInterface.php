<?php
namespace App\Repositories;

interface PaymentLogRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param string $status
     * @param int    $paidAmount
     * @param int    $teacherId
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($status, $paidAmount, $teacherId, $paidForMonth, $order, $direction, $offset, $limit);

    /**
     * @param string $status
     * @param int    $paidAmount
     * @param int    $teacherId
     *
     * @return int
     */
    public function countEnabledWithConditions($status, $paidAmount, $teacherId, $paidForMonth);

    public function getAllEnabledWithConditions($paidAmount, $teacherId, $status, $paidForMonth, $order, $direction);
}
