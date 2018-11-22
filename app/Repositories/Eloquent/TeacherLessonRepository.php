<?php
namespace App\Repositories\Eloquent;

use App\Models\TeacherLesson;
use App\Repositories\TeacherLessonRepositoryInterface;

class TeacherLessonRepository extends RelationModelRepository implements TeacherLessonRepositoryInterface
{
    protected $parentKey = 'teacher_id';

    protected $childKey = 'lesson_id';

    public function getBlankModel()
    {
        return new TeacherLesson();
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
