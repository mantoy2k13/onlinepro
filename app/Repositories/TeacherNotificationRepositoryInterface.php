<?php
namespace App\Repositories;

interface TeacherNotificationRepositoryInterface extends NotificationRepositoryInterface
{
    /**
     * @param string $title
     * @param string $categoryType
     * @param string $type
     * @param int    $userId
     * @param int    $read
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($title, $categoryType, $type, $userId, $read, $order, $direction, $offset, $limit);

    /**
     * @param $title
     * @param $categoryType
     * @param $type
     * @param $userId
     * @param $read
     *
     * @return int
     */
    public function countEnabledWithConditions($title, $categoryType, $type, $userId, $read);
}
