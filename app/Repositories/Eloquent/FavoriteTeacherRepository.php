<?php
namespace App\Repositories\Eloquent;

use App\Models\FavoriteTeacher;
use App\Repositories\FavoriteTeacherRepositoryInterface;

class FavoriteTeacherRepository extends SingleKeyModelRepository implements FavoriteTeacherRepositoryInterface
{
    public function getBlankModel()
    {
        return new FavoriteTeacher();
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
}
