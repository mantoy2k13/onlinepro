<?php
namespace App\Services\Production;

use App\Models\Notification;
use App\Models\PointLog;
use App\Models\PurchaseLog;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\PointLogRepositoryInterface;
use App\Repositories\PurchaseLogRepositoryInterface;
use App\Repositories\UserNotificationRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\MailServiceInterface;
use App\Services\PointServiceInterface;

class PointService extends BaseService implements PointServiceInterface
{
    /** @var \App\Repositories\PurchaseLogRepositoryInterface $purchaseLogRepository */
    protected $purchaseLogRepository;

    /** @var \App\Repositories\PointLogRepositoryInterface $pointLogRepository */
    protected $pointLogRepository;

    /** @var UserRepositoryInterface $userRepository */
    protected $userRepository;

    /** @var \App\Services\MailServiceInterface $mailService */
    protected $mailService;

    /** @var UserNotificationRepositoryInterface $userNotificationRepository */
    protected $userNotificationRepository;

    /** @var BookingRepositoryInterface $bookingRepository */
    protected $bookingRepository;

    public function __construct(
        PurchaseLogRepositoryInterface $purchaseLogRepository,
        PointLogRepositoryInterface $pointLogRepository,
        UserRepositoryInterface $userRepository,
        MailServiceInterface $mailService,
        UserNotificationRepositoryInterface $userNotificationRepository,
        BookingRepositoryInterface $bookingRepository
    ) {
        $this->pointLogRepository         = $pointLogRepository;
        $this->purchaseLogRepository      = $purchaseLogRepository;
        $this->userRepository             = $userRepository;
        $this->userNotificationRepository = $userNotificationRepository;
        $this->mailService                = $mailService;
        $this->bookingRepository          = $bookingRepository;
    }

    public function updateUserPoints($userId)
    {
        $user = $this->userRepository->find($userId);
        if (empty($user)) {
            return 0;
        }
        $point = $this->pointLogRepository->summatePointsByUser($userId);
        $this->userRepository->update($user, ['points' => $point]);

        return $point;
    }

    public function expirePoints($userId = 0)
    {
        $expiredUserIds      = [];
        $expiredPurchaseLogs = empty($user) ? $this->purchaseLogRepository->allExpiredPointExists() : $this->purchaseLogRepository->allExpiredPointExistsByUserId($userId);
        foreach ($expiredPurchaseLogs as $expiredPurchaseLog) {
            $targetUserId = $expiredPurchaseLog->user_id;
            if (!array_key_exists($targetUserId, $expiredUserIds)) {
                $expiredUserIds[$targetUserId] = 0;
            }
            $expiredUserIds[$targetUserId] = $expiredUserIds[$targetUserId] + $expiredPurchaseLog->remaining_point_amount;
            $this->pointLogRepository->create([
                'user_id'         => $targetUserId,
                'point_amount'    => -1 * $expiredPurchaseLog->remaining_point_amount,
                'type'            => PointLog::TYPE_EXPIRED,
                'description'     => '',
                'booking_id'      => 0,
                'purchase_log_id' => $expiredPurchaseLog->id,
            ]);
            $this->purchaseLogRepository->update($expiredPurchaseLog, ['remaining_point_amount' => 0]);
        }

        foreach ($expiredUserIds as $expiredUserId => $amount) {
            $this->updateUserPoints($expiredUserId);
            $expiredPoints = -1 * $amount;
            $userNotice    = ['user_id' => $expiredUserId,
                'category_type'         => Notification::CATEGORY_TYPE_EXPIRE,
                'type'                  => Notification::TYPE_POINT_ALERT,
                'title'                 => trans('user.notifications.expired.title'),
                'content'               => trans(
                    'user.notifications.expired.content',
                    ['amount' => $expiredPoints]
                ),
                'sent_at' => \DateTimeHelper::now(),
                'data'    => json_encode(''),
            ];
            $userNote = $this->userNotificationRepository->create($userNotice);
            $user     = $this->userRepository->find($expiredUserId);
            $this->mailService->sendEmailExpiredUser($user, $expiredPoints);
        }
    }

    public function consumePoints($userId, $amount, $bookingId = 0)
    {
        $this->updateUserPoints($userId);
        $user = $this->userRepository->find($userId);
        if (empty($user) or $user->points < $amount) {
            return false;
        }
        $bookingSignUpPoint = $this->bookingRepository->findBookingBonusSignup($userId);
        $restAmount         = $amount;
        if (!empty($bookingSignUpPoint)) {
            while ($restAmount > 0) {
                $targetPurchaseLog = $this->purchaseLogRepository->findFirstPurchaseByUserIdAndCreatedTime($userId, null);

                if (empty($targetPurchaseLog)) {
                    $useAmount     = $restAmount;
                    $purchaseLogId = 0;
                } else {
                    $targetPurchaseLog = $this->getPurchaseBookingAble($targetPurchaseLog);

                    if (empty($targetPurchaseLog)) {
                        $useAmount     = $restAmount;
                        $purchaseLogId = 0;
                    } else {
                        $useAmount = ($targetPurchaseLog->remaining_point_amount >= $restAmount) ? $restAmount : $targetPurchaseLog->remaining_point_amount;
                        $this->purchaseLogRepository->update($targetPurchaseLog, [
                            'remaining_point_amount' => $targetPurchaseLog->remaining_point_amount - $useAmount,
                        ]);
                        $purchaseLogId = $targetPurchaseLog->id;
                    }
                }

                $this->pointLogRepository->create([
                    'user_id'         => $userId,
                    'point_amount'    => -1 * $useAmount,
                    'type'            => PointLog::TYPE_BOOKING,
                    'description'     => '',
                    'booking_id'      => $bookingId,
                    'purchase_log_id' => $purchaseLogId,
                ]);
                $restAmount = $restAmount - $useAmount;
            }
        } else {
            $this->pointLogRepository->create([
                'user_id'         => $userId,
                'point_amount'    => -1,
                'type'            => PointLog::TYPE_BOOKING,
                'description'     => '',
                'booking_id'      => $bookingId,
                'purchase_log_id' => 0,
            ]);
        }

        $this->updateUserPoints($userId);

        return true;
    }

    public function refundPoints($userId, $amount, $bookingId = 0)
    {
        $this->updateUserPoints($userId);
        $user = $this->userRepository->find($userId);
        if (empty($user)) {
            return false;
        }
        $booking             = $this->bookingRepository->find($bookingId);
        $targetPurchaseLogId = 0;
        if (!empty($booking) and $booking->pointLog->purchase_log_id != 0) {
            $targetPurchaseLog = $this->purchaseLogRepository->find($booking->pointLog->purchase_log_id);
            if (empty($targetPurchaseLog)) {
                $targetPurchaseLogId = 0;
            } else {
                $targetPurchaseLogId = $targetPurchaseLog->id;
                $this->purchaseLogRepository->update($targetPurchaseLog, [
                    'remaining_point_amount' => $targetPurchaseLog->remaining_point_amount + $amount,
                ]);
            }
        }

        $this->pointLogRepository->create([
            'user_id'         => $userId,
            'point_amount'    => $amount,
            'type'            => PointLog::TYPE_REFUND,
            'description'     => '',
            'booking_id'      => $bookingId,
            'purchase_log_id' => $targetPurchaseLogId,
        ]);

        $this->updateUserPoints($userId);

        return true;
    }

    public function purchasePoints($userId, $amount, $paymentMethodType, $purchaseInfo)
    {
        $user = $this->userRepository->find($userId);
        if (empty($user)) {
            return null;
        }

        $createdAt   = \DateTimeHelper::now();
        $purchaseLog = $this->purchaseLogRepository->create([
            'user_id'                => $userId,
            'purchase_method_type'   => $paymentMethodType,
            'point_amount'           => $amount,
            'purchase_info'          => json_encode($purchaseInfo),
            'point_expired_at'       => $createdAt,
            'created_at'             => $createdAt,
            'remaining_point_amount' => $amount,
        ]);
        $purchaseLog = $this->setPointExpiredAt($purchaseLog);

        $pointLog = $this->pointLogRepository->create([
            'user_id'         => $userId,
            'point_amount'    => $amount,
            'type'            => PointLog::TYPE_PURCHASE,
            'description'     => '',
            'booking_id'      => 0,
            'purchase_log_id' => $purchaseLog->id,
        ]);
        $this->updateUserPoints($userId);

        $userNotice = ['user_id' => $userId,
            'category_type'      => Notification::CATEGORY_TYPE_PURCHASE,
            'type'               => Notification::TYPE_POINT_ALERT,
            'title'              => trans('user.notifications.purchase.title'),
            'content'            => trans(
                'user.notifications.purchase.content',
                ['points' => $amount]
            ),
            'sent_at' => \DateTimeHelper::now(),
            'data'    => json_encode(''),
        ];
        $userNote = $this->userNotificationRepository->create($userNotice);
        $user     = $this->userRepository->find($userId);
        $package  = $this->getPackageFromPoint($amount);
        $this->mailService->sendEmailPurchaseUser($user, $package);

        return $pointLog;
    }

    public function addPointsByAdmin($userId, $pointLog, $action = 'new')
    {
        $user = $this->userRepository->find($userId);
        if (empty($user)) {
            return null;
        }
        $this->updateUserPoints($userId);
        if ($pointLog->point_amount > 0) {
            $createdAt   = \DateTimeHelper::now();
            $purchaseLog = $this->purchaseLogRepository->create([
                'user_id'                => $userId,
                'purchase_method_type'   => PurchaseLog::PURCHASE_TYPE_BY_ADMIN,
                'point_amount'           => $pointLog->point_amount,
                'purchase_info'          => '',
                'point_expired_at'       => $createdAt,
                'created_at'             => $createdAt,
                'remaining_point_amount' => $pointLog->point_amount,
            ]);
            $purchaseLog = $this->setPointExpiredAt($purchaseLog);

            return $purchaseLog;
        } else {
            $this->subExpiredPoints($userId, -1 * $pointLog->point_amount);
        }

        return null;
    }

    public function addPointSignupUser($userId)
    {
        $user = $this->userRepository->find($userId);
        if (empty($user)) {
            return false;
        }
        $this->pointLogRepository->create([
            'user_id'         => $user->id,
            'point_amount'    => 1,
            'type'            => PointLog::TYPE_BONUS_SIGNUP,
            'description'     => '',
            'booking_id'      => 0,
            'purchase_log_id' => 0,
        ]);
        $this->updateUserPoints($userId);

        return true;
    }

    public function setPointExpiredAt($purchaseLog)
    {
        $expiredAt   = $purchaseLog->created_at->addDays(config('point.validityInDays'))->setTime(9, 0, 0);
        $purchaseLog = $this->purchaseLogRepository->update($purchaseLog, [
            'point_expired_at' => $expiredAt,
        ]);

        return $purchaseLog;
    }

    public function updatePointExpired($purchaseId, $amount)
    {
        $targetPurchaseLog = $this->purchaseLogRepository->find($purchaseId);
        if (empty($targetPurchaseLog)) {
            return false;
        }
        if ($targetPurchaseLog->point_amount == $targetPurchaseLog->remaining_point_amount) {
            $pointAmountRemaining = $amount;
        } else {
            $pointAmountRemaining = abs($amount - $targetPurchaseLog->point_amount);
        }
        if ($amount <= 0) {
            $pointAmountRemaining = 0;
        }
        $purchaseLogUpdated = $this->purchaseLogRepository->update($targetPurchaseLog, [
            'remaining_point_amount' => $pointAmountRemaining,
            'point_amount'           => $amount,
        ]);

        return $purchaseLogUpdated;
    }

    public function getPackageFromAmount($amount)
    {
        $packages = config('point.package');
        $p        = 0;
        foreach ($packages as $key => $package) {
            if ($package['value']['amount'] == $amount) {
                $p = $package;
            }
        }

        return $p;
    }

    public function getPackageFromPoint($point)
    {
        $packages = config('point.package');
        $p        = 0;
        foreach ($packages as $key => $package) {
            if ($package['value']['point'] == $point) {
                $p = $package;
            }
        }

        return $p;
    }

    public function subExpiredPoints($userId, $amount)
    {
        $user = $this->userRepository->find($userId);
        if (empty($user)) {
            return false;
        }

        $restAmount = $amount;
        while ($restAmount > 0) {
            $targetPurchaseLog = $this->purchaseLogRepository->findOldestPointByUserId($userId);
            if (empty($targetPurchaseLog)) {
                return false;
            } else {
                $useAmount = ($targetPurchaseLog->remaining_point_amount >= $restAmount) ? $restAmount : $targetPurchaseLog->remaining_point_amount;
                $this->purchaseLogRepository->update($targetPurchaseLog, [
                    'remaining_point_amount' => $targetPurchaseLog->remaining_point_amount - $useAmount,
                ]);
            }
            $restAmount = $restAmount - $useAmount;
        }

        return true;
    }

    private function getPurchaseBookingAble($purchase)
    {
        $limitBooking = 1;

        if ($purchase->purchase_method_type == PurchaseLog::PURCHASE_TYPE_BY_ADMIN) {
            $lastPurchasePaypalLog = $this->purchaseLogRepository->findLastPackagePurchaseByUserId($purchase->user_id);
            if (!empty($lastPurchasePaypalLog)) {
                if ($lastPurchasePaypalLog->point_amount == PurchaseLog::PURCHASE_PACKAGE_PAYPAL_BASIC) {
                    $limitBooking = 2;
                } elseif ($lastPurchasePaypalLog->point_amount == PurchaseLog::PURCHASE_PACKAGE_PAYPAL_PREMIUM) {
                    $limitBooking = 3;
                }
            }

            $bookingsPackage = $this->bookingRepository->allBookingByPointPackageAndUserIdToday($purchase->user_id, PurchaseLog::PURCHASE_TYPE_BY_ADMIN, 0);
            if (count($bookingsPackage) >= $limitBooking) {
                $targetPurchaseLog = $this->purchaseLogRepository->findFirstPurchaseByUserIdAndCreatedTime($purchase->user_id, $purchase->created_at);
                if (empty($targetPurchaseLog)) {
                    return null;
                }

                return  $this->getPurchaseBookingAble($targetPurchaseLog);
            } else {
                return $purchase;
            }
        } else {
            if ($purchase->point_amount == PurchaseLog::PURCHASE_PACKAGE_PAYPAL_BASIC) {
                $limitBooking = 2;
            } elseif ($purchase->point_amount == PurchaseLog::PURCHASE_PACKAGE_PAYPAL_PREMIUM) {
                $limitBooking = 3;
            }
            $bookingsPackage = $this->bookingRepository->allBookingByPointPackageAndUserIdToday($purchase->user_id, PurchaseLog::PURCHASE_TYPE_PAYPAL, $purchase->point_amount);
            if (count($bookingsPackage) >= $limitBooking) {
                $targetPurchaseLog = $this->purchaseLogRepository->findFirstPurchaseByUserIdAndCreatedTime($purchase->user_id, $purchase->created_at);
                if (empty($targetPurchaseLog)) {
                    return null;
                }

                return $this->getPurchaseBookingAble($targetPurchaseLog);
            } else {
                return $purchase;
            }
        }
    }
}
