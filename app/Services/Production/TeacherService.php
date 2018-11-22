<?php
namespace App\Services\Production;

use App\Models\Booking;
use App\Repositories\ReviewRepositoryInterface;
use App\Repositories\TeacherPasswordResetRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use App\Services\TeacherServiceInterface;

class TeacherService extends AuthenticatableService implements TeacherServiceInterface
{
    /** @var string $resetEmailTitle */
    protected $resetEmailTitle = 'Reset Password';

    /** @var string $resetEmailTemplate */
    protected $resetEmailTemplate = 'emails.teacher.reset_password';

    /** @var TeacherRepositoryInterface $authenticatableRepository */
    protected $authenticatableRepository;

    /** @var TeacherPasswordResetRepositoryInterface $teacherPasswordResetRepository */
    protected $teacherPasswordResetRepository;

    /** @var ReviewRepositoryInterface $reviewRepository */
    protected $reviewRepository;

    public function __construct(
        TeacherRepositoryInterface $teacherRepository,
        TeacherPasswordResetRepositoryInterface $teacherPasswordResetRepository,
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->authenticatableRepository    = $teacherRepository;
        $this->passwordResettableRepository = $teacherPasswordResetRepository;
        $this->reviewRepository             = $reviewRepository;
    }

    public function getGuardName()
    {
        return 'teachers';
    }

    public function genRatingTeacher($teacherId)
    {
        $target    = 'teacher';
        $userId    = 0;
        $rating    = 0;
        $order     = 'id';
        $direction = 'asc';
        $reviews   = $this->reviewRepository->getAllEnabledWithConditions($target, $userId, $teacherId, $rating, $order, $direction);
        $rate      = 0;
        foreach ($reviews as $review) {
            $rate += $review->rating;
        }
        $reteAvg = 0;
        if (count($reviews) > 0) {
            $reteAvg = round($rate / count($reviews), 0, PHP_ROUND_HALF_UP);
        }

        return $reteAvg;
    }

    public function teacherAvail($time, $listTimeSlot)
    {
        $now                = \DateTimeHelper::now();
        $timeSlot           = ['timeSlotId' => 0];
        $timeSlot['status'] = config('constants.timeslot_status.close');
        foreach ($listTimeSlot as $ts) {
            $timeSl = \DateTimeHelper::convertToStorageDateTime($time);
            if ($now->diffInHours($ts->start_at, false) >= 2) {
                if ($ts->start_at == $timeSl) {
                    $timeSlot['timeSlotId'] = $ts->id;
                    $timeSlot['status']     = config('constants.timeslot_status.open');
                    if (count($ts->booking) > 0) {
                        foreach ($ts->booking as $bookingItem) {
                            if ($bookingItem->status != Booking::TYPE_STATUS_CANCELED) {
                                $timeSlot['status'] = config('constants.timeslot_status.reserved');
                            }
                        }
                    }
                }
            }
        }

        return $timeSlot;
    }

    public function updateTeacherRating($teacherId)
    {
        $teacher = $this->authenticatableRepository->find($teacherId);
        if (empty($teacher)) {
            return null;
        }
        $target    = 'teacher';
        $userId    = 0;
        $rating    = 0;
        $order     = 'id';
        $direction = 'asc';
        $reviews   = $this->reviewRepository->getAllEnabledWithConditions($target, $userId, $teacherId, $rating, $order, $direction);

        $total = 3;
        $count = 1;
        foreach ($reviews as $key => $review) {
            if ($review['target'] == 'teacher') {
                $total += $review['rating'];
                $count += 1;
            }
        }
        $ratingAvg = round($total / $count, 0, PHP_ROUND_HALF_UP);
        $this->authenticatableRepository->update($teacher, ['rating' => $ratingAvg]);
    }
}
