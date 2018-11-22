<?php
namespace App\Repositories\Eloquent;

use App\Models\TeacherCategory;
use App\Repositories\TeacherCategoryRepositoryInterface;

class TeacherCategoryRepository extends RelationModelRepository implements TeacherCategoryRepositoryInterface
{
    protected $parentKey = 'teacher_id';

    protected $childKey = 'category_id';

    public function getBlankModel()
    {
        return new TeacherCategory();
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
