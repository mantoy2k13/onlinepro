<?php
namespace App\Repositories\Eloquent;

use App\Models\PointLog;
use App\Repositories\PointLogRepositoryInterface;

class PointLogRepository extends SingleKeyModelRepository implements PointLogRepositoryInterface
{
    public function getBlankModel()
    {
        return new PointLog();
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

    public function getEnabledWithConditions($type, $pointAmount, $userId, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($type, $pointAmount, $userId, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function getAllEnabledWithConditions($type, $pointAmount, $userId, $order, $direction)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($type, $pointAmount, $userId, $query);

        return $query->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($type, $pointAmount, $userId)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($type, $pointAmount, $userId, $query);

        return $query->count();
    }

    /**
     * @param string                             $type
     * @param int                                $pointAmount
     * @param int                                $userId
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($type, $pointAmount, $userId, $query)
    {
        if (!empty($type)) {
            $query = $query->where(function ($subquery) use ($type) {
                $subquery->where('type', $type);
            });
        }
        if (!empty($pointAmount)) {
            $query = $query->where(function ($subquery) use ($pointAmount) {
                $subquery->where('point_amount', $pointAmount);
            });
        }
        if (!empty($userId)) {
            $query = $query->where(function ($subquery) use ($userId) {
                $subquery->where('user_id', $userId);
            });
        }

        return $query;
    }

    public function summatePointsByUser($userId)
    {
        $point = $this->getBlankModel()
            ->where('user_id', $userId)
            ->sum('point_amount');

        return $point;
    }

    public function allPointBookingTodayByPurchaseLog($purchaseLogId)
    {
        $query = $this->getBlankModel();

        return $query->whereDate('created_at', \DateTimeHelper::now()->format('Y-m-d'))
            ->wherePurchaseLogId($purchaseLogId)->get();
    }
}
