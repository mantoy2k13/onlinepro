<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\PaymentLogRequest;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\PaymentLogRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use App\Services\Production\ExcelService;

class PaymentLogController extends Controller
{
    /** @var \App\Repositories\PaymentLogRepositoryInterface */
    protected $paymentLogRepository;

    protected $teacherRepository;

    /** @var ExcelService $excelService */
    protected $excelService;

    public function __construct(
        PaymentLogRepositoryInterface $paymentLogRepository,
        TeacherRepositoryInterface $teacherRepository,
        ExcelService $excelService
    ) {
        $this->paymentLogRepository = $paymentLogRepository;
        $this->teacherRepository    = $teacherRepository;
        $this->excelService         = $excelService;
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
        $status       = $request->get('status', '');
        $paidAmount   = $request->get('paid_amount', 0);
        $paidForMonth = $request->get('paid_for_month', '');
        $teacherId    = $request->get('teacher_id', 0);
        $teachers     = $this->teacherRepository->all('name', 'asc');
        $count        = $this->paymentLogRepository->countEnabledWithConditions($status, $paidAmount, $teacherId, $paidForMonth);
        $models       = $this->paymentLogRepository->getEnabledWithConditions(
            $status,
            $paidAmount,
            $teacherId,
            $paidForMonth,
            'updated_at',
            'desc',
            $offset,
            $limit
        );

        return view('pages.admin.payment-logs.index', [
            'models'        => $models,
            'count'         => $count,
            'offset'        => $offset,
            'limit'         => $limit,
            'teachers'      => $teachers,
            'status'        => $status,
            'paidAmount'    => $paidAmount,
            'teacherId'     => $teacherId,
            'paidForMonth'  => $paidForMonth,
            'params'        => [
                'status'          => $status,
                'paid_amount'     => $paidAmount,
                'teacher_id'      => $teacherId,
                'paid_for_month'  => $paidForMonth,
            ],
            'baseUrl' => action('Admin\PaymentLogController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.payment-logs.edit', [
            'isNew'      => true,
            'teachers'   => $this->teacherRepository->all('name', 'asc'),
            'paymentLog' => $this->paymentLogRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(PaymentLogRequest $request)
    {
        $input = $request->only(['status', 'paid_amount', 'note', 'teacher_id',
            'paid_for_month', 'paid_at', ]);

        $model = $this->paymentLogRepository->create($input);

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\PaymentLogController@index')
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
        $model = $this->paymentLogRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }

        return view('pages.admin.payment-logs.edit', [
            'isNew'      => false,
            'teachers'   => $this->teacherRepository->all('name', 'asc'),
            'paymentLog' => $model,
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
    public function update($id, PaymentLogRequest $request)
    {
        /** @var \App\Models\PaymentLog $model */
        $model = $this->paymentLogRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $input = $request->only(['status', 'paid_amount', 'note', 'paid_for_month', 'paid_at']);

        $this->paymentLogRepository->update($model, $input);

        return redirect()->action('Admin\PaymentLogController@show', [$id])
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
        /** @var \App\Models\PaymentLog $model */
        $model = $this->paymentLogRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $this->paymentLogRepository->delete($model);

        return redirect()->action('Admin\PaymentLogController@index')
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
        $status       = $request->get('status', '');
        $paidAmount   = $request->get('paid_amount', 0);
        $teacherId    = $request->get('teacher_id', 0);
        $paidForMonth = $request->get('paid_for_month', '');
        $listData     = $this->paymentLogRepository->getAllEnabledWithConditions(
            $paidAmount,
            $teacherId,
            $status,
            $paidForMonth,
            'updated_at',
            'desc'
        );

        $listExport = [];
        foreach ($listData as $data) {
            $teacherName  = '';
            $teacherEmail = '';
            if (!empty($data->teacher)) {
                $teacherName  = $data->teacher->name;
                $teacherEmail = $data->teacher->email;
            }

            $item                   = [];
            $item['id']             = $data->id;
            $item['teacher_name']   = $teacherName;
            $item['teacher_email']  = $teacherEmail;
            $item['paid_amount']    = $data->paid_amount;
            $item['paid_for_month'] = $data->paid_for_month;
            $item['status']         = $data->status;
            $item['note']           = $data->note;
            $item['created_at']     = $data->created_at;
            array_push($listExport, $item);
        }

        $fileName = 'PaymentLog-data'.'_'.date('Y-m-d_H-i-s');
        $rowTitle = [
            'Payment Id',
            'Teacher name',
            'Teacher email',
            'Paid amount',
            'Paid for month',
            'Status',
            'Note',
            'Created at',
        ];
        $datas = ['listExport'=> $listExport,
            'rowTitle'        => $rowTitle,
            'title'           => config('site.name', '')."'s PaymentLog",
            'fileName'        => $fileName,
        ];
        $this->excelService->export($datas, $fileName);
    }
}
