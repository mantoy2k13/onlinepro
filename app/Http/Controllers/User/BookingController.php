<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\PaginationRequest;
use App\Models\Booking;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\FavoriteTeacherRepositoryInterface;
use App\Repositories\LessonRepositoryInterface;
use App\Repositories\PointLogRepositoryInterface;
use App\Repositories\TeacherNotificationRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use App\Repositories\TimeSlotRepositoryInterface;
use App\Repositories\UserNotificationRepositoryInterface;
use App\Services\BookingServiceInterface;
use App\Services\PointServiceInterface;
use App\Services\TimeSlotServiceInterface;
use App\Services\UserServiceInterface;

class BookingController extends Controller
{
    /** @var \App\Repositories\TeacherRepositoryInterface */
    protected $teacherRepository;

    /** @var \App\Repositories\BookingRepositoryInterface */
    protected $bookingRepository;

    /** @var \App\Services\BookingServiceInterface */
    protected $bookingService;

    /** @var \App\Repositories\TimeSlotRepositoryInterface */
    protected $timeSlotRepository;

    /** @var \App\Services\UserServiceInterface */
    protected $userService;

    /** @var \App\Services\TimeSlotServiceInterface */
    protected $timeSlotService;

    /** @var \App\Repositories\PointLogRepositoryInterface */
    protected $pointLogRepository;

    /** @var PointServiceInterface $pointService */
    protected $pointService;

    /** @var UserNotificationRepositoryInterface $userNotificationRepository */
    protected $userNotificationRepository;

    /** @var TeacherNotificationRepositoryInterface $teacherNotificationRepository */
    protected $teacherNotificationRepository;

    /** @var TeacherNotificationRepositoryInterface $favoriteTeacherRepository */
    protected $favoriteTeacherRepository;

    /** @var LessonRepositoryInterface $lessonRepository */
    protected $lessonRepository;

    public function __construct(
        TeacherRepositoryInterface $teacherRepository,
        BookingRepositoryInterface $bookingRepository,
        TimeSlotRepositoryInterface $timeSlotRepository,
        UserServiceInterface $userService,
        BookingServiceInterface $bookingService,
        TimeSlotServiceInterface $timeSlotService,
        PointLogRepositoryInterface $pointLogRepository,
        PointServiceInterface $pointService,
        UserNotificationRepositoryInterface $userNotificationRepository,
        TeacherNotificationRepositoryInterface $teacherNotificationRepository,
        FavoriteTeacherRepositoryInterface $favoriteTeacherRepository,
        LessonRepositoryInterface $lessonRepository
    ) {
        $this->teacherRepository             = $teacherRepository;
        $this->bookingRepository             = $bookingRepository;
        $this->timeSlotRepository            = $timeSlotRepository;
        $this->userService                   = $userService;
        $this->bookingService                = $bookingService;
        $this->timeSlotService               = $timeSlotService;
        $this->pointLogRepository            = $pointLogRepository;
        $this->pointService                  = $pointService;
        $this->userNotificationRepository    = $userNotificationRepository;
        $this->teacherNotificationRepository = $teacherNotificationRepository;
        $this->favoriteTeacherRepository     = $favoriteTeacherRepository;
        $this->lessonRepository              = $lessonRepository;
    }

    public function index($id)
    {
        $user = $this->userService->getUser();

        if ($user['points'] < config('point.point_per_booking')) {
            \Session::put('booking-'.$user->id, action('User\BookingController@index', [$id]));

            return redirect()->action('User\PointController@index')->withErrors(['message-error-point'=> trans('user.pages.points.error_point_not_enough')]);
        }
        if (!is_numeric($id) || ($id < 0)) {
            return redirect()->action('User\IndexController@index')->with(
                'message-failed',
                    trans('admin.errors.requests.common.parameters')
            );
        }

        $timeSlotIsAvailable = $this->timeSlotService->isAvailable($id);

        if (!$timeSlotIsAvailable) {
            return redirect()->action('User\IndexController@index')->with(
                'message-failed',
                    trans('admin.errors.requests.common.parameters')
            );
        }

        $timeSlot   = $this->timeSlotRepository->find($id);
        $teacher    = $timeSlot->teacher;
        $isFavorite = false;
        if (!empty($user)) {
            $favorite = $this->favoriteTeacherRepository->findByUserIdAndTeacherId($user->id, $teacher->id);
            if (!empty($favorite)) {
                $isFavorite = true;
            }
        }

        return view('pages.user.booking.index', [
                'timeSlot'   => $timeSlot,
                'teacher'    => $teacher,
                'isFavorite' => $isFavorite,
                'titlePage'  => trans('user.pages.title.booking_confirm'),
            ]);
    }

    public function booking($timeSlotId, BaseRequest $request)
    {
        if (!is_numeric($timeSlotId) || ($timeSlotId < 0)) {
            return redirect()->back()->with(
                'message-failed',
                    trans('admin.errors.requests.common.parameters')
            );
        }

        $timeSlotIsAvailable = $this->timeSlotService->isAvailable($timeSlotId);

        if (!$timeSlotIsAvailable) {
            return redirect()->back()->with(
                'message-failed',
                    trans('admin.errors.requests.common.parameters')
            );
        }
        $user             = $this->userService->getUser();
        $bookingAbleToday = $this->bookingService->bookingAbleToday($user->id);
        if (!$bookingAbleToday) {
            return redirect()->action('User\IndexController@index')->withErrors(['message-failed'=> trans('user.pages.bookings.failed_limited_today')]);
        }
        if ($user['points'] < config('point.point_per_booking')) {
            \Session::put('booking-'.$user->id, action('User\BookingController@index', [$timeSlotId]));

            return redirect()->action('User\PointController@index')->withErrors(['message-error-point'=> trans('user.pages.points.error_point_not_enough')]);
        }

        $timeSlot = $this->timeSlotRepository->find($timeSlotId);
        $booking  = $this->bookingRepository->create([
                'user_id'        => $user['id'],
                'teacher_id'     => $timeSlot->teacher->id,
                'time_slot_id'   => $timeSlotId,
                'status'         => Booking::TYPE_STATUS_PENDING,
                'message'        => $request->get('message', ''),
                'payment_log_id' => 0,
            ]);

        if (!empty($booking)) {
            $this->pointService->consumePoints($user->id, config('point.point_per_booking'), $booking->id);
            $this->bookingService->booking($user, $booking);

            return redirect()->action('User\BookingController@success', $timeSlotId);
        } else {
            return redirect()->back();
        }
    }

    public function success($timeSlotId)
    {
        if (!is_numeric($timeSlotId) || ($timeSlotId < 0)) {
            return redirect()->action('User\IndexController@index')->with(
                'message-failed',
                trans('admin.errors.requests.common.parameters')
            );
        }

        $user          = $this->userService->getUser();
        $isUserBooking = $this->bookingService->checkUserBooking($user->id, $timeSlotId);
        if ($isUserBooking) {
            return view('pages.user.booking.success', [
                'titlePage'  => trans('user.pages.title.booking_success'),
                'timeSlotId' => $timeSlotId,
            ]);
        } else {
            return redirect()->action('User\IndexController@index')->with(
                'message-failed',
                trans('admin.errors.requests.common.parameters')
            );
        }
    }

    public function getReservations(PaginationRequest $request)
    {
        $offset         = $request->offset();
        $limit          = $request->limit();
        $user           = $this->userService->getUser();
        $teacherId      = 0;
        $statusIncluded = [];
        $dateTo         = '';
        $statusExcluded = [Booking::TYPE_STATUS_CANCELED];

        $dateFrom  = \DateTimeHelper::now();
        $order     = 'start_at';
        $direction = 'desc';
        $count     = $this->bookingRepository->countEnabledWithConditions(
            $user->id,
            $teacherId,
            $statusIncluded,
            $statusExcluded,
            $dateFrom,
            $dateTo
        );
        $models = $this->bookingRepository->getEnabledWithConditions(
            $user->id,
            $teacherId,
            $statusIncluded,
            $statusExcluded,
            $dateFrom,
            $dateTo,
            $order,
            $direction,
            $offset,
            $limit
        );

        return view('pages.user.booking.reservations', [
            'user'      => $user,
            'models'    => $models,
            'count'     => $count,
            'offset'    => $offset,
            'limit'     => $limit,
            'titlePage' => trans('user.pages.title.reservations'),
            'params'    => [],
            'baseUrl'   => action('User\BookingController@getReservations'),
        ]);
    }

    public function cancelReservation($bookingId)
    {
        $user    = $this->userService->getUser();
        $booking = $this->bookingRepository->find($bookingId);
        if (!empty($booking) && $booking->present()->userAbleCancel) {
            if ($booking->user_id === $user->id) {
                $input = ['status' => 'canceled'];
                $this->bookingRepository->update($booking, $input);
            }
        }
        $this->pointService->refundPoints($user->id, config('point.point_per_refund'), $booking->id);
        $this->bookingService->userCancelBooking($user, $booking);

        return redirect()->action('User\BookingController@getReservations')->with(
            'message-success',
                trans('teacher.messages.cancel_success')
        );
    }

    public function getBookingHistories(PaginationRequest $request)
    {
        $offset         = $request->offset();
        $limit          = $request->limit();
        $user           = $this->userService->getUser();
        $teacherId      = 0;
        $statusIncluded = '';
        $statusExcluded = [Booking::TYPE_STATUS_CANCELED];
        $dateTo         = \DateTimeHelper::now();

        $dateFrom  = '';
        $order     = 'start_at';
        $direction = 'desc';
        $count     = $this->bookingRepository->countEnabledWithConditions(
            $user->id,
            $teacherId,
            $statusIncluded,
            $statusExcluded,
            $dateFrom,
            $dateTo
        );
        $models = $this->bookingRepository->getEnabledWithConditions(
            $user->id,
            $teacherId,
            $statusIncluded,
            $statusExcluded,
            $dateFrom,
            $dateTo,
            $order,
            $direction,
            $offset,
            $limit
        );

        return view('pages.user.booking.history-bookings', [
            'user'      => $user,
            'models'    => $models,
            'count'     => $count,
            'offset'    => $offset,
            'limit'     => $limit,
            'titlePage' => trans('user.pages.title.histories'),
            'params'    => [],
            'baseUrl'   => action('User\BookingController@getBookingHistories'),
        ]);
    }
}
