<?php
namespace App\Services\Production;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\PurchaseLog;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\PointLogRepositoryInterface;
use App\Repositories\PurchaseLogRepositoryInterface;
use App\Repositories\TeacherNotificationRepositoryInterface;
use App\Repositories\UserNotificationRepositoryInterface;
use App\Services\BookingServiceInterface;
use App\Services\MailServiceInterface;
use App\Services\PointServiceInterface;
use Carbon\Carbon;

class BookingService extends BaseService implements BookingServiceInterface
{
    /** @var \App\Repositories\BookingRepositoryInterface */
    protected $bookingRepository;

    /** @var \App\Repositories\PointLogRepositoryInterface */
    protected $pointLogRepository;

    /** @var \App\Services\PointServiceInterface */
    protected $pointService;

    /** @var \App\Repositories\TeacherNotificationRepositoryInterface */
    protected $teacherNotificationRepository;

    /** @var \App\Repositories\UserNotificationRepositoryInterface */
    protected $userNotificationRepository;

    /** @var \App\Services\MailServiceInterface */
    protected $mailService;

    /** @var \App\Repositories\PurchaseLogRepositoryInterface */
    protected $purchaseLogRepository;

    public function __construct(
        BookingRepositoryInterface                  $bookingRepository,
        PointLogRepositoryInterface                 $pointLogRepository,
        PointServiceInterface                       $pointService,
        TeacherNotificationRepositoryInterface      $teacherNotificationRepository,
        UserNotificationRepositoryInterface         $userNotificationRepository,
        MailServiceInterface                        $mailService,
        PurchaseLogRepositoryInterface              $purchaseLogRepository
    ) {
        $this->bookingRepository                    = $bookingRepository;
        $this->pointLogRepository                   = $pointLogRepository;
        $this->pointService                         = $pointService;
        $this->teacherNotificationRepository        = $teacherNotificationRepository;
        $this->userNotificationRepository           = $userNotificationRepository;
        $this->mailService                          = $mailService;
        $this->purchaseLogRepository                = $purchaseLogRepository;
    }

    public function checkUserBooking($userId, $timeSlotId)
    {
        $booking = $this->bookingRepository->getBlankModel()->where([
            ['user_id', '=', $userId],
            ['time_slot_id', '=', $timeSlotId],
            ['status', '=', Booking::TYPE_STATUS_PENDING],
        ])
        ->get();

        return count($booking) ? true : false;
    }

    public function bookingReviews($bookings)
    {
        $bookingReviews = [];
        foreach ($bookings as $key => $booking) {
            $content  = '';
            $reviewId = 0;
            $userName = 'N/A';
            $avatar   = \URLHelper::asset(config('file.categories.user-profile-image.default-avatar'), 'common');
            if (!empty($booking->reviewLogByTeacher)) {
                $content  = $booking->reviewLogByTeacher->content;
                $reviewId = $booking->reviewLogByTeacher->id;
            }
            if (!empty($booking->user)) {
                $userName = $booking->user->name;
                if (!empty($booking->user->profileImage)) {
                    $avatar =$booking->user->profileImage->url;
                }
            }
            $bookingId = $booking->id;
            $startAt   = \DateTimeHelper::changeToPresentationTimeZone($booking->timeSlot->start_at);
            $item      = [
                'start_at'  => $this->dateFormatLightBox($startAt),
                'name'      => $userName,
                'id'        => $bookingId,
                'content'   => $content,
                'review_id' => $reviewId,
                'message'   => $booking->message,
                'avatar'    => $avatar,
            ];
            array_push($bookingReviews, $item);
        }

        return $bookingReviews;
    }

    private function dateFormatLightBox($startAt)
    {
        return $startAt->format('m/d H:i');
    }

    public function listBookingThisMonth($teacher)
    {
        $userId            = 0;
        $statusIncluded    = '';
        $statusExcluded    = [Booking::TYPE_STATUS_CANCELED];
        $dateFrom          = new Carbon('first day of this month');
        $dateFrom          = Carbon::parse($dateFrom->format('Y-m-d'));
        $startDateFrom     = \DateTimeHelper::convertToStorageDateTime($dateFrom);
        $dateTo            = \DateTimeHelper::nowInPresentationTimeZone();
        $dateTo            = $dateTo->subMinutes(config('timeslot.start_end_config_in_minute'));
        $startDateTo       = \DateTimeHelper::convertToStorageDateTime($dateTo);
        $order             = 'start_at';
        $direction         = 'desc';
        $createdDateFrom   = '';
        $createdDateTo     = '';
        $thisMonthBookings = $this->bookingRepository->getAllBookingWithConditions(
            $userId,
            $teacher->id,
            $statusIncluded,
            $statusExcluded,
            $startDateFrom,
            $startDateTo,
            $createdDateFrom,
            $createdDateTo,
            $order,
            $direction
        );

        return $thisMonthBookings;
    }

    public function booking($user, $booking)
    {
        $teacherNotice = ['user_id'=> $booking->teacher->id,
            'category_type'        => Notification::CATEGORY_TYPE_BOOKING,
            'type'                 => Notification::TYPE_BOOKING_ALERT,
            'title'                => trans('user.notifications.message.title', ['user' => $user->present()->name]),
            'content'              => trans(
                'user.notifications.message.content',
                ['user' => $user->present()->name, 'time' => $booking->timeSlot->present()->startTimeInTimeZone]
            ),
            'sent_at' => \DateTimeHelper::now(),
            'data'    => json_encode(''),
        ];

        $teacher    = $booking->timeSlot->teacher;
        $userNotice = ['user_id' => $user->id,
            'category_type'      => Notification::CATEGORY_TYPE_BOOKING,
            'type'               => Notification::TYPE_BOOKING_ALERT,
            'title'              => trans('user.notifications.message.title', ['user' => $teacher->present()->name]),
            'content'            => trans(
                'user.notifications.message.content',
                ['user' => $teacher->present()->name, 'time' => $booking->timeSlot->present()->startTimeInTimeZone]
            ),
            'sent_at' => \DateTimeHelper::now(),
            'data'    => json_encode(''),
        ];
        $teacherNote = $this->teacherNotificationRepository->create($teacherNotice);
        $userNote    = $this->userNotificationRepository->create($userNotice);
        $this->mailService->sendBookingEmailTeacher($booking);
        $this->mailService->sendBookingEmailUser($booking);
        $this->mailService->sendBookingEmailAdmin($user, $booking);
    }

    public function userCancelBooking($user, $booking)
    {
        $teacherNotice = ['user_id'=> $booking->timeSlot->teacher->id,
            'category_type'        => Notification::CATEGORY_TYPE_CANCEL,
            'type'                 => Notification::TYPE_BOOKING_ALERT,
            'title'                => trans('user.notifications.message.title_cancel', ['user' => $user->present()->name]),
            'content'              => trans(
                'user.notifications.message.content_cancel',
                ['user' => $user->present()->name, 'time' => $booking->timeSlot->present()->startTimeInTimeZone]
            ),
            'sent_at' => \DateTimeHelper::now(),
            'data'    => json_encode(''),
        ];
        $teacherNote = $this->teacherNotificationRepository->create($teacherNotice);
        $this->mailService->sendCancelBookingEmailAdmin($user, $booking);
        $this->mailService->sendCancelBookingEmailTeacher($booking);
        $this->mailService->sendCancelBookingEmailUserSuccess($booking);
    }

    public function teacherCancelBooking($teacher, $booking)
    {
        $userNotice = ['user_id'=> $booking->user->id,
            'category_type'     => Notification::CATEGORY_TYPE_CANCEL,
            'type'              => Notification::TYPE_BOOKING_ALERT,
            'title'             => trans('user.notifications.message.title_cancel', ['user' => $teacher->present()->name]),
            'content'           => trans(
                'user.notifications.message.content_cancel',
                ['user' => $teacher->present()->name, 'time' => $booking->timeSlot->present()->startTimeInTimeZone]
            ),
            'sent_at' => \DateTimeHelper::now(),
            'data'    => json_encode(''),
        ];

        $userNote = $this->userNotificationRepository->create($userNotice);
        $this->mailService->sendCancelBookingEmailAdmin($teacher, $booking);
        $this->mailService->sendCancelBookingEmailTeacherSuccess($booking);
        $this->mailService->sendCancelBookingEmailUser($booking);
    }

    public function adminCancelBooking($booking)
    {
        $userNotice = ['user_id'=> $booking->user->id,
            'category_type'     => Notification::CATEGORY_TYPE_CANCEL,
            'type'              => Notification::TYPE_BOOKING_ALERT,
            'title'             => trans('user.emails.title.cancel_user'),
            'content'           => trans(
                'user.notifications.message.content_cancel',
                ['user' => $booking->user->name, 'time' => $booking->timeSlot->present()->startTimeInTimeZone]
            ),
            'sent_at' => \DateTimeHelper::now(),
            'data'    => json_encode(''),
        ];

        $teacherNotice = ['user_id'=> $booking->user->id,
            'category_type'        => Notification::CATEGORY_TYPE_CANCEL,
            'type'                 => Notification::TYPE_BOOKING_ALERT,
            'title'                => trans('user.notifications.message.admin_title_cancel'),
            'content'              => trans(
                'user.notifications.message.admin_content_cancel',
                ['time' => $booking->timeSlot->present()->startTimeInTimeZone]
            ),
            'sent_at' => \DateTimeHelper::now(),
            'data'    => json_encode(''),
        ];

        $teacherNote = $this->teacherNotificationRepository->create($teacherNotice);
        $userNote    = $this->userNotificationRepository->create($userNotice);
        $this->mailService->sendCancelBookingEmailTeacher($booking);
        $this->mailService->sendCancelBookingEmailUser($booking);
    }

    public function bookingAbleToday($userId)
    {
        $bookingsToday = $this->bookingRepository->allBookingByPointPackageAndUserIdToday($userId, '', null);
        if (count($bookingsToday) < 1) {
            return true;
        }
        $bookingSignUpPoint = $this->bookingRepository->findBookingBonusSignup($userId);
        if (empty($bookingSignUpPoint)) {
            return true;
        }
        $bookingsByLight  = $this->bookingRepository->allBookingByPointPackageAndUserIdToday($userId, PurchaseLog::PURCHASE_TYPE_PAYPAL, PurchaseLog::PURCHASE_PACKAGE_PAYPAL_LIGHT);
        $purchaseLogLight = $this->purchaseLogRepository->findPurchaseByUserIdTypePackageRamainPoint(
            $userId,
            PurchaseLog::PURCHASE_TYPE_PAYPAL,
            PurchaseLog::PURCHASE_PACKAGE_PAYPAL_LIGHT,
            true
        );
        if (count($bookingsByLight) < 1 and !empty($purchaseLogLight)) {
            return true;
        }
        $bookingsByBasic  = $this->bookingRepository->allBookingByPointPackageAndUserIdToday($userId, PurchaseLog::PURCHASE_TYPE_PAYPAL, PurchaseLog::PURCHASE_PACKAGE_PAYPAL_BASIC);
        $purchaseLogBasic = $this->purchaseLogRepository->findPurchaseByUserIdTypePackageRamainPoint(
            $userId,
            PurchaseLog::PURCHASE_TYPE_PAYPAL,
            PurchaseLog::PURCHASE_PACKAGE_PAYPAL_BASIC,
            true
        );
        if (count($bookingsByBasic) < 2 and !empty($purchaseLogBasic)) {
            return true;
        }
        $bookingsByPremium  = $this->bookingRepository->allBookingByPointPackageAndUserIdToday($userId, PurchaseLog::PURCHASE_TYPE_PAYPAL, PurchaseLog::PURCHASE_PACKAGE_PAYPAL_PREMIUM);
        $purchaseLogPremium = $this->purchaseLogRepository->findPurchaseByUserIdTypePackageRamainPoint(
            $userId,
            PurchaseLog::PURCHASE_TYPE_PAYPAL,
            PurchaseLog::PURCHASE_PACKAGE_PAYPAL_PREMIUM,
            true
        );
        if (count($bookingsByPremium) < 3 and !empty($purchaseLogPremium)) {
            return true;
        }
        $purchaseByAdmin = $this->purchaseLogRepository->findPurchaseByUserIdTypePackageRamainPoint(
            $userId,
            PurchaseLog::PURCHASE_TYPE_BY_ADMIN,
            0,
            true
        );
        if (!empty($purchaseByAdmin)) {
            $limitBookingByAdmin   = 1;
            $lastPurchasePaypalLog = $this->purchaseLogRepository->findLastPackagePurchaseByUserId($userId);
            if (!empty($lastPurchasePaypalLog)) {
                if ($lastPurchasePaypalLog->point_amount == PurchaseLog::PURCHASE_PACKAGE_PAYPAL_BASIC) {
                    $limitBookingByAdmin = 2;
                } elseif ($lastPurchasePaypalLog->point_amount == PurchaseLog::PURCHASE_PACKAGE_PAYPAL_PREMIUM) {
                    $limitBookingByAdmin = 3;
                }
            }

            $bookingsAdminPointToday = $this->bookingRepository->allBookingByPointPackageAndUserIdToday($userId, PurchaseLog::PURCHASE_TYPE_BY_ADMIN, 0);
            if (count($bookingsAdminPointToday) < $limitBookingByAdmin) {
                return true;
            }
        }

        return false;
    }

    public function updateBookingFinish()
    {
        $bookings = $this->bookingRepository->getAllBookingWithConditions(
            $userId = null,
            $teacherId = null,
            $statusIncluded = Booking::TYPE_STATUS_PENDING,
            $statusExcluded = [],
            $startDateFrom = null,
            $startDateTo = \DateTimeHelper::now(),
            $createdDateFrom = null,
            $createdDateTo = null,
            $order = 'id',
            $direction = 'desc'
        );
        foreach ($bookings as $booking) {
            $this->bookingRepository->update($booking, ['status' => Booking::TYPE_STATUS_FINISHED]);
        }
    }
}
