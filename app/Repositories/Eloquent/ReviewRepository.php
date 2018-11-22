<?php
namespace App\Repositories\Eloquent;

use App\Models\Review;
use App\Repositories\ReviewRepositoryInterface;

class ReviewRepository extends SingleKeyModelRepository implements ReviewRepositoryInterface
{
    public function getBlankModel()
    {
        return new Review();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function getEnabledWithConditions($target, $userId, $teacherId, $rating, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($target, $userId, $teacherId, $rating, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function getAllEnabledWithConditions($target, $userId, $teacherId, $rating, $order, $direction)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($target, $userId, $teacherId, $rating, $query);

        return $query->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($target, $userId, $teacherId, $rating)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($target, $userId, $teacherId, $rating, $query);

        return $query->count();
    }

    /**
     * @param int                                $userId
     * @param int                                $teacherId
     * @param int                                $rating
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($target, $userId, $teacherId, $rating, $query)
    {
        if (!empty($userId)) {
            $query = $query->where(function ($subquery) use ($userId) {
                $subquery->where('user_id', $userId);
            });
        }
        if (!empty($teacherId)) {
            $query = $query->where(function ($subquery) use ($teacherId) {
                $subquery->where('teacher_id', $teacherId);
            });
        }
        if (!empty($rating)) {
            $query = $query->where(function ($subquery) use ($rating) {
                $subquery->where('rating', $rating);
            });
        }
        if (!empty($target)) {
            $query = $query->where(function ($subquery) use ($target) {
                $subquery->where('target', $target);
            });
        }

        return $query;
    }

    public function findByIdTargetTeacherUser($userId, $teacherId, $target, $bookingId)
    {
        $query = $this->getBlankModel();
        if (!empty($userId)) {
            $query = $query->where(function ($subquery) use ($userId) {
                $subquery->where('user_id', $userId);
            });
        }
        if (!empty($teacherId)) {
            $query = $query->where(function ($subquery) use ($teacherId) {
                $subquery->where('teacher_id', $teacherId);
            });
        }
        if (!empty($bookingId)) {
            $query = $query->where(function ($subquery) use ($bookingId) {
                $subquery->where('booking_id', $bookingId);
            });
        }
        if (!empty($target)) {
            $query = $query->where(function ($subquery) use ($target) {
                $subquery->where('target', $target);
            });
        }

        return $query->first();
    }
}
