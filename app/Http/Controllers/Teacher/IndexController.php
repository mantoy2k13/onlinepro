<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\Teacher\ReviewRequest;
use App\Models\Booking;
use App\Models\Review;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\PaymentLogRepositoryInterface;
use App\Repositories\PointLogRepositoryInterface;
use App\Repositories\ReviewRepositoryInterface;
use App\Repositories\TimeSlotRepositoryInterface;
use App\Repositories\UserNotificationRepositoryInterface;
use App\Services\BookingServiceInterface;
use App\Services\PointServiceInterface;
use App\Services\Production\TeacherService;
use App\Services\TimeSlotServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    /** @var TimeSlotRepositoryInterface $timeSlotRepository */
    protected $timeSlotRepository;

    /** @var BookingRepositoryInterface $bookingRepository */
    protected $bookingRepository;

    /** @var TeacherService $teacherService */
    protected $teacherService;

    /** @var ReviewRepositoryInterface $reviewRepository */
    protected $reviewRepository;

    /** @var PaymentLogRepositoryInterface $paymentLogRepository */
    protected $paymentLogRepository;

    /** @var BookingServiceInterface $bookingService */
    protected $bookingService;

    /** @var TimeSlotServiceInterface $timeSlotService */
    protected $timeSlotService;

    /** @var UserNotificationRepositoryInterface $userNotificationRepository */
    protected $userNotificationRepository;

    /** @var PointLogRepositoryInterface $pointLogRepository */
    protected $pointLogRepository;

    /** @var PointServiceInterface $pointService */
    protected $pointService;

    public function __construct(
        TeacherService $teacherService,
        TimeSlotRepositoryInterface $timeSlotRepository,
        BookingRepositoryInterface $bookingRepository,
        ReviewRepositoryInterface $reviewRepository,
        PaymentLogRepositoryInterface $paymentLogRepository,
        BookingServiceInterface $bookingService,
        TimeSlotServiceInterface $timeSlotService,
        PointLogRepositoryInterface $pointLogRepository,
        PointServiceInterface $pointService,
        UserNotificationRepositoryInterface $userNotificationRepository
    ) {
        $this->teacherService             = $teacherService;
        $this->timeSlotRepository         = $timeSlotRepository;
        $this->bookingRepository          = $bookingRepository;
        $this->reviewRepository           = $reviewRepository;
        $this->paymentLogRepository       = $paymentLogRepository;
        $this->bookingService             = $bookingService;
        $this->timeSlotService            = $timeSlotService;
        $this->userNotificationRepository = $userNotificationRepository;
        $this->pointLogRepository         = $pointLogRepository;
        $this->pointService               = $pointService;
    }

    public function index()
    {
        return redirect()->action('Teacher\IndexController@getReservations');
    }

    public function timeSlot($date)
    {
        $teacher   = $this->teacherService->getUser();
        $timeSlots = $this->timeSlotRepository->getByStartDate($date, $teacher->id);
        $timeSlot  = $this->timeSlotRepository->getBlankModel();

        return view('pages.teacher.time-slot.edit', [
            'currentDate' => \DateTimeHelper::nowInPresentationTimeZone(),
            'teacher'     => $teacher,
            'date'        => Carbon::parse($date),
            'timeSlots'   => $timeSlots,
            'timeSlot'    => $timeSlot,
            'titlePage'   => trans('teacher.pages.title.registration_date'),
        ]);
    }

    public function openCloseTimeSlot()
    {
        $status = Input::get('status', 'on');

        $datetime = Input::get('datetime');
        $startAt  = \DateTimeHelper::convertToStorageDateTime($datetime);
        $endAt    = \DateTimeHelper::convertToStorageDateTime($datetime);
        $endAt    = $endAt->addMinutes(config('timeslot.start_end_config_in_minute'));
        $teacher  = $this->teacherService->getUser();
        if (!$teacher->present()->bookable($datetime) || $startAt < \DateTimeHelper::now()) {
            \Session::flash('message-failed', trans('teacher.messages.update_failed'));

            return false;
        }
        if ($status == 'off') {
            $timeSlot = $this->timeSlotRepository->findByStartDate($startAt, $teacher->id);

            if (!empty($timeSlot)) {
                if (count($timeSlot->bookingPending) <= 0) {
                    $this->timeSlotRepository->delete($timeSlot);
                } else {
                    \Session::flash('message-failed', trans('teacher.messages.update_failed'));

                    return false;
                }
            }
        } else {
            $timeSlot = $this->timeSlotRepository->findByStartDate($startAt, $teacher->id);
            if (empty($timeSlot)) {
                $input    = ['teacher_id' => $teacher->id, 'start_at' => $startAt, 'end_at' => $endAt];
                $timeSlot = $this->timeSlotRepository->create($input);
            }
        }
        \Session::flash('message-success', trans('teacher.messages.success_update'));

        return true;
    }

    public function openCloseAllTimeSlot()
    {
        $status = Input::get('status', 'on');

        $date        = Input::get('datetime');
        $teacher     = $this->teacherService->getUser();
        $dateSlot    = \DateTimeHelper::createTimeFromString($date);
        $currentTime = \DateTimeHelper::now(\DateTimeHelper::timezoneForPresentation());
        if ($currentTime->diffInDays($dateSlot, false) < 0) {
            \Session::flash('message-failed', trans('teacher.messages.update_failed'));

            return redirect()->action('Teacher\IndexController@timeSlot', [$dateSlot->format('Y-m-d')]);
        }
        $this->timeSlotService->closeOpenAllTimeSlot($date, $status, $teacher);

        return redirect()->action('Teacher\IndexController@timeSlot', [$dateSlot->format('Y-m-d')])
            ->with('message-success', trans('teacher.messages.success_update'));
    }

    public function getReservations(PaginationRequest $request)
    {
        $offset         = $request->offset();
        $limit          = $request->limit();
        $teacher        = $this->teacherService->getUser();
        $dateFrom       = '';
        $userId         = 0;
        $statusIncluded = '';
        $statusExcluded = [Booking::TYPE_STATUS_CANCELED];
        $dateTo         = '';
        $order          = 'start_at';
        $direction      = 'desc';
        $count          = $this->bookingRepository->countEnabledWithConditions(
            $userId,
            $teacher->id,
            $statusIncluded,
            $statusExcluded,
            $dateFrom,
            $dateTo
        );
        $models = $this->bookingRepository->getEnabledWithConditions(
            $userId,
            $teacher->id,
            $statusIncluded,
            $statusExcluded,
            $dateFrom,
            $dateTo,
            $order,
            $direction,
            $offset,
            $limit
        );
        $bookingReviews = $this->bookingService->bookingReviews($models);

        return view('pages.teacher.booking.index', [
            'bookingReviews' => $bookingReviews,
            'teacher'        => $teacher,
            'models'         => $models,
            'count'          => $count,
            'offset'         => $offset,
            'limit'          => $limit,
            'now'            => \DateTimeHelper::now(),
            'params'         => [],
            'baseUrl'        => action('Teacher\IndexController@getReservations'),
        ]);
    }

    public function cancelReservation($bookingId)
    {
        $teacher = $this->teacherService->getUser();
        $booking = $this->bookingRepository->find($bookingId);
        if (!empty($booking) && $booking->present()->teacherAbleCancel) {
            if ($booking->teacher_id === $teacher->id) {
                $input = ['status' => Booking::TYPE_STATUS_CANCELED];
                $this->bookingRepository->update($booking, $input);
            }
        }
        $this->pointService->refundPoints($booking->user->id, config('point.point_per_refund'), $booking->id);
        $this->bookingService->teacherCancelBooking($teacher, $booking);
        \Session::flash('message-success', trans('teacher.messages.cancel_success'));

        return redirect()->action('Teacher\IndexController@getReservations')
            ->with('message-success', trans('teacher.messages.cancel_success'));
    }

    public function calendarRegistration($date = null)
    {
        $teacher      = $this->teacherService->getUser();
        $listTimeSlot = [];
        for ($i = 0; $i < 7; $i++) {
            $datetime          = Carbon::parse($date);
            $timeSlots['date'] = $datetime;
            $datetime          = $datetime->addDays($i);
            $timeSlots['data'] = $this->timeSlotRepository->getByStartDate($datetime->format('Y-m-d'), $teacher->id);
            array_push($listTimeSlot, $timeSlots);
        }
        $timeSlot = $this->timeSlotRepository->getBlankModel();

        return view('pages.teacher.calendar-registration.index', [
            'teacher'      => $teacher,
            'date'         => Carbon::parse($date),
            'listTimeSlot' => $listTimeSlot,
            'timeSlot'     => $timeSlot,
            'titlePage'    => trans('teacher.pages.title.registration_calendar'),
        ]);
    }

    public function writeReview(ReviewRequest $request)
    {
        $input   = $request->only(['booking_id', 'content']);
        $teacher = $this->teacherService->getUser();
        $booking = $this->bookingRepository->find($request->get('booking_id'));

        if (empty($booking) || $booking->teacher_id != $teacher->id || !($booking->present()->writeLogAble)) {
            \Session::flash('message-failed', trans('teacher.messages.update_failed'));

            return redirect()->action('Teacher\IndexController@getReservations');
        }
        $input['teacher_id'] = $booking->teacher_id;
        $input['user_id']    = $booking->user_id;
        $input['target']     = 'user';
        $input['rating']     = 5;
        if (!empty($request->get('review_id', 0))) {
            $review = $this->reviewRepository->find($request->get('review_id', 0));

            if (!empty($review)) {
                $this->reviewRepository->update($review, $input);

                return redirect()->action('Teacher\IndexController@getReservations')
                    ->with('message-success', trans('teacher.messages.action_success'));
            }
        }
        $reviewOld = $this->reviewRepository->findByIdTargetTeacherUser($booking->user_id, $booking->teacher_id, Review::TARGET_USER, $booking->id);
        if (empty($reviewOld)) {
            $review = $this->reviewRepository->create($input);
            $this->bookingRepository->update($booking, ['status' => Booking::TYPE_STATUS_FINISHED]);
        }

        return redirect()->action('Teacher\IndexController@getReservations')
            ->with('message-success', trans('teacher.messages.action_success'));
    }

    public function checkingAccount(PaginationRequest $request)
    {
        $teacher           = $this->teacherService->getUser();
        $thisMonthBookings = $this->bookingService->listBookingThisMonth($teacher);

        $offset       = $request->offset();
        $limit        = $request->limit();
        $status       = '';
        $paidAmount   = 0;
        $paidForMonth = '';
        $count        = $this->paymentLogRepository->countEnabledWithConditions($status, $paidAmount, $teacher->id, $paidForMonth);
        $paymentLogs  = $this->paymentLogRepository->getEnabledWithConditions(
            $status,
            $paidAmount,
            $teacher->id,
            $paidForMonth,
            'updated_at',
            'desc',
            $offset,
            $limit
        );

        return view('pages.teacher.checking-account.index', [
            'paymentLogs'  => $paymentLogs,
            'count'        => $count,
            'offset'       => $offset,
            'limit'        => $limit,
            'titlePage'    => trans('teacher.pages.title.checking_account'),
            'dateNow'      => \DateTimeHelper::now(),
            'datas'        => $thisMonthBookings,
            'params'       => [
            ],
            'baseUrl' => action('Teacher\IndexController@checkingAccount'),
        ]);
    }
}
