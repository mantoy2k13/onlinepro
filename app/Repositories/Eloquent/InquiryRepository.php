<?php
namespace App\Repositories\Eloquent;

use App\Models\Inquiry;
use App\Repositories\InquiryRepositoryInterface;

class InquiryRepository extends SingleKeyModelRepository implements InquiryRepositoryInterface
{
    public function getBlankModel()
    {
        return new Inquiry();
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

    public function getEnabledWithConditions($type, $name, $email, $livingCountryCode, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($type, $name, $email, $livingCountryCode, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($type, $name, $email, $livingCountryCode)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($type, $name, $email, $livingCountryCode, $query);

        return $query->count();
    }

    /**
     * @param string                             $nameJa
     * @param string                             $nameEn
     * @param string                             $countryCode
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($type, $name, $email, $livingCountryCode, $query)
    {
        if (!empty($type)) {
            $query = $query->where(function ($subquery) use ($type) {
                $subquery->where('type', $type);
            });
        }
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
                $subquery->where('living_country_code', $livingCountryCode);
            });
        }

        return $query;
    }
}
