<?php
namespace App\Repositories\Eloquent;

use App\Repositories\TeacherPasswordResetRepositoryInterface;

class TeacherPasswordResetRepository extends PasswordResettableRepository implements TeacherPasswordResetRepositoryInterface
{
    protected $tableName = 'teacher_password_resets';
}
