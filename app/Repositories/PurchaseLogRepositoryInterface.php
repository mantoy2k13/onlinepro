<?php
namespace App\Repositories;

interface PurchaseLogRepositoryInterface extends SingleKeyModelRepositoryInterface
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
     * @return \App\Models\PurchaseLog[]|\Traversable|array
     */
    public function getEnabledWithConditions($type, $pointAmount, $userId, $order, $direction, $offset, $limit);

    /**
     * @param string $type
     * @param int    $pointAmount
     * @param int    $userId
     *
     * @return int
     */
    public function countEnabledWithConditions($type, $pointAmount, $userId);

    /**
     * @param string $type
     * @param int    $pointAmount
     * @param int    $userId
     * @param string $order
     * @param string $direction
     *
     * @return \App\Models\PurchaseLog[]|\Traversable|array
     */
    public function getAllEnabledWithConditions($type, $pointAmount, $userId, $order, $direction);

    /**
     * @param int $userId
     *
     * @return \App\Models\PurchaseLog[]|\Traversable|array
     */
    public function allExpiredPointExistsByUserId($userId);

    /**
     * @return \App\Models\PurchaseLog[]|\Traversable|array
     */
    public function allExpiredPointExists();

    /**
     * @param $userId
     *
     * @return \App\Models\PurchaseLog
     */
    public function findOldestPointByUserId($userId);

    public function findLastPurchaseByUserId($userId);

    /**
     * @param int $userId
     *
     * @return \App\Models\PurchaseLog
     */
    public function findLastPackagePurchaseByUserId($userId);

    /**
     * @param int    $userId
     * @param string $purchaseType
     * @param int    $package
     * @param bool   $requireRemainPoint
     *
     * @return \App\Models\PurchaseLog
     */
    public function findPurchaseByUserIdTypePackageRamainPoint($userId, $purchaseType, $package, $requireRemainPoint);

    public function findFirstPurchaseByUserIdAndCreatedTime($userId, $expiredTime);
}
