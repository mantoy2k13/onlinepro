<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserNotificationRequest;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\PaginationRequest;
use App\Models\Notification;
use App\Repositories\UserNotificationRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class UserNotificationController extends Controller
{
    /** @var \App\Repositories\UserNotificationRepositoryInterface */
    protected $userNotificationRepository;

    /** @var \App\Repositories\UserNotificationRepositoryInterface */
    protected $userRepository;

    public function __construct(
        UserNotificationRepositoryInterface $userNotificationRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->userNotificationRepository = $userNotificationRepository;
        $this->userRepository             = $userRepository;
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
        $categoryType = $request->get('category_type', '');
        $type         = $request->get('type', '');
        $userId       = $request->get('user_id', 0);
        $user         = $this->userRepository->find($userId);
        $read         = $request->get('read', -1);
        $users        = $this->userRepository->all('name', 'asc');
        $count        = $this->userNotificationRepository->countEnabledWithConditions($categoryType, $type, $user, $read);
        $models       = $this->userNotificationRepository->getEnabledWithConditions($categoryType, $type, $user, $read, 'updated_at', 'desc', $offset, $limit);

        return view('pages.admin.user-notifications.index', [
            'models'        => $models,
            'count'         => $count,
            'types'         => [Notification::TYPE_BOOKING_ALERT,
                Notification::TYPE_POINT_ALERT,
                Notification::TYPE_GENERAL_ALERT,
                Notification::TYPE_GENERAL_MESSAGE,
            ],
            'categories'    => [Notification::CATEGORY_TYPE_BOOKING,
                Notification::CATEGORY_TYPE_CANCEL,
                Notification::CATEGORY_TYPE_EXPIRE,
                Notification::CATEGORY_TYPE_PURCHASE,
                Notification::CATEGORY_TYPE_SYSTEM_MESSAGE,
            ],
            'offset'        => $offset,
            'limit'         => $limit,
            'categoryType'  => $categoryType,
            'type'          => $type,
            'userId'        => $userId,
            'users'         => $users,
            'read'          => $read,
            'params'        => [
                'category_type'     => $categoryType,
                'type'              => $type,
                'user_id'           => $userId,
                'read'              => $read,
            ],
            'baseUrl' => action('Admin\UserNotificationController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param BaseRequest $request
     *
     * @return \Response
     */
    public function create(BaseRequest $request)
    {
        $userId = $request->get('user_id');
        $model  = $this->userNotificationRepository->getBlankModel();
        if ($userId !== null) {
            $model->user_id = (int) $userId;
        }

        $users = $this->userRepository->all('name', 'asc');

        return view('pages.admin.user-notifications.edit', [
            'isNew' => true,
            'types' => [Notification::TYPE_BOOKING_ALERT,
                Notification::TYPE_POINT_ALERT,
                Notification::TYPE_GENERAL_ALERT,
                Notification::TYPE_GENERAL_MESSAGE,
            ],
            'categories'    => [Notification::CATEGORY_TYPE_BOOKING,
                Notification::CATEGORY_TYPE_CANCEL,
                Notification::CATEGORY_TYPE_EXPIRE,
                Notification::CATEGORY_TYPE_PURCHASE,
                Notification::CATEGORY_TYPE_SYSTEM_MESSAGE,
            ],
            'userNotification' => $model,
            'users'            => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(UserNotificationRequest $request)
    {
        $input            = $request->only(['user_id', 'category_type', 'type', 'locale', 'content', 'title']);
        $input['data']    = json_decode($request->get('data', ''));
        $input['sent_at'] = \DateTimeHelper::now();

        $model = $this->userNotificationRepository->create($input);

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\UserNotificationController@index')->with(
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
        $model = $this->userNotificationRepository->find($id);
        if (empty($model)) {
            abort(404);
        }

        return view('pages.admin.user-notifications.edit', [
            'isNew' => false,
            'types' => [Notification::TYPE_BOOKING_ALERT,
                Notification::TYPE_POINT_ALERT,
                Notification::TYPE_GENERAL_ALERT,
                Notification::TYPE_GENERAL_MESSAGE,
            ],
            'categories'    => [Notification::CATEGORY_TYPE_BOOKING,
                Notification::CATEGORY_TYPE_CANCEL,
                Notification::CATEGORY_TYPE_EXPIRE,
                Notification::CATEGORY_TYPE_PURCHASE,
                Notification::CATEGORY_TYPE_SYSTEM_MESSAGE,
            ],
            'userNotification' => $model,
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
    public function update($id, UserNotificationRequest $request)
    {
        /** @var \App\Models\UserNotification $model */
        $model = $this->userNotificationRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $input         = $request->only(['user_id', 'category_type', 'type', 'locale', 'content', 'title']);
        $input['data'] = json_decode($request->get('data', ''));
        $this->userNotificationRepository->update($model, $input);

        return redirect()->action('Admin\UserNotificationController@show', [$id])->with(
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
        /** @var \App\Models\UserNotification $model */
        $model = $this->userNotificationRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $this->userNotificationRepository->delete($model);

        return redirect()->action('Admin\UserNotificationController@index')->with(
            'message-success',
                trans('admin.messages.general.delete_success')
        );
    }
}
