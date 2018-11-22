<?php
namespace App\Repositories\Eloquent;

use App\Models\PaymentLog;
use App\Repositories\PaymentLogRepositoryInterface;

class PaymentLogRepository extends SingleKeyModelRepository implements PaymentLogRepositoryInterface
{
    public function getBlankModel()
    {
        return new PaymentLog();
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

    public function getEnabledWithConditions($status, $paidAmount, $teacherId, $paidForMonth, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($status, $paidAmount, $teacherId, $paidForMonth, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function getAllEnabledWithConditions($paidAmount, $teacherId, $status, $paidForMonth, $order, $direction)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($paidAmount, $teacherId, $status, $paidForMonth, $query);

        return $query->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($status, $paidAmount, $teacherId, $paidForMonth)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($status, $paidAmount, $teacherId, $paidForMonth, $query);

        return $query->count();
    }

    /**
     * @param string                             $status
     * @param int                                $paidAmount
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($status, $paidAmount, $teacherId, $paidForMonth, $query)
    {
        if (!empty($status)) {
            $query = $query->where(function ($subquery) use ($status) {
                $subquery->where('status', $status);
            });
        }
        if (!empty($paidAmount)) {
            $query = $query->where(function ($subquery) use ($paidAmount) {
                $subquery->where('paid_amount', $paidAmount);
            });
        }
        if (!empty($teacherId)) {
            $query = $query->where(function ($subquery) use ($teacherId) {
                $subquery->where('teacher_id', $teacherId);
            });
        }

        if (!empty($paidForMonth)) {
            $query = $query->where(function ($subquery) use ($paidForMonth) {
                $subquery->where('paid_for_month', $paidForMonth);
            });
        }

        return $query;
    }
}
