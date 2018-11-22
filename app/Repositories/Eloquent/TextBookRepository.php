<?php
namespace App\Repositories\Eloquent;

use App\Models\TextBook;
use App\Repositories\TextBookRepositoryInterface;

class TextBookRepository extends SingleKeyModelRepository implements TextBookRepositoryInterface
{
    public function getBlankModel()
    {
        return new TextBook();
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
     * @param string $title
     * @param string $level
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return mixed
     */
    public function getEnabledWithConditions($title, $level, $order, $direction, $offset, $limit)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($title, $level, $query);

        return $query->offset($offset)->limit($limit)->orderBy($order, $direction)->get();
    }

    public function countEnabledWithConditions($title, $level)
    {
        $query = $this->getBlankModel();
        $query = $this->setSearchQuery($title, $level, $query);

        return $query->count();
    }

    /**
     * @param string                             $title
     * @param string                             $level
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function setSearchQuery($title, $level, $query)
    {
        if (!empty($title)) {
            $query = $query->where(function ($subquery) use ($title) {
                $subquery->where('title', 'like', '%'.$title.'%');
            });
        }
        if (!empty($level)) {
            $query = $query->where(function ($subquery) use ($level) {
                $subquery->where('level', 'like', '%'.$level.'%');
            });
        }

        return $query;
    }
}
