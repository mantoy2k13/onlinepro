<?php
namespace App\Repositories\Eloquent;

use App\Models\Personality;
use App\Repositories\PersonalityRepositoryInterface;

class PersonalityRepository extends SingleKeyModelRepository implements PersonalityRepositoryInterface
{
    public function getBlankModel()
    {
        return new Personality();
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

    public function getEnabledWithConditions($nameJa, $nameEn, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($nameJa, $nameEn, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($nameJa, $nameEn)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($nameJa, $nameEn, $query);

        return $query->count();
    }

    /**
     * @param string                             $nameJa
     * @param string                             $nameEn
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($nameJa, $nameEn, $query)
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

        return $query;
    }
}
