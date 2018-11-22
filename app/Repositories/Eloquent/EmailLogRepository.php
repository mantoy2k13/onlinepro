<?php
namespace App\Repositories\Eloquent;

use App\Models\EmailLog;
use App\Models\User;
use App\Repositories\EmailLogRepositoryInterface;

class EmailLogRepository extends SingleKeyModelRepository implements EmailLogRepositoryInterface
{
    public function getBlankModel()
    {
        return new EmailLog();
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

    public function getEnabledWithConditions(
        $oldEmail,
        $newEmail,
        $userId,
        $status,
                                             $validationCode,
        $order,
        $direction,
        $offset,
        $limit
    ) {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery(
            $oldEmail,
            $newEmail,
            $userId,
            $status,
            $validationCode,
            $query
        );

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    /**
     * @param string $nameJa
     * @param string $nameEn
     * @param string $countryCode
     *
     * @return int
     */
    public function countEnabledWithConditions(
        $oldEmail,
        $newEmail,
        $userId,
        $status,
                                               $validationCode
    ) {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery(
            $oldEmail,
            $newEmail,
            $userId,
            $status,
            $validationCode,
            $query
        );

        return $query->count();
    }

    private function setSearchQuery(
        $oldEmail,
        $newEmail,
        $userId,
        $status,
                                    $validationCode,
        $query
    ) {
        if (!empty($oldEmail)) {
            $query = $query->where(function ($subquery) use ($oldEmail) {
                $subquery->where('old_email', 'like', '%'.$oldEmail.'%');
            });
        }
        if (!empty($newEmail)) {
            $query = $query->where(function ($subquery) use ($newEmail) {
                $subquery->where('new_email', 'like', '%'.$newEmail.'%');
            });
        }
        if (!empty($validationCode)) {
            $query = $query->where(function ($subquery) use ($validationCode) {
                $subquery->where('validation_code', 'like', '%'.$validationCode.'%');
            });
        }
        if (!empty($userId)) {
            $query = $query->where(function ($subquery) use ($userId) {
                $subquery->where('user_id', $userId);
            });
        }
        if (!empty($status) && $status >= 0) {
            $query = $query->where(function ($subquery) use ($status) {
                $subquery->where('status', $status);
            });
        }

        return $query;
    }

    public function getEmailLogByValidationCode($validationCode)
    {
        $query  = $this->getBlankModel();
        $result = $query->where('validation_code', $validationCode)
            ->where('status', User::STATUS_NOT_VALIDATED)
            ->first();

        return $result;
    }
}
