<?php
namespace App\Repositories\Eloquent;

use App\Models\Teacher;
use App\Models\TimeSlot;
use App\Repositories\TeacherRepositoryInterface;

class TeacherRepository extends AuthenticatableRepository implements TeacherRepositoryInterface
{
    protected $sortFreeTeacher          = 'timeSlot';
    protected $sortFreeTeacherDerection = 'DESC';

    public function getBlankModel()
    {
        return new Teacher();
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

    public function getEnabledWithConditions($name, $email, $livingCountryCode, $livingCityId, $status, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($name, $email, $livingCountryCode, $livingCityId, $status, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function getAllEnabledWithConditions($name, $email, $livingCountryCode, $livingCityId, $status, $order, $direction)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($name, $email, $livingCountryCode, $livingCityId, $status, $query);

        return $query->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($name, $email, $livingCountryCode, $livingCityId, $status)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($name, $email, $livingCountryCode, $livingCityId, $status, $query);

        return $query->count();
    }

    /**
     * @param string                             $name
     * @param string                             $email
     * @param string                             $livingCountryCode
     * @param string                             $status
     * @param int                                $livingCityId
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($name, $email, $livingCountryCode, $livingCityId, $status, $query)
    {
        if (!empty($name)) {
            $query = $query->where(function ($subquery) use ($name) {
                $subquery->where('name', 'like', '%'.$name.'%');
            });
        }
        if (!empty($email)) {
            $query = $query->where(function ($subquery) use ($email) {
                $subquery->where('email', 'like', '%'.$email.'%');
            });
        }
        if (!empty($livingCountryCode)) {
            $query = $query->where(function ($subquery) use ($livingCountryCode) {
                $subquery->where('living_country_code', 'like', '%'.$livingCountryCode.'%');
            });
        }
        if (!empty($livingCityId)) {
            $query = $query->where(function ($subquery) use ($livingCityId) {
                $subquery->where('living_city_id', $livingCityId);
            });
        }
        if (!empty($status) and $status == Teacher::STATUS_TEACHER_ALL) {
            $query = $query->withTrashed();
        } elseif (!empty($status) and $status == Teacher::STATUS_TEACHER_DELETED) {
            $query = $query->onlyTrashed();
        }

        return $query;
    }

    public function getTeacherFreeWithConditions($livingCountryCode, $personality, $date, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $query->leftJoin(TimeSlot::getTableName(), TimeSlot::getTableName().'.teacher_id', '=', Teacher::getTableName().'.id');
        $query = $this->queryTimeSlot($query, $date);
        $query = $this->setSearchQueryFree($livingCountryCode, $personality, $date, $query);
        $query = $query->offset($offset)->limit($limit);
        if ($order == 'rating') {
            $query = $query->orderBy($order, $direction)
                ->orderBy($this->sortFreeTeacher, $this->sortFreeTeacherDerection)
                ->groupBy(Teacher::getTableName().'.id');
        } else {
            $query = $query->orderBy($this->sortFreeTeacher, $this->sortFreeTeacherDerection)
                ->orderBy($order, $direction)
                ->groupBy(Teacher::getTableName().'.id');
        }

        return $query->get();
    }

    public function countTeacherFreeWithConditions($livingCountryCode, $personality, $date, $order, $direction)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQueryFree($livingCountryCode, $personality, $date, $query);

        return $query->count();
    }

    private function setSearchQueryFree($livingCountryCode, $personality, $date, $query)
    {
        if (!empty($livingCountryCode)) {
            $query = $query->where(function ($subquery) use ($livingCountryCode) {
                $subquery->where('living_country_code', $livingCountryCode);
            });
        }

        if (!empty($personality)) {
            $query = $query->whereHas('personalities', function ($subquery) use ($personality) {
                $subquery->where('personality_id', $personality);
            });
        }
        if (!empty($date)) {
            $query = $query->whereHas('timeSlots', function ($subquery) use ($date) {
                $subquery->whereDate('start_at', '=', $date);
            });
        }

        return $query;
    }

    public function allFavoriteTeacherByUserId($userId, $order, $direction)
    {
        $query = $this->getBlankModel();
        $query = $this->favoriteQuery($userId, $query);

        return $query->orderBy($order, $direction)->get();
    }

    public function getFavoriteTeacherByUserId($userId, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->favoriteQuery($userId, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function countFavoriteTeacherByUserId($userId)
    {
        $query = $this->getBlankModel();
        $query = $this->favoriteQuery($userId, $query);

        return $query->count();
    }

    private function favoriteQuery($userId, $query)
    {
        $query = $query->whereHas('favorites', function ($subquery) use ($userId) {
            $subquery->where('user_id', $userId);
        });

        return $query;
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    private function queryTimeSlot($query, $date)
    {
        $subquery = new TimeSlot();
        $sub      = $subquery->selectRaw('count('.TimeSlot::getTableName().'.id) as '.$this->sortFreeTeacher)
            ->from(TimeSlot::getTableName())
            ->whereRaw(TimeSlot::getTableName().'.teacher_id = '.Teacher::getTableName().'.id')
            ->whereDate('start_at', $date);
        $query = $query->selectRaw(Teacher::getTableName().".*,({$sub->toSql()}) as ".$this->sortFreeTeacher)
        ->mergeBindings($sub->getQuery());

        return $query;
    }
}
