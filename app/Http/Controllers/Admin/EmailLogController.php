<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\EmailLogRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\EmailLogRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class EmailLogController extends Controller
{
    /** @var \App\Repositories\EmailLogRepositoryInterface */
    protected $emailLogRepository;

    /** @var \App\Repositories\UserRepositoryInterface */
    protected $userRepository;

    public function __construct(
        EmailLogRepositoryInterface $emailLogRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->emailLogRepository = $emailLogRepository;
        $this->userRepository     = $userRepository;
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
        $users          = $this->userRepository->all('name', 'asc');
        $oldEmail       = $request->get('old_email', '');
        $newEmail       = $request->get('new_email', '');
        $status         = $request->get('status', -1);
        $userId         = $request->get('user_id', 0);
        $validationCode = $request->get('validation_code', '');
        $count          = $this->emailLogRepository->countEnabledWithConditions(
            $oldEmail,
            $newEmail,
            $userId,
            $status,
            $validationCode
        );
        $models = $this->emailLogRepository->getEnabledWithConditions(
            $oldEmail,
            $newEmail,
            $userId,
            $status,
            $validationCode,
            'updated_at',
            'desc',
            $offset,
            $limit
        );

        return view('pages.admin.email-logs.index', [
            'models'                  => $models,
            'count'                   => $count,
            'offset'                  => $offset,
            'limit'                   => $limit,
            'oldEmail'                => $oldEmail,
            'newEmail'                => $newEmail,
            'userId'                  => $userId,
            'users'                   => $users,
            'status'                  => $status,
            'validationCode'          => $validationCode,
            'params'                  => [
                'old_email'                 => $oldEmail,
                'new_email'                 => $newEmail,
                'user_id'                   => $userId,
                'status'                    => $status,
                'validation_code'           => $validationCode,
            ],
            'baseUrl' => action('Admin\EmailLogController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.email-logs.edit', [
            'isNew'     => true,
            'users'     => $this->userRepository->all('name', 'asc'),
            'emailLog'  => $this->emailLogRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(EmailLogRequest $request)
    {
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
        $model = $this->emailLogRepository->find($id);
        if (empty($model)) {
            abort(404);
        }

        return view('pages.admin.email-logs.edit', [
            'isNew'     => false,
            'users'     => $this->userRepository->all('name', 'asc'),
            'emailLog'  => $model,
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
    public function update($id, EmailLogRequest $request)
    {
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
        /** @var \App\Models\EmailLog $model */
        $model = $this->emailLogRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $this->emailLogRepository->delete($model);

        return redirect()->action('Admin\EmailLogController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }
}
