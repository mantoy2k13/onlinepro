<?php
namespace App\Repositories\Eloquent;

use App\Models\TeacherServiceAuthentication;
use App\Repositories\TeacherServiceAuthenticationRepositoryInterface;

class TeacherServiceAuthenticationRepository extends ServiceAuthenticationRepository implements TeacherServiceAuthenticationRepositoryInterface
{
    public $authModelColumn = 'user_id';

    public function getBlankModel()
    {
        return new TeacherServiceAuthentication();
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
