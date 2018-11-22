<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\TeacherNotificationRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\TeacherNotificationRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;

class TeacherNotificationController extends Controller
{
    /** @var \App\Repositories\TeacherNotificationRepositoryInterface */
    protected $teacherNotificationRepository;

    /** @var \App\Repositories\TeacherRepositoryInterface */
    protected $teacherRepository;

    public function __construct(
        TeacherNotificationRepositoryInterface $teacherNotificationRepository,
        TeacherRepositoryInterface $teacherRepository
    ) {
        $this->teacherNotificationRepository = $teacherNotificationRepository;
        $this->teacherRepository             = $teacherRepository;
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
        $offset       = $request->offset();
        $limit        = $request->limit();
        $users        = $this->teacherRepository->all('name', 'asc');
        $categoryType = $request->get('category_type', '');
        $type         = $request->get('type', '');
        $userId       = $request->get('user_id', 0);
        $read         = $request->get('read', -1);
        $title        = $request->get('title', '');
        $count        = $this->teacherNotificationRepository->countEnabledWithConditions(
            $title,
            $categoryType,
            $type,
            $userId,
            $read
        );
        $models = $this->teacherNotificationRepository->getEnabledWithConditions(
            $title,
            $categoryType,
            $type,
            $userId,
            $read,
            'updated_at',
            'desc',
            $offset,
            $limit
        );

        return view('pages.admin.teacher-notifications.index', [
            'models'       => $models,
            'users'        => $users,
            'count'        => $count,
            'offset'       => $offset,
            'limit'        => $limit,
            'categoryType' => $categoryType,
            'type'         => $type,
            'userId'       => $userId,
            'read'         => $read,
            'title'        => $title,
            'params'       => [
                'category_type' => $categoryType,
                'type'          => $type,
                'user_id'       => $userId,
                'read'          => $read,
                'title'         => $title,
            ],
            'baseUrl'      => action('Admin\TeacherNotificationController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.teacher-notifications.edit', [
            'isNew'               => true,
            'users'               => $this->teacherRepository->all('name', 'asc'),
            'teacherNotification' => $this->teacherNotificationRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(TeacherNotificationRequest $request)
    {
        $input         = $request->only(['user_id', 'category_type', 'type', 'content', 'locale', 'sent_at', 'title']);
        $input['data'] = json_decode($request->input('data', ''));
        $model         = $this->teacherNotificationRepository->create($input);

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\TeacherNotificationController@index')->with(
            'message-success',
                trans('admin.messages.general.create_success')
        );
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
        $model = $this->teacherNotificationRepository->find($id);
        if (empty($model)) {
            abort(404);
        }

        return view('pages.admin.teacher-notifications.edit', [
            'isNew'               => false,
            'users'               => $this->teacherRepository->all('name', 'asc'),
            'teacherNotification' => $model,
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
    public function update($id, TeacherNotificationRequest $request)
    {
        /** @var \App\Models\TeacherNotification $model */
        $model = $this->teacherNotificationRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $input         = $request->only(['user_id', 'category_type', 'type', 'content', 'locale', 'sent_at', 'title']);
        $input['read'] = $request->get('read', false);
        $input['data'] = json_decode($request->input('data', ''));
        $this->teacherNotificationRepository->update($model, $input);

        return redirect()->action('Admin\TeacherNotificationController@show', [$id])->with(
            'message-success',
                trans('admin.messages.general.update_success')
        );
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
        /** @var \App\Models\TeacherNotification $model */
        $model = $this->teacherNotificationRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $this->teacherNotificationRepository->delete($model);

        return redirect()->action('Admin\TeacherNotificationController@index')->with(
            'message-success',
                trans('admin.messages.general.delete_success')
        );
    }
}
