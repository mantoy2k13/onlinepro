<?php
namespace App\Services;

interface PointServiceInterface extends BaseServiceInterface
{
    /**
     * @param int $userId
     *
     * @return int
     */
    public function updateUserPoints($userId);

    /**
     * @param int $userId
     *
     * @return void
     */
    public function expirePoints($userId = 0);

    /**
     * @param int $userId
     * @param int $amount
     * @param int $bookingId
     *
     * @return bool
     */
    public function consumePoints($userId, $amount, $bookingId = 0);

    /**
     * @param int    $userId
     * @param int    $amount
     * @param string $paymentMethodType
     * @param string $purchaseInfo
     *
     * @return \App\Models\PointLog|null
     */
    public function purchasePoints($userId, $amount, $paymentMethodType, $purchaseInfo);

    /**
     * @param \App\Models\PurchaseLog $purchaseLog
     *
     * @return \App\Models\PurchaseLog
     */
    public function setPointExpiredAt($purchaseLog);

    /**
     * @param int $userId
     * @param int $amount
     * @param int $bookingId
     *
     * @return bool
     */
    public function refundPoints($userId, $amount, $bookingId = 0);

    /**
     * @param int    $userId
     * @param int    $pointLog
     * @param string $action
     *
     * @return \App\Models\PurchaseLog
     */
    public function addPointsByAdmin($userId, $pointLog, $action = 'new');

    /**
     * @param int $amount
     *
     * @return array
     */
    public function getPackageFromAmount($amount);

    /**
     * @param int $point
     *
     * @return array
     */
    public function getPackageFromPoint($point);

    /**
     * @param int $userId
     *
     * @return bool
     */
    public function addPointSignupUser($userId);

    /**
     * @param int $userId
     * @param int $amount
     *
     * @return bool
     */
    public function subExpiredPoints($userId, $amount);
}
