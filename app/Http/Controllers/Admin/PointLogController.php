<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\PointLogRequest;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\PaginationRequest;
use App\Models\PointLog;
use App\Repositories\PointLogRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\PointLogServiceInterface;
use App\Services\PointServiceInterface;
use App\Services\Production\ExcelService;
use App\Services\UserServiceInterface;

class PointLogController extends Controller
{
    /** @var \App\Repositories\PointLogRepositoryInterface */
    protected $pointLogRepository;

    /** @var \App\Repositories\UserRepositoryInterface */
    protected $userRepository;

    /** @var \App\Services\UserServiceInterface */
    protected $userService;

    /** @var \App\Services\PointLogServiceInterface */
    protected $pointLogService;

    /** @var ExcelService $excelService */
    protected $excelService;

    protected $pointService;

    public function __construct(
        PointLogRepositoryInterface $pointLogRepository,
        UserRepositoryInterface $userRepository,
        UserServiceInterface $userService,
        ExcelService $excelService,
        PointServiceInterface $pointService,
        PointLogServiceInterface $pointLogService
    ) {
        $this->pointLogRepository = $pointLogRepository;
        $this->userRepository     = $userRepository;
        $this->userService        = $userService;
        $this->excelService       = $excelService;
        $this->pointService       = $pointService;
        $this->pointLogService    = $pointLogService;
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
        $offset      = $request->offset();
        $limit       = $request->limit();
        $type        = $request->get('type', '');
        $pointAmount = $request->get('point_amount', 0);
        $userId      = $request->get('user_id', 0);
        $users       = $this->userRepository->all('name', 'asc');
        $count       = $this->pointLogRepository->countEnabledWithConditions($type, $pointAmount, $userId);
        $models      = $this->pointLogRepository->getEnabledWithConditions($type, $pointAmount, $userId, 'updated_at', 'desc', $offset, $limit);

        return view('pages.admin.point-logs.index', [
            'models'        => $models,
            'count'         => $count,
            'types'         => [PointLog::TYPE_BONUS, PointLog::TYPE_BOOKING, PointLog::TYPE_EXPIRED,
                PointLog::TYPE_PURCHASE,
                PointLog::TYPE_REFUND, PointLog::TYPE_DEDUCTED, ],
            'offset'         => $offset,
            'limit'          => $limit,
            'users'          => $users,
            'type'           => $type,
            'pointAmount'    => $pointAmount,
            'userId'         => $userId,
            'params'         => [
                'type'          => $type,
                'point_amount'  => $pointAmount,
                'user_id'       => $userId,
            ],
            'baseUrl' => action('Admin\PointLogController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.point-logs.edit', [
            'isNew'      => true,
            'types'      => [PointLog::TYPE_BONUS, PointLog::TYPE_DEDUCTED],
            'users'      => $this->userRepository->all('name', 'asc'),
            'pointLog'   => $this->pointLogRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(PointLogRequest $request)
    {
        $input = $request->only(['point_amount', 'type', 'description', 'user_id']);
        $user  = $this->userRepository->find($input['user_id']);
        if (empty($user)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }
        $point = -1 * $user->points;
        if ($input['point_amount'] < $point) {
            return redirect()->back()->withErrors(trans('admin.errors.requests.point_log.point_amount_min', ['point_amount' => $point]));
        }
        $model       = $this->pointLogRepository->create($input);
        $purchaseLog = $this->pointService->addPointsByAdmin($model->user_id, $model, $action = 'new');
        if (!empty($purchaseLog)) {
            $pointLog = $this->pointLogRepository->update($model, [
                'purchase_log_id' => $purchaseLog->id,
            ]);
        }
        $this->pointLogService->sendNotification($model);

        return redirect()->action('Admin\PointLogController@index')
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
        $model = $this->pointLogRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }

        return view('pages.admin.point-logs.edit', [
            'isNew'      => false,
            'types'      => [PointLog::TYPE_BONUS, PointLog::TYPE_DEDUCTED],
            'users'      => $this->userRepository->all('name', 'asc'),
            'pointLog'   => $model,
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
    public function update($id, PointLogRequest $request)
    {
        return redirect()->action('Admin\PointLogController@show', [$id])
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
        return redirect()->action('Admin\PointLogController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

    /**
     * Export booking counselling to excel .
     *
     * @param BaseRequest $request
     *
     * @return \Maatwebsite\Excel\
     */
    public function exportExcel(BaseRequest $request)
    {
        $type        = $request->get('type', '');
        $pointAmount = $request->get('point_amount', 0);
        $userId      = $request->get('user_id', 0);
        $listData    = $this->pointLogRepository->getAllEnabledWithConditions(
            $type,
            $pointAmount,
            $userId,
            'updated_at',
            'desc'
        );

        $listExport = [];
        foreach ($listData as $data) {
            $userName  = '';
            $userEmail = '';
            if (!empty($data->user)) {
                $userName  = $data->user->name;
                $userEmail = $data->user->email;
            }
            $expireAt = '';
            if (!empty($data->purchaseLog) && $data->point_amount > 0) {
                $expireAt = $data->purchaseLog->point_expired_at;
            }

            $item                 = [];
            $item['id']           = $data->id;
            $item['user_name']    = $userName;
            $item['user_email']   = $userEmail;
            $item['point_amount'] = $data->point_amount;
            $item['type']         = $data->type;
            $item['description']  = $data->description;
            $item['created_at']   = $data->present()->createdAt;
            $item['expire_at']    = $expireAt;
            array_push($listExport, $item);
        }

        $fileName = 'PointLog-data'.'_'.date('Y-m-d_H-i-s');
        $rowTitle = [
            'PointLog Id',
            'User name',
            'User email',
            'Point amount',
            'Type',
            'Description',
            'Created at',
            'Expire at',
        ];
        $datas = ['listExport'=> $listExport,
            'rowTitle'        => $rowTitle,
            'title'           => config('site.name', '')."'s PaymentLog",
            'fileName'        => $fileName,
        ];
        $this->excelService->export($datas, $fileName);
    }
}
