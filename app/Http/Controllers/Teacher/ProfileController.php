<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\TeacherProfileUpdateRequest;
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
use App\Services\Production\TeacherService;

class ProfileController extends Controller
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
        TeacherService $teacherService
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
        $this->teacherService               = $teacherService;
    }

    public function show()
    {
        $teacher = $this->teacherService->getUser();
        $model   = $this->teacherRepository->find($teacher->id);
        if (empty($model)) {
            \App::abort(404);
        }
        $provinces = $this->provinceRepository->allByCountryCode($teacher->nationality_country_code);

        return view('pages.teacher.profile.edit', [
            'isNew'         => false,
            'countries'     => $this->countryRepository->all('order', 'asc'),
            'cities'        => $this->cityRepository->all('order', 'asc'),
            'provinces'     => $provinces,
            'personalities' => $this->personalityRepository->all('order', 'asc'),
            'teacher'       => $model,
            'titlePage'     => trans('teacher.pages.title.profile'),
        ]);
    }

    public function updateProfile(TeacherProfileUpdateRequest $request)
    {
        /** @var \App\Models\Teacher $model */
        $teacher = $this->teacherService->getUser();
        $model   = $this->teacherRepository->find($teacher->id);
        if (empty($model)) {
            \App::abort(404);
        }
        $input = $request->only([
            'name',
            'skype_id',
            'year_of_birth',
            'gender',
            'living_country_code',
            'living_city_id',
            'hobby',
            'self_introduction',
            'home_province_id', ]);

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
        $personalityId = $request->get('personality_id', []);
        $this->teacherPersonalityRepository->updateList($model->id, $personalityId);

        return redirect()->action('Teacher\ProfileController@show')
            ->with('message-success', trans('admin.messages.general.update_success'));
    }
}
