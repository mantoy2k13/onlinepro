<?php
namespace App\Repositories\Eloquent;

use App\Models\TeacherNotification;
use App\Repositories\TeacherNotificationRepositoryInterface;

class TeacherNotificationRepository extends NotificationRepository implements TeacherNotificationRepositoryInterface
{
    public function getBlankModel()
    {
        return new TeacherNotification();
    }

    public function getEnabledWithConditions($title, $categoryType, $type, $userId, $read, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($title, $categoryType, $type, $userId, $read, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($title, $categoryType, $type, $userId, $read)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($title, $categoryType, $type, $userId, $read, $query);

        return $query->count();
    }

    /**
     * @param string                             $title
     * @param string                             $categoryType
     * @param string                             $type
     * @param int                                $userId
     * @param int                                $read
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($title, $categoryType, $type, $userId, $read, $query)
    {
        if (!empty($categoryType)) {
            $query = $query->where(function ($subquery) use ($categoryType) {
                $subquery->where('category_type', 'like', '%'.$categoryType.'%');
            });
        }
        if (!empty($type)) {
            $query = $query->where(function ($subquery) use ($type) {
                $subquery->where('type', $type);
            });
        }
        if (!empty($userId)) {
            $query = $query->where(function ($subquery) use ($userId) {
                $subquery->where('user_id', $userId);
                $subquery->orWhere('user_id', '');
            });
        }
        if ($read > -1) {
            $query = $query->where(function ($subquery) use ($read) {
                $subquery->where('read', $read);
            });
        }

        if (!empty($title)) {
            $query = $query->where(function ($subquery) use ($title) {
                $subquery->where('title', 'like', '%'.$title.'%');
            });
        }

        return $query;
    }
}
