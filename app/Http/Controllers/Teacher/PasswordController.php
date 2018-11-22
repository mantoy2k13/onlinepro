<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\PasswordController as PasswordControllerBase;
use App\Services\TeacherServiceInterface;

class PasswordController extends PasswordControllerBase
{
    /** @var string $emailSetPageView */
    protected $emailSetPageView = 'pages.teacher.auth.forgot-password';

    /** @var string $passwordResetPageView */
    protected $passwordResetPageView = 'pages.teacher.auth.reset-password';

    /** @var string $returnAction */
    protected $returnAction = 'Teacher\IndexController@index';

    public function __construct(TeacherServiceInterface $teacherUserService)
    {
        $this->authenticatableService = $teacherUserService;
    }
}
