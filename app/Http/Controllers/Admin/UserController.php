<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\UserRepositoryInterface;
use App\Services\Production\ExcelService;
use Illuminate\Support\MessageBag;

class UserController extends Controller
{
    /** @var \App\Repositories\UserRepositoryInterface */
    protected $userRepository;

    /** @var \Illuminate\Support\MessageBag */
    protected $messageBag;

    /** @var ExcelService $excelService */
    protected $excelService;

    public function __construct(
        UserRepositoryInterface $userRepositoryInterface,
        MessageBag $messageBag,
        ExcelService $excelService
    ) {
        $this->userRepository = $userRepositoryInterface;
        $this->messageBag     = $messageBag;
        $this->excelService   = $excelService;
    }

    public function index(PaginationRequest $request)
    {
        $offset = $request->offset();
        $limit  = $request->limit();

        $order     = $request->order();
        $direction = $request->direction('desc');

        $email   = $request->get('email', '');
        $name    = $request->get('name', '');
        $skypeId = $request->get('skype_id', '');
        $status  = $request->get('status', '');
        $count   = $this->userRepository->countEnabledWithConditions($name, $email, $skypeId, $status);
        $users   = $this->userRepository->getEnabledWithConditions(
            $name,
            $email,
            $skypeId,
            $status,
            $order,
            $direction,
            $offset,
            $limit
        );

        return view('pages.admin.users.index', [
            'users'     => $users,
            'offset'    => $offset,
            'limit'     => $limit,
            'count'     => $count,
            'order'     => $order,
            'direction' => $direction,
            'name'      => $name,
            'email'     => $email,
            'skypeId'   => $skypeId,
            'status'    => $status,
            'params'    => [
                'name'      => $name,
                'email'     => $email,
                'skype_id'  => $skypeId,
                'status'    => $status,
            ],
            'baseUrl' => action('Admin\UserController@index'),
        ]);
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        if (empty($user)) {
            abort(404);
        }

        return view('pages.admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function create()
    {
    }

    public function store(UserRequest $request)
    {
        $model = $this->userRepository->create($request->all());

        return redirect()->action('Admin\UserController@show', [$model->id])->with(
            'message-success',
            trans('admin.messages.general.create_success')
        );
    }

    public function update($id, UserRequest $request)
    {
        $user = $this->userRepository->find($id);
        if (empty($user)) {
            abort(404);
        }

        $this->userRepository->update($user, $request->all());

        return redirect()->action('Admin\UserController@show', [$id])->with(
            'message-success',
            trans('admin.messages.general.update_success')
        );
    }

    public function destroy($id)
    {
        $user = $this->userRepository->find($id);
        if (empty($user)) {
            abort(404);
        }
        $this->userRepository->delete($user);

        return redirect()->action('Admin\UserController@index')->with(
            'message-success',
            trans('admin.messages.general.delete_success')
        );
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
        $name     = $request->get('name', '');
        $email    = $request->get('email', '');
        $skypeId  = $request->get('stype_id', '');
        $status   = $request->get('status', '');
        $listData = $this->userRepository->getAllEnabledWithConditions($name, $email, $skypeId, $status, 'name', 'asc');

        $listExport = [];
        foreach ($listData as $data) {
            $points = '0';
            if (!empty($data->points)) {
                $points = $data->points;
            }
            $status = 'Confirmed';
            if ($data->present()->status == 'not_confirmed') {
                $status = 'Not Confirmed';
            } elseif ($data->present()->status == 'deleted') {
                $status = 'Deleted';
            }

            $item                  = [];
            $item['id']            = $data->id;
            $item['name']          = $data->name;
            $item['email']         = $data->email;
            $item['skype_id']      = $data->skype_id;
            $item['year_of_birth'] = $data->year_of_birth;
            $item['gender']        = $data->gender;
            $item['points']        = $points;
            $item['register_type'] = $data->present()->registerType;
            $item['created_at']    = $data->present()->createdAt;
            $item['status']        = $status;
            array_push($listExport, $item);
        }

        $fileName = 'users-data'.'_'.date('Y-m-d_H-i-s');
        $rowTitle = [
            'User Id',
            'User name',
            'User email',
            'Skype',
            'Year of birth',
            'Gender',
            'Points',
            'Type',
            'Created at',
            'Status',
        ];
        $datas = ['listExport'=> $listExport,
            'rowTitle'        => $rowTitle,
            'title'           => config('site.name', '')."'s Users",
            'fileName'        => $fileName,
        ];
        $this->excelService->export($datas, $fileName);
    }
}
