<?php
namespace App\Repositories;

use App\Models\Notification;
use App\Models\User;

interface UserNotificationRepositoryInterface extends NotificationRepositoryInterface
{
    /**
     * @param string $categoryType
     * @param string $type
     * @param User   $user
     * @param int    $read
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($categoryType, $type, $user, $read, $order, $direction, $offset, $limit);

    /**
     * @param $categoryType
     * @param $type
     * @param $user
     * @param $read
     *
     * @return int
     */
    public function countEnabledWithConditions($categoryType, $type, $user, $read);

    /**
     * @param $id
     * @param $user
     *
     * @return Notification
     */
    public function nextNotice($id, $userId, $userCreatedAt);

    /**
     * @param $id
     * @param $user
     *
     * @return Notification
     */
    public function preNotice($id, $userId, $userCreatedAt);

    public function findByIdAndUserId($id, $userId);
}
