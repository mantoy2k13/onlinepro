<?php
namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Models\TimeSlot;
use App\Repositories\TimeSlotRepositoryInterface;

class TimeSlotRepository extends SingleKeyModelRepository implements TimeSlotRepositoryInterface
{
    public function getBlankModel()
    {
        return new TimeSlot();
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

    public function getByStartDate($date, $teacherId)
    {
        $result = $this->getBlankModel()
            ->whereDate('start_at', '=', $date)
            ->where('teacher_id', $teacherId)
            ->get();

        return $result;
    }

    public function findByStartDate($date, $teacherId)
    {
        $result = $this->getBlankModel()
            ->where('start_at', '=', $date)
            ->where('teacher_id', $teacherId)
            ->first();

        return $result;
    }

    public function getEnabledWithConditions($teacherId, $dateFrom, $notStatus, $order, $direction, $offset, $limit)
    {
        $query  = $this->getBlankModel();
        $userId = 0;
        $query  = $this->setSearchQuery($userId, $teacherId, $dateFrom, $notStatus, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($teacherId, $notStatus, $dateFrom)
    {
        $query  = $this->getBlankModel();
        $userId = 0;
        $query  = $this->setSearchQuery($userId, $teacherId, $notStatus, $dateFrom, $query);

        return $query->count();
    }

    public function allAvailByConditions($teacherId, $date)
    {
        $query = $this->getBlankModel();
        if (!empty($teacherId)) {
            $query = $query->where(function ($subquery) use ($teacherId) {
                $subquery->where('teacher_id', $teacherId);
            });
        }

        if (!empty($date)) {
            $query = $query->where(function ($subquery) use ($date) {
                $subquery->whereDate('start_at', '=', $date);
            });
        }

        return $query->get();
    }

    private function setSearchQuery($userId, $teacherId, $dateFrom, $notStatus, $query)
    {
        if (!empty($teacherId)) {
            $query = $query->where(function ($subquery) use ($teacherId) {
                $subquery->where('teacher_id', $teacherId);
            });
        }

        if (!empty($userId)) {
            $query = $query->whereHas('booking', function ($subquery) use ($userId) {
                $subquery->where('user_id', $userId);
            });
        }

        if (!empty($dateFrom)) {
            $query = $query->where(function ($subquery) use ($dateFrom) {
                $subquery->where('start_at', '>=', $dateFrom);
            });
        }

        if (!empty($notStatus)) {
            $query = $query->whereHas('booking', function ($subquery) use ($notStatus) {
                $subquery->where('status', '<>', $notStatus);
            });
        }

        return $query;
    }

    public function getByUserdWithConditions($userId, $order, $direction, $offset, $limit)
    {
        $teacherId = 0;
        $dateFrom  = '';
        $notStatus = '';
        $query     = $this->getBlankModel();
        $query     = $this->setSearchQuery($userId, $teacherId, $dateFrom, $notStatus, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function countByUserWithConditions($userId)
    {
        $teacherId = 0;
        $dateFrom  = '';
        $notStatus = '';
        $query     = $this->getBlankModel();
        $query     = $this->setSearchQuery($userId, $teacherId, $dateFrom, $notStatus, $query);

        return $query->count();
    }
}
