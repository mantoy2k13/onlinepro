<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserRepository extends AuthenticatableRepository implements UserRepositoryInterface
{
    public function getBlankModel()
    {
        return new User();
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

    public function getEnabledWithConditions($name, $email, $skypeId, $status, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($name, $email, $skypeId, $status, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function getAllEnabledWithConditions($name, $email, $skypeId, $status, $order, $direction)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($name, $email, $skypeId, $status, $query);

        return $query->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($name, $email, $skypeId, $status)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($name, $email, $skypeId, $status, $query);

        return $query->count();
    }

    /**
     * @param string                             $name
     * @param string                             $email
     * @param string                             $skypeId
     * @param string                             $status
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($name, $email, $skypeId, $status, $query)
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
        if (!empty($skypeId)) {
            $query = $query->where(function ($subquery) use ($skypeId) {
                $subquery->where('skype_id', 'like', '%'.$skypeId.'%');
            });
        }
        if (!empty($status) and $status == User::STATUS_USER_NOT_CONFIRMED) {
            $query = $query->where(function ($subquery) use ($email) {
                $subquery->where('status', User::STATUS_NOT_VALIDATED);
            });
        } elseif (!empty($status) and $status == User::STATUS_USER_CONFIRMED) {
            $query = $query->where(function ($subquery) use ($email) {
                $subquery->where('status', User::STATUS_VALIDATED);
            });
        } elseif (!empty($status) and $status == User::STATUS_USER_ALL) {
            $query = $query->withTrashed();
        } elseif (!empty($status) and $status == User::STATUS_USER_DELETED) {
            $query = $query->onlyTrashed();
        }

        return $query;
    }

    public function getUserByValidationCode($validationCode)
    {
        $query  = $this->getBlankModel();
        $result = $query->where('validation_code', $validationCode)
            ->where('status', 0)
            ->first();

        return $result;
    }
}
