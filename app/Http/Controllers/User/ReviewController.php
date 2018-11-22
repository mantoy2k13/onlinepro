<?php
/**
 * Created by PhpStorm.
 * User: ironh
 * Date: 1/4/2017
 * Time: 1:40 PM.
 */
namespace app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReviewRequest;
use App\Models\Booking;
use App\Models\Review;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\ReviewRepositoryInterface;
use App\Services\TeacherServiceInterface;
use App\Services\UserServiceInterface;

class ReviewController extends Controller
{
    /** @var \App\Repositories\BookingRepositoryInterface */
    protected $bookingRepository;

    /** @var \App\Services\UserServiceInterface */
    protected $userService;

    /** @var \App\Repositories\ReviewRepositoryInterface */
    protected $reviewRepository;

    /** @var \App\Services\TeacherServiceInterface */
    protected $teacherService;

    public function __construct(
        BookingRepositoryInterface $bookingRepository,
        UserServiceInterface $userService,
        ReviewRepositoryInterface $reviewRepository,
        TeacherServiceInterface $teacherService
    ) {
        $this->bookingRepository        = $bookingRepository;
        $this->userService              = $userService;
        $this->reviewRepository         = $reviewRepository;
        $this->teacherService           = $teacherService;
    }

    public function writeReviewForm($bookingId)
    {
        $user    = $this->userService->getUser();
        $booking = $this->bookingRepository->findByIdAndUserId($bookingId, $user->id);
        if (empty($booking) || $booking->user_id != $user->id) {
            abort(404);
        }
        if (!empty($booking->reviewByUser) || $booking->status != Booking::TYPE_STATUS_PENDING) {
            return redirect(action('User\BookingController@getBookingHistories'));
        }

        return view(
            'pages.user.review.edit',
            [
                'booking'   => $booking,
                'titlePage' => trans('user.pages.title.review'),
            ]
        );
    }

    public function confirm($bookingId, ReviewRequest $request)
    {
        $user    = $this->userService->getUser();
        $booking = $this->bookingRepository->find($bookingId);
        if (empty($booking) || $booking->user_id != $user->id) {
            abort(404);
        }

        $content = $request->get('content', '');
        $rating  = $request->get('rating', Review::RATING_DEFAULT);

        return view(
            'pages.user.review.confirm',
            [
                'booking'   => $booking,
                'content'   => $content,
                'rating'    => $rating,
                'titlePage' => trans('user.pages.title.review_confirm'),
            ]
        );
    }

    public function complete($bookingId, ReviewRequest $request)
    {
        $user    = $this->userService->getUser();
        $booking = $this->bookingRepository->find($bookingId);
        if (empty($booking) || $booking->user_id != $user->id) {
            abort(404);
        }
        $content = $request->get('content', '');
        $rating  = $request->get('rating', Review::RATING_DEFAULT);
        $input   = ['target' => Review::TARGET_TEACHER, 'teacher_id' => $booking->teacher_id,
            'user_id'        => $user->id, 'booking_id' => $booking->id,
            'rating'         => $rating, 'content' => $content,
        ];
        $reviewOld = $this->reviewRepository->findByIdTargetTeacherUser($booking->user_id, $booking->teacher_id, Review::TARGET_TEACHER, $booking->id);
        if (!empty($reviewOld)) {
            $this->reviewRepository->update($reviewOld, $input);
        } else {
            $model = $this->reviewRepository->create($input);
            if (empty($model)) {
                return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
            }
        }
        $this->teacherService->updateTeacherRating($booking->teacher_id);

        return view(
            'pages.user.review.complete',
            [
                'booking'   => $booking,
                'titlePage' => trans('user.pages.title.review_complete'),
            ]
        );
    }

    public function completeReview($bookingId)
    {
        $user    = $this->userService->getUser();
        $booking = $this->bookingRepository->find($bookingId);
        if (empty($booking) || $booking->user_id != $user->id) {
            abort(404);
        }

        return view(
            'pages.user.review.complete',
            [
                'booking'   => $booking,
                'titlePage' => trans('user.pages.title.review_complete'),
            ]
        );
    }

    public function reviewLogByTeacher($id)
    {
        $user   = $this->userService->getUser();
        $review = $this->reviewRepository->findByIdAndUserId($id, $user->id);

        if (empty($review)) {
            abort(404);
        }

        return view(
            'pages.user.review.log',
            [
                'review' => $review,
            ]
        );
    }
}
