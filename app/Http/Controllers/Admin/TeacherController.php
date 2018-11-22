<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\TeacherRequest;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\LessonRepositoryInterface;
use App\Repositories\PersonalityRepositoryInterface;
use App\Repositories\ProvinceRepositoryInterface;
use App\Repositories\TeacherLessonRepositoryInterface;
use App\Repositories\TeacherPersonalityRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use App\Services\FileUploadServiceInterface;
use App\Services\ImageServiceInterface;
use App\Services\Production\ExcelService;

class TeacherController extends Controller
{
    /** @var \App\Repositories\TeacherRepositoryInterface */
    protected $teacherRepository;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;

    /** @var ImageRepositoryInterface $imageRepository */
    protected $imageRepository;

    /** @var ImageServiceInterface $imageService */
    protected $imageService;

    /** @var CountryRepositoryInterface $countryRepository */
    protected $countryRepository;

    /** @var CityRepositoryInterface $cityRepository */
    protected $cityRepository;

    /** @var ProvinceRepositoryInterface $provinceRepository */
    protected $provinceRepository;

    /** @var TeacherLessonRepositoryInterface $teacherLessonRepository */
    protected $teacherLessonRepository;

    /** @var TeacherPersonalityRepositoryInterface $teacherPersonalityRepository */
    protected $teacherPersonalityRepository;

    /** @var LessonRepositoryInterface $lessonRepository */
    protected $lessonRepository;

    /** @var PersonalityRepositoryInterface $personalityRepository */
    protected $personalityRepository;

    /** @var ExcelService $excelService */
    protected $excelService;

    public function __construct(
        TeacherRepositoryInterface $teacherRepository,
        FileUploadServiceInterface $fileUploadService,
        ImageRepositoryInterface $imageRepository,
        ImageServiceInterface $imageService,
        CountryRepositoryInterface $countryRepository,
        CityRepositoryInterface $cityRepository,
        ProvinceRepositoryInterface $provinceRepository,
        TeacherLessonRepositoryInterface $teacherLessonRepository,
        TeacherPersonalityRepositoryInterface $teacherPersonalityRepository,
        LessonRepositoryInterface $lessonRepository,
        PersonalityRepositoryInterface $personalityRepository,
        ExcelService $excelService
    ) {
        $this->teacherRepository            = $teacherRepository;
        $this->fileUploadService            = $fileUploadService;
        $this->imageRepository              = $imageRepository;
        $this->imageService                 = $imageService;
        $this->countryRepository            = $countryRepository;
        $this->cityRepository               = $cityRepository;
        $this->provinceRepository           = $provinceRepository;
        $this->teacherLessonRepository      = $teacherLessonRepository;
        $this->teacherPersonalityRepository = $teacherPersonalityRepository;
        $this->lessonRepository             = $lessonRepository;
        $this->personalityRepository        = $personalityRepository;
        $this->excelService                 = $excelService;
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
        $offset            = $request->offset();
        $limit             = $request->limit();
        $name              = $request->get('name', '');
        $email             = $request->get('email', '');
        $status            = $request->get('status', '');
        $livingCountryCode = $request->get('living_country_code', '');
        $livingCityId      = $request->get('living_city_id', 0);
        $countries         = $this->countryRepository->all('order', 'asc');
        $count             = $this->teacherRepository->countEnabledWithConditions($name, $email, $livingCountryCode, $livingCityId, $status);
        $models            = $this->teacherRepository->getEnabledWithConditions(
            $name,
            $email,
            $livingCountryCode,
            $livingCityId,
            $status,
            'updated_at',
            'desc',
            $offset,
            $limit
        );

        return view('pages.admin.teachers.index', [
            'models'            => $models,
            'count'             => $count,
            'offset'            => $offset,
            'limit'             => $limit,
            'countries'         => $countries,
            'name'              => $name,
            'email'             => $email,
            'livingCountryCode' => $livingCountryCode,
            'livingCityId'      => $livingCityId,
            'status'            => $status,
            'params'            => [
                'name'                  => $name,
                'email'                 => $email,
                'living_country_code'   => $livingCountryCode,
                'living_city_id'        => $livingCityId,
                'status'                => $status,
            ],
            'baseUrl' => action('Admin\TeacherController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.teachers.edit', [
            'isNew'         => true,
            'countries'     => $this->countryRepository->all('order', 'asc'),
            'cities'        => $this->cityRepository->all('order', 'asc'),
            'provinces'     => $this->provinceRepository->all('order', 'asc'),
            'personalities' => $this->personalityRepository->all('order', 'asc'),
            'teacher'       => $this->teacherRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(TeacherRequest $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|unique:teachers,email',
            'password' => 'required|min:6',
        ]);
        $input = $request->only([
            'name',
            'email',
            'password',
            'skype_id',
            'locale',
            'year_of_birth',
            'gender',
            'living_country_code',
            'living_start_date',
            'self_introduction',
            'introduction_from_admin',
            'hobby',
            'nationality_country_code',
            'bank_account_info',
            'home_province_id',
            'living_city_id', ]);
        $dateTimeColumns = ['living_start_date'];
        foreach ($dateTimeColumns as $dateTimeColumn) {
            if (array_key_exists($dateTimeColumn, $input) && !empty($input[$dateTimeColumn])) {
                $input[$dateTimeColumn] = \DateTimeHelper::convertToStorageDateTime($input[$dateTimeColumn]);
            } else {
                $input[$dateTimeColumn] = null;
            }
        }

        $model = $this->teacherRepository->create($input);

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        if ($request->hasFile('profile_image')) {
            $file      = $request->file('profile_image');
            $mediaType = $file->getClientMimeType();
            $path      = $file->getPathname();
            $image     = $this->fileUploadService->upload('teacher-profile-image', $path, $mediaType, [
                'entityType' => 'teacher-profile',
                'entityId'   => $model->id,
                'title'      => $request->input('name', ''),
            ]);

            if (!empty($image)) {
                $this->teacherRepository->update($model, [
                    'profile_image_id' => $image->id,
                ]);
            }
        }
        $lessonIds = $request->get('lesson_id', []);
        $this->teacherLessonRepository->updateList($model->id, $lessonIds);
        $personalities = $request->get('personality_id', []);
        $this->teacherPersonalityRepository->updateList($model->id, $personalities);

        return redirect()->action('Admin\TeacherController@index')
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
        $model = $this->teacherRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }

        return view('pages.admin.teachers.edit', [
            'isNew'         => false,
            'countries'     => $this->countryRepository->all('order', 'asc'),
            'cities'        => $this->cityRepository->all('order', 'asc'),
            'provinces'     => $this->provinceRepository->all('order', 'asc'),
            'personalities' => $this->personalityRepository->all('order', 'asc'),
            'teacher'       => $model,
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
    public function update($id, TeacherRequest $request)
    {
        /** @var \App\Models\Teacher $model */
        $model = $this->teacherRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $this->validate($request, [
            'email' => 'required|email|unique:teachers,email,'.$id,
        ]);
        $input = $request->only([
            'name',
            'email',
            'skype_id',
            'locale',
            'last_notification_id',
            'year_of_birth',
            'gender',
            'living_country_code',
            'living_city_id',
            'living_start_date',
            'self_introduction',
            'introduction_from_admin',
            'hobby',
            'nationality_country_code',
            'home_province_id',
            'bank_account_info', ]);
        $dateTimeColumns = ['living_start_date'];
        foreach ($dateTimeColumns as $dateTimeColumn) {
            if (array_key_exists($dateTimeColumn, $input) && !empty($input[$dateTimeColumn])) {
                $input[$dateTimeColumn] = \DateTimeHelper::createTimeFromString($input[$dateTimeColumn]);
            } else {
                $input[$dateTimeColumn] = null;
            }
        }
        $this->teacherRepository->update($model, $input);
        if ($request->hasFile('profile_image')) {
            $file      = $request->file('profile_image');
            $mediaType = $file->getClientMimeType();
            $path      = $file->getPathname();
            $image     = $this->fileUploadService->upload('teacher-profile-image', $path, $mediaType, [
                'entityType' => 'teacher-profile',
                'entityId'   => $model->id,
                'title'      => $request->input('name', ''),
            ]);

            if (!empty($image)) {
                $imageOld = $model->profileImage;
                if (!empty($imageOld)) {
                    $this->fileUploadService->delete($imageOld);
                    $this->imageRepository->delete($imageOld);
                }
                $this->teacherRepository->update($model, ['profile_image_id' => $image->id]);
            }
        }
        $lessonIds = $request->get('lesson_id', []);
        $this->teacherLessonRepository->updateList($model->id, $lessonIds);
        $personalities = $request->get('personality_id', []);
        $this->teacherPersonalityRepository->updateList($model->id, $personalities);

        return redirect()->action('Admin\TeacherController@show', [$id])
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
        /** @var \App\Models\Teacher $model */
        $model = $this->teacherRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $this->teacherRepository->delete($model);

        return redirect()->action('Admin\TeacherController@index')
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
        $name              = $request->get('name', '');
        $email             = $request->get('email', '');
        $livingCountryCode = $request->get('living_country_code', '');
        $livingCityId      = $request->get('living_city_id', 0);
        $status            = $request->get('status', '');
        $listData          = $this->teacherRepository->getAllEnabledWithConditions(
            $name,
            $email,
            $livingCountryCode,
            $livingCityId,
            $status,
            'name',
            'asc'
        );

        $listExport = [];
        foreach ($listData as $data) {
            $livingCountry = '';
            if (!empty($data->livingCountry)) {
                $livingCountry = $data->livingCountry->name_ja;
            }
            $livingCity = '';
            if (!empty($data->livingCity)) {
                $livingCity = $data->livingCity->name_ja;
            }
            $status = '';
            if ($data->present()->status == 'deleted') {
                $status = 'Deleted';
            }

            $item                        = [];
            $item['id']                  = $data->id;
            $item['name']                = $data->name;
            $item['email']               = $data->email;
            $item['skype_id']            = $data->skype_id;
            $item['year_of_birth']       = $data->year_of_birth;
            $item['gender']              = $data->gender;
            $item['living_country_code'] = $livingCountry;
            $item['living_city_id']      = $livingCity;
            $item['status']              = $status;
            array_push($listExport, $item);
        }

        $fileName = 'teachers-data'.'_'.date('Y-m-d_H-i-s');
        $rowTitle = [
            'Teacher Id',
            'Teacher name',
            'Teacher email',
            'Skype',
            'Year of birth',
            'Gender',
            'Living country',
            'Living city',
            'Status',
        ];
        $datas = ['listExport'=> $listExport,
            'rowTitle'        => $rowTitle,
            'title'           => "Sekaie's Teachers",
            'fileName'        => $fileName,
        ];
        $this->excelService->export($datas, $fileName);
    }
}
