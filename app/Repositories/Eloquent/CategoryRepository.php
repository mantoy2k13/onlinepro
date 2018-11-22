<?php
namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;

class CategoryRepository extends SingleKeyModelRepository implements CategoryRepositoryInterface
{
    public function getBlankModel()
    {
        return new Category();
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
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return mixed
     */
    public function getEnabledWithConditions($nameJa, $nameEn, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($nameJa, $nameEn, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    /**
     * @param string $nameJa
     * @param string $nameEn
     *
     * @return mixed
     */
    public function countEnabledWithConditions($nameJa, $nameEn)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($nameJa, $nameEn, $query);

        return $query->count();
    }

    /**
     * @param string $nameJa
     * @param string $nameEn
     * @param $query
     *
     * @return mixed
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
