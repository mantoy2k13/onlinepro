<?php
namespace App\Repositories\Eloquent;

use App\Models\PurchaseLog;
use App\Repositories\PurchaseLogRepositoryInterface;

class PurchaseLogRepository extends SingleKeyModelRepository implements PurchaseLogRepositoryInterface
{
    public function getBlankModel()
    {
        return new PurchaseLog();
    }

    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
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

    public function allExpiredPointExistsByUserId($userId)
    {
        $query = $this->getBlankModel();

        return $query->where(
            'point_expired_at',
            '<',
            \DateTimeHelper::now()
        )->whereUserId($userId)->where('remaining_point_amount', '>', 0)->orderBy(
                'id',
            'asc'
            )->get();
    }

    public function allExpiredPointExists()
    {
        $query = $this->getBlankModel();

        return $query->where('point_expired_at', '<', \DateTimeHelper::now())->where(
            'remaining_point_amount',
            '>',
            0
        )->orderBy('id', 'asc')->get();
    }

    public function findOldestPointByUserId($userId)
    {
        $query = $this->getBlankModel();

        return $query->where(
            'point_expired_at',
            '>=',
            \DateTimeHelper::now()
        )->whereUserId($userId)->where(
                'remaining_point_amount',
                '>',
            0
            )->orderBy('created_at', 'asc')->first();
    }

    public function findLastPurchaseByUserId($userId)
    {
        $query = $this->getBlankModel();

        return $query->where(
            'point_expired_at',
            '>=',
            \DateTimeHelper::now()
        )->whereUserId($userId)->orderBy('created_at', 'asc')->first();
    }

    public function findLastPurchaseExpiredFromNow($userId, $currentDate)
    {
        $query = $this->getBlankModel();

        return $query->where(
            'point_expired_at',
            '>=',
            \DateTimeHelper::now()
        )->whereUserId($userId)->orderBy('created_at', 'asc')->first();
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
                $subquery->where('purchase_method_type', $type);
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

    public function findLastPackagePurchaseByUserId($userId)
    {
        $query = $this->getBlankModel();

        return $query->whereUserId($userId)
            ->where('purchase_method_type', PurchaseLog::PURCHASE_TYPE_PAYPAL)
            ->orderBy('created_at', 'desc')->first();
    }

    public function findPurchaseByUserIdTypePackageRamainPoint($userId, $purchaseType, $package, $requireRemainPoint)
    {
        $query = $this->getBlankModel();

        if ($requireRemainPoint) {
            $query = $query->where(function ($subquery) use ($requireRemainPoint) {
                $subquery->where('remaining_point_amount', '>', 0);
            });
        }
        if (!empty($package) and $package > 0) {
            $query = $query->where(function ($subquery) use ($purchaseType, $package) {
                $subquery->where('purchase_method_type', $purchaseType);
                $subquery->where('point_amount', $package);
            });
        } elseif ($package == 0) {
            $query = $query->where(function ($subquery) use ($purchaseType) {
                $subquery->where('purchase_method_type', $purchaseType);
            });
        }

        return $query->where(
            'point_expired_at',
            '>=',
            \DateTimeHelper::now()
        )->whereUserId($userId)
            ->orderBy('created_at', 'asc')->first();
    }

    public function findFirstPurchaseByUserIdAndCreatedTime($userId, $createdTime)
    {
        $query = $this->getBlankModel();
        if (!empty($createdTime)) {
            $query = $query->where('created_at', '>', $createdTime);
        }

        return $query->where('point_expired_at', '>=', \DateTimeHelper::now())
            ->whereUserId($userId)
            ->where('remaining_point_amount', '>', 0)
            ->orderBy('created_at', 'asc')->first();
    }
}
