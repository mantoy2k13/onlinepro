<?php
namespace App\Repositories;

interface ReviewRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param int    $userId
     * @param int    $teacherId
     * @param int    $rating
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($target, $userId, $teacherId, $rating, $order, $direction, $offset, $limit);

    /**
     * @param int $userId
     * @param int $teacherId
     * @param int $rating
     *
     * @return int
     */
    public function countEnabledWithConditions($target, $userId, $teacherId, $rating);

    public function getAllEnabledWithConditions($target, $userId, $teacherId, $rating, $order, $direction);

    public function findByIdTargetTeacherUser($userId, $teacherId, $target, $bookingId);
}
