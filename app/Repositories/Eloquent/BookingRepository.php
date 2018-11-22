<?php
namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Models\PointLog;
use App\Models\PurchaseLog;
use App\Models\TimeSlot;
use App\Repositories\BookingRepositoryInterface;

class BookingRepository extends SingleKeyModelRepository implements BookingRepositoryInterface
{
    public function getBlankModel()
    {
        return new Booking();
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

    public function getEnabledWithConditions($userId, $teacherId, $statusIncluded, $statusExcluded, $dateFrom, $dateTo, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $query->select(Booking::getTableName().'.*');
        $query = $this->setSearchQuery($userId, $teacherId, $statusIncluded, $statusExcluded, $dateFrom, $dateTo, $query);
        $query = $query->offset($offset)->limit($limit);
        if ($order == 'start_at') {
            $results = $query->orderByRaw(TimeSlot::getTableName().'.start_at'.' '.$direction)->get();
        } else {
            $results = $query->orderBy(Booking::getTableName().'.'.$order, $direction)->get();
        }

        return $results;
    }

    public function getAllEnabledWithConditions($userId, $teacherId, $statusIncluded, $statusExcluded, $dateFrom, $dateTo, $order, $direction)
    {
        $query = $this->getBlankModel();
        $query = $query->select(Booking::getTableName().'.*');
        $query = $this->setSearchQuery($userId, $teacherId, $statusIncluded, $statusExcluded, $dateFrom, $dateTo, $query);

        return $query->orderBy($order, $direction)->get();
    }

    public function getAllBookingWithConditions(
        $userId,
        $teacherId,
        $statusIncluded,
        $statusExcluded,
        $startDateFrom,
        $startDateTo,
        $createdDateFrom,
        $createdDateTo,
        $order,
        $direction
    ) {
        $query = $this->getBlankModel();
        $query = $query->select(Booking::getTableName().'.*');
        $query = $this->setSearchQuery($userId, $teacherId, $statusIncluded, $statusExcluded, $startDateFrom, $startDateTo, $query);
        $query = $this->setSearchQueryBooking($createdDateFrom, $createdDateTo, $query);
        if ($order == 'start_at') {
            $results = $query->orderByRaw(TimeSlot::getTableName().'.start_at'.' '.$direction)->get();
        } else {
            $results = $query->orderBy(Booking::getTableName().'.'.$order, $direction)->get();
        }

        return $results;
    }

    public function countEnabledWithConditions($userId, $teacherId, $statusIncluded, $statusExcluded, $dateFrom, $dateTo)
    {
        $query = $this->getBlankModel();
        $query = $query->select(Booking::getTableName().'.*');
        $query = $this->setSearchQuery($userId, $teacherId, $statusIncluded, $statusExcluded, $dateFrom, $dateTo, $query);

        return $query->count();
    }

    /**
     * @param int                                $userId
     * @param int                                $teacherId
     * @param string                             $status
     * @param string                             $dateFrom
     * @param string                             $dateTo
     * @param int                                $userId
     * @param int                                $teacherId
     * @param string                             $status
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($userId, $teacherId, $statusIncluded, $statusExcluded, $dateFrom, $dateTo, $query)
    {
        if (!empty($userId)) {
            $query = $query->where(function ($subquery) use ($userId) {
                $subquery->where(Booking::getTableName().'.user_id', $userId);
            });
        }
        if (!empty($teacherId)) {
            $query = $query->where(function ($subquery) use ($teacherId) {
                $subquery->where(Booking::getTableName().'.teacher_id', $teacherId);
            });
        }
        if (!empty($statusIncluded)) {
            $query = $query->where(function ($subquery) use ($statusIncluded) {
                $subquery->where(Booking::getTableName().'.status', $statusIncluded);
            });
        }
        if (!empty($dateFrom)) {
            $query = $query->where(function ($subquery) use ($dateFrom) {
                $subquery->where(TimeSlot::getTableName().'.start_at', '>', $dateFrom);
            });
        }
        if (!empty($dateTo)) {
            $query = $query->where(function ($subquery) use ($dateTo) {
                $subquery->where(TimeSlot::getTableName().'.start_at', '<=', $dateTo);
            });
        }

        if (count($statusExcluded) > 0) {
            $query = $query->where(function ($subquery) use ($statusExcluded) {
                foreach ($statusExcluded as $status) {
                    $subquery->orwhere(Booking::getTableName().'.status', '<>', $status);
                }
            });
        }
        $query = $query->join(TimeSlot::getTableName(), TimeSlot::getTableName().'.id', '=', Booking::getTableName().'.time_slot_id');

        return $query;
    }

    private function setSearchQueryBooking($createdDateFrom, $createdDateTo, $query)
    {
        if (!empty($createdDateFrom)) {
            $query = $query->where(function ($subquery) use ($createdDateFrom) {
                $subquery->where(Booking::getTableName().'.created_at', '>=', $createdDateFrom);
            });
        }
        if (!empty($createdDateTo)) {
            $query = $query->where(function ($subquery) use ($createdDateTo) {
                $subquery->where(Booking::getTableName().'.created_at', '<=', $createdDateTo);
            });
        }

        return $query;
    }

    public function allBookingByPointPackageAndUserIdToday($userId, $typePurchase, $package)
    {
        $query = $this->getBlankModel();

        $query = $query->whereHas('pointLog', function ($subquery) use ($typePurchase, $package, $query) {
            if ($typePurchase == PurchaseLog::PURCHASE_TYPE_PAYPAL and !empty($package) and $package > 0) {
                $subquery->whereHas('purchaseLog', function ($secondsubquery) use ($package) {
                    $secondsubquery->where('purchase_method_type', PurchaseLog::PURCHASE_TYPE_PAYPAL);
                    $secondsubquery->where('point_amount', $package);
                });
            } elseif ($typePurchase == PurchaseLog::PURCHASE_TYPE_BY_ADMIN) {
                $subquery->whereHas('purchaseLog', function ($secondsubquery) use ($package) {
                    $secondsubquery->where('purchase_method_type', PurchaseLog::PURCHASE_TYPE_BY_ADMIN);
                });
            }
        });
        $query = $query->whereDate('created_at', \DateTimeHelper::now()->format('Y-m-d'));
        $query = $query->whereUserId($userId);
        $query = $query->where('status', '<>', Booking::TYPE_STATUS_CANCELED);

        return $query->get();
    }

    public function findBookingBonusSignup($userId)
    {
        $query = $this->getBlankModel();
        $query = $query->whereHas('pointLog', function ($subquery) use ($query) {
            $subquery->where('type', PointLog::TYPE_BOOKING);
            $subquery->where('purchase_log_id', 0);
        });
        $query = $query->whereUserId($userId);
        $query = $query->where('status', '<>', Booking::TYPE_STATUS_CANCELED);

        return $query->first();
    }
}
