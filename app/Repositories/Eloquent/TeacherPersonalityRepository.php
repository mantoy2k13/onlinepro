<?php
namespace App\Repositories\Eloquent;

use App\Models\TeacherPersonality;
use App\Repositories\TeacherPersonalityRepositoryInterface;

class TeacherPersonalityRepository extends RelationModelRepository implements TeacherPersonalityRepositoryInterface
{
    protected $parentKey = 'teacher_id';

    protected $childKey = 'personality_id';

    public function getBlankModel()
    {
        return new TeacherPersonality();
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
