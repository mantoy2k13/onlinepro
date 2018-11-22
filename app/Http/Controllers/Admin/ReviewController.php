<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Http\Requests\Admin\ReviewRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\ReviewRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\Production\ExcelService;
use App\Services\TeacherServiceInterface;

class ReviewController extends Controller
{
    /** @var \App\Repositories\ReviewRepositoryInterface */
    protected $reviewRepository;

    protected $userRepository;

    protected $teacherRepository;

    /** @var ExcelService $excelService */
    protected $excelService;

    /** @var TeacherServiceInterface $teacherService */
    protected $teacherService;

    public function __construct(
        ReviewRepositoryInterface $reviewRepository,
        UserRepositoryInterface $userRepository,
        TeacherRepositoryInterface $teacherRepository,
        ExcelService $excelService,
        TeacherServiceInterface $teacherService
    ) {
        $this->reviewRepository  = $reviewRepository;
        $this->userRepository    = $userRepository;
        $this->teacherRepository = $teacherRepository;
        $this->excelService      = $excelService;
        $this->teacherService    = $teacherService;
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
        $offset    = $request->offset();
        $limit     = $request->limit();
        $userId    = $request->get('user_id', 0);
        $teacherId = $request->get('teacher_id', 0);
        $rating    = $request->get('rating', '');
        $target    = 'teacher';
        $users     = $this->userRepository->all('name', 'asc');
        $teachers  = $this->teacherRepository->all('name', 'asc');
        $count     = $this->reviewRepository->countEnabledWithConditions($target, $userId, $teacherId, $rating);
        $models    = $this->reviewRepository->getEnabledWithConditions(
            $target,
            $userId,
            $teacherId,
            $rating,
            'updated_at',
            'desc',
            $offset,
            $limit
        );

        return view('pages.admin.reviews.index', [
            'models'     => $models,
            'count'      => $count,
            'offset'     => $offset,
            'limit'      => $limit,
            'users'      => $users,
            'teachers'   => $teachers,
            'userId'     => $userId,
            'teacherId'  => $teacherId,
            'rating'     => $rating,
            'params'     => [
                'user_id'     => $userId,
                'teacher_id'  => $teacherId,
                'rating'      => $rating,
            ],
            'baseUrl' => action('Admin\ReviewController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.reviews.edit', [
            'isNew'     => true,
            'teachers'  => $this->teacherRepository->all('name', 'asc'),
            'users'     => $this->userRepository->all('name', 'asc'),
            'review'    => $this->reviewRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(ReviewRequest $request)
    {
        $input = $request->only(['teacher_id', 'user_id', 'rating', 'booking_id', 'content']);

        $model = $this->reviewRepository->create($input);
        $this->teacherService->updateTeacherRating($input['teacher_id']);
        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\ReviewController@index')
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
        $model = $this->reviewRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }

        return view('pages.admin.reviews.edit', [
            'isNew'    => false,
            'teachers' => $this->teacherRepository->all('name', 'asc'),
            'users'    => $this->userRepository->all('name', 'asc'),
            'review'   => $model,
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
    public function update($id, ReviewRequest $request)
    {
        /** @var \App\Models\Review $model */
        $model = $this->reviewRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $input = $request->only(['rating', 'content']);

        $this->reviewRepository->update($model, $input);
        $this->teacherService->updateTeacherRating($model->teacher_id);

        return redirect()->action('Admin\ReviewController@show', [$id])
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
        /** @var \App\Models\Review $model */
        $model = $this->reviewRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $this->reviewRepository->delete($model);

        return redirect()->action('Admin\ReviewController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

    /**
     * Export booking counselling to excel .
     *
     * @param int $request
     *
     * @return \Maatwebsite\Excel\
     */
    public function exportExcel(Requests\BaseRequest $request)
    {
        $userId    = $request->get('user_id', 0);
        $teacherId = $request->get('teacher_id', 0);
        $rating    = $request->get('rating', '');
        $target    = 'teacher';
        $listData  = $this->reviewRepository->getAllEnabledWithConditions($target, $userId, $teacherId, $rating, 'updated_at', 'desc');

        $listExport = [];
        foreach ($listData as $data) {
            $startTime = '';
            if (!empty($data->booking)) {
                $startTime = $data->booking->timeSlot->start_at;
            }
            $rating = '';
            if (!empty($data->rating) && ($data->target != 'user')) {
                $rating = $data->rating;
            }
            $userName = '';
            if (!empty($data->user)) {
                $userName = $data->user->name;
            }
            $teacherName = '';
            if (!empty($data->teacher)) {
                $teacherName = $data->teacher->name;
            }

            $item                 = [];
            $item['id']           = $data->id;
            $item['target']       = $data->target;
            $item['user_name']    = $userName;
            $item['teacher_name'] = $teacherName;
            $item['booking_id']   = $data->booking_id;
            $item['start_at']     = $startTime;
            $item['rating']       = $rating;
            $item['content']      = $data->content;
            array_push($listExport, $item);
        }

        $fileName = 'reviews-data'.'_'.date('Y-m-d_H-i-s');
        $rowTitle = [
            'Review Id',
            'Target',
            'User name',
            'Teacher name',
            'Booking Id',
            'Start time Counselling',
            'Rating',
            'Content',
        ];
        $datas = ['listExport'=> $listExport,
            'rowTitle'        => $rowTitle,
            'title'           => config('site.name', '')."'s reviews",
            'fileName'        => $fileName,
        ];
        $this->excelService->export($datas, $fileName);
    }
}
