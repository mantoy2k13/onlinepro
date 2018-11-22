<?php
namespace App\Repositories\Eloquent;

use App\Models\Province;
use App\Repositories\ProvinceRepositoryInterface;

class ProvinceRepository extends SingleKeyModelRepository implements ProvinceRepositoryInterface
{
    public function getBlankModel()
    {
        return new Province();
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

    public function getEnabledWithConditions($nameJa, $nameEn, $countryCode, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($nameJa, $nameEn, $countryCode, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($nameJa, $nameEn, $countryCode)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($nameJa, $nameEn, $countryCode, $query);

        return $query->count();
    }

    private function setSearchQuery($nameJa, $nameEn, $countryCode, $query)
    {
        if (!empty($nameJa)) {
            $query = $query->where(function ($subquery) use ($nameJa) {
                $subquery->where('name_ja', 'like', '%'.$nameJa.'%');
            });
        }
        if (!empty($nameEn)) {
            $query = $query->where(function ($subquery) use ($nameEn) {
                $subquery->where('name_en', 'like', '%'.$nameEn.'%');
            });
        }
        if (!empty($countryCode)) {
            $query = $query->where(function ($subquery) use ($countryCode) {
                $subquery->where('country_code', 'like', '%'.$countryCode.'%');
            });
        }

        return $query;
    }
}
