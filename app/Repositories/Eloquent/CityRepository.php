<?php
namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Repositories\CityRepositoryInterface;

class CityRepository extends SingleKeyModelRepository implements CityRepositoryInterface
{
    public function getBlankModel()
    {
        return new City();
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

    /**
     * @param string $nameJa
     * @param string $nameEn
     * @param string $countryCode
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($nameJa, $nameEn, $countryCode, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($nameJa, $nameEn, $countryCode, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    /**
     * @param string $nameJa
     * @param string $nameEn
     * @param string $countryCode
     *
     * @return int
     */
    public function countEnabledWithConditions($nameJa, $nameEn, $countryCode)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($nameJa, $nameEn, $countryCode, $query);

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
