<?php
namespace App\Repositories\Eloquent;

use App\Models\UserNotification;
use App\Repositories\UserNotificationRepositoryInterface;

class UserNotificationRepository extends NotificationRepository implements UserNotificationRepositoryInterface
{
    public function getBlankModel()
    {
        return new UserNotification();
    }

    public function getEnabledWithConditions($categoryType, $type, $user, $read, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($categoryType, $type, $user, $read, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($categoryType, $type, $user, $read)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($categoryType, $type, $user, $read, $query);

        return $query->count();
    }

    /**
     * @param string                             $categoryType
     * @param string                             $type
     * @param int                                $userId
     * @param int                                $read
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($categoryType, $type, $user, $read, $query)
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
        if (!empty($user)) {
            $query = $query->where(function ($subquery) use ($user) {
                $subquery->where('user_id', $user->id);
                $subquery->orWhere('user_id', '');
            });
            $query = $query->where(function ($subquery) use ($user) {
                $subquery->where('sent_at', '>=', $user->created_at);
            });
        }
        if ($read > -1) {
            $query = $query->where(function ($subquery) use ($read) {
                $subquery->where('read', $read);
            });
        }

        return $query;
    }

    public function nextNotice($id, $userId, $userCreatedAt)
    {
        $item = $this->getBlankModel()
            ->where('id', '>', $id)
            ->where('sent_at', '>=', $userCreatedAt)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId);
                $query->orWhere('user_id', 0);
            })->orderBy('id', 'asc')->first();

        return $item;
    }

    public function preNotice($id, $userId, $userCreatedAt)
    {
        $item = $this->getBlankModel()
            ->where('id', '<', $id)
            ->where('sent_at', '>=', $userCreatedAt)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId);
                $query->orWhere('user_id', 0);
            })->orderBy('id', 'desc')->first();

        return $item;
    }

    public function findByIdAndUserId($id, $userId)
    {
        $item = $this->getBlankModel()
            ->where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId);
                $query->orWhere('user_id', 0);
            })->first();

        return $item;
    }
}
