<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\PurchaseLogRequest;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\PaginationRequest;
use App\Models\PurchaseLog;
use App\Repositories\PurchaseLogRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\PointServiceInterface;
use App\Services\Production\ExcelService;

class PurchaseLogController extends Controller
{
    /** @var \App\Repositories\PurchaseLogRepositoryInterface */
    protected $purchaseLogRepository;

    /** @var \App\Repositories\UserRepositoryInterface */
    protected $userRepository;

    /** @var ExcelService $excelService */
    protected $excelService;

    /** @var PointServiceInterface $pointService */
    protected $pointService;

    public function __construct(
        PurchaseLogRepositoryInterface $purchaseLogRepository,
        UserRepositoryInterface $userRepository,
        ExcelService $excelService,
        PointServiceInterface $pointService
    ) {
        $this->purchaseLogRepository = $purchaseLogRepository;
        $this->userRepository        = $userRepository;
        $this->excelService          = $excelService;
        $this->pointService          = $pointService;
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
        $offset             = $request->offset();
        $limit              = $request->limit();
        $purchaseMethodType = $request->get('purchase_method_type', '');
        $pointAmount        = $request->get('point_amount', 0);
        $userId             = $request->get('user_id', 0);
        $users              = $this->userRepository->all('id', 'desc');
        $count              = $this->purchaseLogRepository->countEnabledWithConditions($purchaseMethodType, $pointAmount, $userId);
        $models             = $this->purchaseLogRepository->getEnabledWithConditions(
            $purchaseMethodType,
            $pointAmount,
            $userId,
            'updated_at',
            'desc',
            $offset,
            $limit
        );

        return view('pages.admin.purchase-logs.index', [
            'models'             => $models,
            'count'              => $count,
            'types'              => [PurchaseLog::PURCHASE_TYPE_PAYPAL, PurchaseLog::PURCHASE_TYPE_BY_ADMIN],
            'offset'             => $offset,
            'limit'              => $limit,
            'users'              => $users,
            'purchaseMethodType' => $purchaseMethodType,
            'pointAmount'        => $pointAmount,
            'userId'             => $userId,
            'params'             => [
                'purchase_method_type' => $purchaseMethodType,
                'point_amount'         => $pointAmount,
                'user_id'              => $userId,
            ],
            'baseUrl'            => action('Admin\PurchaseLogController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.purchase-logs.edit', [
            'isNew'       => true,
            'purchaseLog' => $this->purchaseLogRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(PurchaseLogRequest $request)
    {
        $input                     = $request->only(['purchase_method_type', 'point_amount', 'purchase_info', 'user_id']);
        $input['point_expired_at'] = \DateTimeHelper::now();

        /** @var \App\Models\PurchaseLog $model */
        $model = $this->purchaseLogRepository->create($input);
        $model = $this->pointService->setPointExpiredAt($model);

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\PurchaseLogController@index')->with(
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
        $model = $this->purchaseLogRepository->find($id);
        if (empty($model)) {
            abort(404);
        }

        return view('pages.admin.purchase-logs.edit', [
            'isNew'       => false,
            'purchaseLog' => $model,
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
    public function update($id, PurchaseLogRequest $request)
    {
        /** @var \App\Models\PurchaseLog $model */
        $model = $this->purchaseLogRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $input = $request->only(['purchase_method_type', 'point_amount', 'purchase_info', 'user_id']);

        $this->purchaseLogRepository->update($model, $input);

        return redirect()->action('Admin\PurchaseLogController@show', [$id])->with(
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
        /** @var \App\Models\PurchaseLog $model */
        $model = $this->purchaseLogRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $this->purchaseLogRepository->delete($model);

        return redirect()->action('Admin\PurchaseLogController@index')->with(
            'message-success',
                trans('admin.messages.general.delete_success')
        );
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
        $purchaseMethodType = $request->get('purchase_method_type', '');
        $pointAmount        = $request->get('point_amount', 0);
        $userId             = $request->get('user_id', 0);
        $listData           = $this->purchaseLogRepository->getAllEnabledWithConditions(
            $purchaseMethodType,
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
            $purchaseInfo = $data->purchase_info;
            if ($data->purchase_method_type == PurchaseLog::PURCHASE_TYPE_PAYPAL) {
                $purchaseInfoDecode = json_decode($data->purchase_info);
                if (!empty($purchaseInfoDecode->id)) {
                    $purchaseInfo .= 'PaymentId: '.$purchaseInfoDecode->id.',';
                }
                if (!empty($purchaseInfoDecode->state)) {
                    $purchaseInfo .= 'State: '.$purchaseInfoDecode->state.',';
                }
                if (!empty($purchaseInfoDecode->payer->payer_info->shipping_address->recipient_name)) {
                    $purchaseInfo .= 'Name: '.$purchaseInfoDecode->payer->payer_info->shipping_address->recipient_name.',';
                }
                if (!empty($purchaseInfoDecode->transactions) && count($purchaseInfoDecode->transactions) > 0) {
                    $purchaseInfo .= 'Transactions amount: '.$purchaseInfoDecode->transactions[0]->amount->total
                        .$purchaseInfoDecode->transactions[0]->amount->currency;
                }
            }
            $item                         = [];
            $item['id']                   = $data->id;
            $item['user_name']            = $userName;
            $item['user_email']           = $userEmail;
            $item['point_amount']         = $data->point_amount;
            $item['purchase_method_type'] = $data->purchase_method_type;
            $item['purchase_info']        = $purchaseInfo;
            $item['created_at']           = $data->present()->createdAt;
            array_push($listExport, $item);
        }

        $fileName = 'PurchaseLog-data'.'_'.date('Y-m-d_H-i-s');
        $rowTitle = [
            'PurchaseLog Id',
            'User name',
            'User email',
            'Point amount',
            'Purchase method Type',
            'Purchase Info',
            'Created at',
        ];
        $datas = [
            'listExport' => $listExport,
            'rowTitle'   => $rowTitle,
            'title'      => config('site.name', '')."'s PurchaseLog",
            'fileName'   => $fileName,
        ];
        $this->excelService->export($datas, $fileName);
    }
}
