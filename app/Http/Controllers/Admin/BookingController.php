<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingRequest;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\PointLogRepositoryInterface;
use App\Repositories\TeacherNotificationRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use App\Repositories\UserNotificationRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\BookingServiceInterface;
use App\Services\PointServiceInterface;
use App\Services\Production\ExcelService;

class BookingController extends Controller
{
    /** @var \App\Repositories\BookingRepositoryInterface */
    protected $bookingRepository;

    protected $userRepository;

    protected $teacherRepository;

    /** @var ExcelService $excelService */
    protected $excelService;

    /** @var UserNotificationRepositoryInterface $userNotificationRepository */
    protected $userNotificationRepository;

    /** @var TeacherNotificationRepositoryInterface $teacherNotificationRepository */
    protected $teacherNotificationRepository;

    /** @var PointLogRepositoryInterface $pointLogRepository */
    protected $pointLogRepository;

    /** @var PointServiceInterface $pointService */
    protected $pointService;

    /** @var BookingServiceInterface $bookingService */
    protected $bookingService;

    public function __construct(
        BookingRepositoryInterface                  $bookingRepository,
        UserRepositoryInterface                     $userRepository,
        TeacherRepositoryInterface                  $teacherRepository,
        ExcelService                                $excelService,
        UserNotificationRepositoryInterface         $userNotificationRepository,
        PointLogRepositoryInterface                 $pointLogRepository,
        PointServiceInterface                       $pointService,
        TeacherNotificationRepositoryInterface      $teacherNotificationRepository,
        BookingServiceInterface                     $bookingService
    ) {
        $this->bookingRepository             = $bookingRepository;
        $this->userRepository                = $userRepository;
        $this->teacherRepository             = $teacherRepository;
        $this->excelService                  = $excelService;
        $this->userNotificationRepository    = $userNotificationRepository;
        $this->pointLogRepository            = $pointLogRepository;
        $this->pointService                  = $pointService;
        $this->teacherNotificationRepository = $teacherNotificationRepository;
        $this->bookingService                = $bookingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\PaginationRequest $request
     *
     * @return \Response
     */
    public function index(PaginationRequest $request)
    {
        $offset         = $request->offset();
        $limit          = $request->limit();
        $userId         = $request->get('user_id', 0);
        $teacherId      = $request->get('teacher_id', 0);
        $statusIncluded = $request->get('status');
        $statusExcluded = [];
        $dateFrom       = $request->get('date_from', '');
        $dateTo         = $request->get('date_to', '');
        $users          = $this->userRepository->all('name', 'asc');
        $teachers       = $this->teacherRepository->all('name', 'asc');
        $count          = $this->bookingRepository->countEnabledWithConditions($userId, $teacherId, $statusIncluded, $statusExcluded, $dateFrom, $dateTo);
        $models         = $this->bookingRepository->getEnabledWithConditions(
            $userId,
            $teacherId,
            $statusIncluded,
            $statusExcluded,
            $dateFrom,
            $dateTo,
            'updated_at',
            'desc',
            $offset,
            $limit
        );

        return view('pages.admin.bookings.index', [
            'models'    => $models,
            'count'     => $count,
            'offset'    => $offset,
            'limit'     => $limit,
            'users'     => $users,
            'teachers'  => $teachers,
            'userId'    => $userId,
            'teacherId' => $teacherId,
            'status'    => $statusIncluded,
            'dateFrom'  => $dateFrom,
            'dateTo'    => $dateTo,
            'now'       => \DateTimeHelper::now(),
            'params'    => [
                'user_id'    => $userId,
                'teacher_id' => $teacherId,
                'status'     => $statusIncluded,
                'date_from'  => $dateFrom,
                'date_to'    => $dateTo,
            ],
            'baseUrl' => action('Admin\BookingController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.bookings.edit', [
            'isNew'   => true,
            'booking' => $this->bookingRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(BookingRequest $request)
    {
        $input = $request->only(['status', 'user_id',  'category_id',
        'teacher_id', 'time_slot_id', 'message', 'payment_log_id', ]);

        $model = $this->bookingRepository->create($input);

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\BookingController@index')
            ->with('message-success', trans('admin.messages.general.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Response
     */
    public function show($id)
    {
        $model = $this->bookingRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }

        return view('pages.admin.bookings.edit', [
            'isNew'   => false,
            'booking' => $model,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param     $request
     *
     * @return \Response
     */
    public function update($id, BookingRequest $request)
    {
        /** @var \App\Models\Booking $model */
        $model = $this->bookingRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $input = $request->only(['status', 'user_id', 'category_id',
            'teacher_id', 'time_slot_id', 'message', 'payment_log_id', ]);

        $this->bookingRepository->update($model, $input);

        return redirect()->action('Admin\BookingController@show', [$id])
            ->with('message-success', trans('admin.messages.general.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Response
     */
    public function destroy($id)
    {
        /** @var \App\Models\Booking $model */
        $model = $this->bookingRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $this->bookingRepository->delete($model);

        return redirect()->action('Admin\BookingController@index')
            ->with('message-success', trans('admin.messages.general.delete_success'));
    }

    /**
     * Export booking counselling to excel .
     *
     * @param int $request
     *
     * @return \Maatwebsite\Excel\
     */
    public function exportExcel(BaseRequest $request)
    {
        $userId         = $request->get('user_id', 0);
        $teacherId      = $request->get('teacher_id', 0);
        $statusIncluded = $request->get('status', []);
        $statusExcluded = [];
        $dateFrom       = $request->get('date_from', '');
        $dateTo         = $request->get('date_to', '');
        $listData       = $this->bookingRepository->getAllEnabledWithConditions(
            $userId,
            $teacherId,
            $statusIncluded,
            $statusExcluded,
            $dateFrom,
            $dateTo,
            'updated_at',
            'desc'
        );

        $listExport = [];
        foreach ($listData as $data) {
            $item                           = [];
            $item['teacher_id']             = $data->teacher_id;
            $item['teacher_name']           = $data->present()->teacherName;
            $item['teacher_email']          = $data->present()->teacherEmail;
            $item['user_name']              = $data->present()->userName;
            $item['user_email']             = $data->present()->userEmail;
            $item['time_counselling_start'] = $data->present()->timeSlotStart;
            $item['time_counselling_end']   = $data->present()->timeSlotEnd;
            $item['status']                 = $data->status;
            array_push($listExport, $item);
        }

        $fileName = 'booking-data'.'_'.date('Y-m-d_H-i-s');
        $rowTitle = [
            'Teacher Id',
            'Teacher name',
            'Teacher email',
            'User name',
            'User email',
            'Time counselling Start',
            'Time counselling End',
            'Status',
        ];
        $datas = ['listExport'=> $listExport,
            'rowTitle'        => $rowTitle,
            'title'           => config('site.name', '')."'s Counsellings",
            'fileName'        => $fileName,
        ];
        $this->excelService->export($datas, $fileName);
    }

    public function cancelBooking($booking_id)
    {
        $booking = $this->bookingRepository->find($booking_id);
        $now     = \DateTimeHelper::now();
        if (!empty($booking) && $booking->timeSlot->start_at > $now) {
            $input = ['status' => 'canceled'];
            $this->bookingRepository->update($booking, $input);
        } else {
            return redirect()->action('Admin\BookingController@index')
                ->with('message-failed', trans('admin.messages.general.cancel_failed'));
        }
        $this->pointService->refundPoints($booking->user->id, config('point.point_per_refund'), $booking->id);
        $this->bookingService->adminCancelBooking($booking);

        return redirect()->action('Admin\BookingController@index')
            ->with('message-success', trans('admin.messages.general.cancel_success'));
    }
}
