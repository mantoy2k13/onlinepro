<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\FavoriteTeacherRepositoryInterface;
use App\Repositories\PersonalityRepositoryInterface;
use App\Repositories\ReviewRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use App\Repositories\TimeSlotRepositoryInterface;
use App\Services\BookingServiceInterface;
use App\Services\TeacherServiceInterface;
use App\Services\UserServiceInterface;
use Carbon\Carbon;

class IndexController extends Controller
{
    /** @var \App\Repositories\TeacherRepositoryInterface */
    protected $teacherRepository;

    /** @var FavoriteTeacherRepositoryInterface $favoriteTeacherRepository */
    protected $favoriteTeacherRepository;

    /** @var \App\Services\UserServiceInterface */
    protected $userService;

    /** @var \App\Repositories\CategoryRepositoryInterface */
    protected $categoryRepository;

    /** @var \App\Services\TeacherServiceInterface */
    protected $teacherService;

    /** @var \App\Repositories\TimeSlotRepositoryInterface */
    protected $timeSlotRepository;

    /** @var \App\Repositories\CountryRepositoryInterface */
    protected $countryRepository;

    /** @var \App\Repositories\PersonalityRepositoryInterface */
    protected $personalityRepository;

    /** @var \App\Services\BookingServiceInterface */
    protected $bookingService;

    /** @var \App\Repositories\ReviewRepositoryInterface */
    protected $reviewRepository;

    public function __construct(
        TeacherRepositoryInterface $teacherRepository,
        FavoriteTeacherRepositoryInterface $favoriteTeacherRepository,
        UserServiceInterface $userService,
        CategoryRepositoryInterface $categoryRepository,
        TeacherServiceInterface $teacherService,
        TimeSlotRepositoryInterface $timeSlotRepository,
        PersonalityRepositoryInterface $personalityRepository,
        BookingServiceInterface $bookingService,
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->teacherRepository         = $teacherRepository;
        $this->favoriteTeacherRepository = $favoriteTeacherRepository;
        $this->userService               = $userService;
        $this->categoryRepository        = $categoryRepository;
        $this->teacherService            = $teacherService;
        $this->timeSlotRepository        = $timeSlotRepository;
        $this->personalityRepository     = $personalityRepository;
        $this->bookingService            = $bookingService;
        $this->reviewRepository          = $reviewRepository;
    }

    public function index(PaginationRequest $request)
    {
        $user = $this->userService->getUser();
        if (empty($user)) {
            return \RedirectHelper::intended(action('User\AuthController@getSignIn'), $this->userService->getGuardName());
        }
        $bookingAbleToday = $this->bookingService->bookingAbleToday($user->id);
        $offset           = $request->offset();
        $limit            = $request->limit(8);
        $personalities    = $this->personalityRepository->all();
        $countryCode      = $request->get('country_code', '');
        $personalityId    = $request->get('personality_id', 0);
        $order            = $request->get('order', '');
        $sortTeacher      = $this->genSortTeacher($order);
        $date             = $request->get('date', \DateTimeHelper::nowInPresentationTimeZone()->format('Y-m-d'));
        $timeArray        = config('timeslot.timeSlot');
        $teachers         = $this->teacherRepository->getTeacherFreeWithConditions($countryCode, $personalityId, $date, $sortTeacher['order'], $sortTeacher['direction'], $offset, $limit);

        $count = $this->teacherRepository->countTeacherFreeWithConditions($countryCode, $personalityId, $date, $sortTeacher['order'], $sortTeacher['direction']);

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

        return view('pages.user.index', [
            'date'             => Carbon::parse($date),
            'teachers'         => $teachers,
            'offset'           => $offset,
            'limit'            => $limit,
            'count'            => $count,
            'countryCode'      => $countryCode,
            'personalities'    => $personalities,
            'personality_id'   => $personalityId,
            'titlePage'        => trans('user.pages.title.booking'),
            'back'             => Carbon::parse($date)->subDay(),
            'forward'          => Carbon::parse($date)->addDay(),
            'bookingAbleToday' => $bookingAbleToday,
            'params'           => [
                'date'           => Carbon::parse($date)->format('Y-m-d'),
                'country_code'   => $countryCode,
                'personality_id' => $personalityId,
            ],
            'baseUrl' => action('User\IndexController@index'), ]);
    }

    public function addFavoriteTeacher($teacherId)
    {
        $teacher = $this->teacherRepository->find($teacherId);
        $user    = $this->userService->getUser();
        if (!empty($teacher)) {
            $favorite = $this->favoriteTeacherRepository->findByUserIdAndTeacherId($user->id, $teacherId);
            if (empty($favorite)) {
                $this->favoriteTeacherRepository->create(['teacher_id' => $teacher->id, 'user_id' => $user->id]);
            }
        } else {
            return redirect()->back()->with('message-failed', trans('user.messages.general.add_favorite_failed'));
        }

        return redirect()->back()->with('message-success', trans('user.messages.general.add_favorite_success'));
    }

    public function removeFavoriteTeacher($teacherId)
    {
        $teacher = $this->teacherRepository->find($teacherId);
        $user    = $this->userService->getUser();
        if (!empty($teacher)) {
            $favorite = $this->favoriteTeacherRepository->findByUserIdAndTeacherId($user->id, $teacherId);
            if (!empty($favorite)) {
                $this->favoriteTeacherRepository->delete($favorite);
            }
        } else {
            return redirect()->back()->with('message-failed', trans('user.messages.general.delete_favorite_failed'));
        }

        return redirect()->back()->with('message-success', trans('user.messages.general.delete_favorite_success'));
    }

    public function favoriteTeachers(PaginationRequest $request)
    {
        $offset = $request->offset();
        $limit  = $request->limit(16);
        $user   = $this->userService->getUser();
        $models = $this->teacherRepository->getFavoriteTeacherByUserId($user->id, 'name', 'asc', $offset, $limit);
        $count  = $this->teacherRepository->countFavoriteTeacherByUserId($user->id);

        return view('pages.user.category.favorites', [
            'offset'    => $offset,
            'limit'     => $limit,
            'models'    => $models,
            'count'     => $count,
            'titlePage' => trans('user.pages.title.favorite'),
            'params'    => [],
            'baseUrl'   => action('User\IndexController@favoriteTeachers'),
        ]);
    }

    public function teacherProfile($id, PaginationRequest $request)
    {
        $teacher = $this->teacherRepository->find($id);
        if (!$teacher) {
            abort(404);
        }
        $user       = $this->userService->getUser();
        $isFavorite = false;
        if (!empty($user)) {
            $favorite = $this->favoriteTeacherRepository->findByUserIdAndTeacherId($user->id, $teacher->id);
            if (!empty($favorite)) {
                $isFavorite = true;
            }
        }
        $offset  = $request->offset();
        $limit   = $request->limit();
        $target  = 'teacher';
        $userId  = 0;
        $rating  = 0;
        $count   = $this->reviewRepository->countEnabledWithConditions($target, $userId, $teacher->id, $rating);
        $reviews = $this->reviewRepository->getEnabledWithConditions(
            $target,
            $userId,
            $teacher->id,
            $rating,
            'updated_at',
            'desc',
            $offset,
            $limit
        );

        return view(
            'pages.user.booking.teacher-profile',
            [
                'teacher'    => $teacher,
                'titlePage'  => trans('user.pages.title.teacher_profile'),
                'offset'     => $offset,
                'limit'      => $limit,
                'reviews'    => $reviews,
                'count'      => $count,
                'isFavorite' => $isFavorite,
                'params'     => [
                ],
                'baseUrl' => action('User\IndexController@teacherProfile', $teacher->id),
            ]
        );
    }

    private function genSortTeacher($value)
    {
        $order     = 'rating';
        $direction = 'desc';
        if ($value == 'rating-up') {
            $order     = 'rating';
            $direction = 'asc';
        }

        return ['order' => $order, 'direction' => $direction];
    }
}
