<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\FavoriteTeacherRepositoryInterface;
use App\Repositories\PersonalityRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use App\Repositories\TimeSlotRepositoryInterface;
use App\Services\TeacherServiceInterface;
use App\Services\UserServiceInterface;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /** @var \App\Repositories\CategoryRepositoryInterface */
    protected $categoryRepository;

    /** @var \App\Repositories\PersonalityRepositoryInterface */
    protected $personalityRepository;

    /** @var \App\Repositories\CountryRepositoryInterface */
    protected $countryRepository;

    /** @var \App\Repositories\TeacherRepositoryInterface */
    protected $teacherRepository;

    /** @var \App\Services\TeacherServiceInterface */
    protected $teacherService;

    /** @var \App\Repositories\TimeSlotRepositoryInterface */
    protected $timeSlotRepository;

    /** @var FavoriteTeacherRepositoryInterface $favoriteTeacherRepository */
    protected $favoriteTeacherRepository;

    /** @var \App\Services\UserServiceInterface */
    protected $userService;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        PersonalityRepositoryInterface $personalityRepository,
        CountryRepositoryInterface $countryRepository,
        TeacherRepositoryInterface $teacherRepository,
        TeacherServiceInterface $teacherService,
        TimeSlotRepositoryInterface $timeSlotRepository,
        FavoriteTeacherRepositoryInterface $favoriteTeacherRepository,
        UserServiceInterface $userService
    ) {
        $this->categoryRepository        = $categoryRepository;
        $this->personalityRepository     = $personalityRepository;
        $this->countryRepository         = $countryRepository;
        $this->teacherRepository         = $teacherRepository;
        $this->teacherService            = $teacherService;
        $this->timeSlotRepository        = $timeSlotRepository;
        $this->favoriteTeacherRepository = $favoriteTeacherRepository;
        $this->userService               = $userService;
    }

    public function index($slug, PaginationRequest $request)
    {
        $user   = $this->userService->getUser();
        $offset = $request->offset();
        $limit  = $request->limit(8);

        $category = $this->categoryRepository->findBySlug($slug);
        if (!$category) {
            abort(404);
        }
        $personalities = $this->personalityRepository->all();
        $countries     = $this->countryRepository->all('order', 'asc');

        $countryCode   = $request->get('country_code', '');
        $personalityId = 0;
        $date          = $request->get('date', date('Y-m-d'));
        $timeArray     = config('timeslot.timeSlot');
        $teachers      = $this->teacherRepository->getTeacherFreeWithConditions($category->id, $countryCode, $personalityId, $date, 'name', 'asc', $offset, $limit);
        $count         = $this->teacherRepository->countTeacherFreeWithConditions($category->id, $countryCode, $personalityId, $date, 'name', 'asc');
        foreach ($teachers as $key => $teacher) {
            $teachers[$key]->rating = $this->teacherService->genRatingTeacher($teacher->id);
            $timeSlotAvail          = $this->timeSlotRepository->allAvailByConditions($teacher->id, $date);
            $timeSlots              = [];
            foreach ($timeArray as $tms) {
                $timeSlotValue              = $date.' '.$tms;
                $timeSlot['value']          = $tms;
                $timeSlot['datetime-value'] = $timeSlotValue;
                $timeSlot['timeSlot']       = $this->teacherService->teacherAvail($timeSlotValue, $timeSlotAvail);
                array_push($timeSlots, $timeSlot);
            }
            $teacher->timeSlots = $timeSlots;

            $isFavorite = false;
            if (!empty($user)) {
                $favorite = $this->favoriteTeacherRepository->findByUserIdAndTeacherId($user->id, $teacher->id);
                if (!empty($favorite)) {
                    $isFavorite = true;
                }
            }
            $teacher->isMyFavorite = $isFavorite;
        }

        return view(
            'pages.user.category.index',
            [
                'date'          => Carbon::parse($date),
                'teachers'      => $teachers,
                'offset'        => $offset,
                'limit'         => $limit,
                'count'         => $count,
                'category'      => $category,
                'countryCode'   => $countryCode,
                'countries'     => $countries,
                'personalities' => $personalities,
                'back'          => Carbon::parse($date)->subDay(),
                'forward'       => Carbon::parse($date)->addDay(),
                'params'        => [
                    'date'         => Carbon::parse($date)->format('Y-m-d'),
                    'country_code' => $countryCode,
                ],
                'baseUrl' => action('User\CategoryController@index', $slug), ]
        );
    }

    public function teacher($id)
    {
        if (!is_numeric($id) || ($id < 0)) {
            return redirect()->action('User\CategoryController@index', 1);
        }

        $teacher = $this->teacherRepository->find($id);
        if (!$teacher) {
            return redirect()->action('User\CategoryController@index', 1);
        }
        $user       = $this->userService->getUser();
        $isFavorite = false;
        if (!empty($user)) {
            $favorite = $this->favoriteTeacherRepository->findByUserIdAndTeacherId($user->id, $teacher->id);
            if (!empty($favorite)) {
                $isFavorite = true;
            }
        }

        return view(
            'pages.user.category.teacher-profile',
            [
                'teacher'    => $teacher,
                'isFavorite' => $isFavorite,
            ]
        );
    }
}
