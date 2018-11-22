<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\SignInRequest;
use App\Http\Requests\Teacher\SignUpRequest;
use App\Services\TeacherServiceInterface;

class AuthController extends Controller
{
    /** @var \App\Services\TeacherServiceInterface TeacherService */
    protected $teacherService;

    public function __construct(TeacherServiceInterface $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function getSignIn()
    {
        return view('pages.teacher.auth.signin', [
            'titlePage' => trans('teacher.pages.title.signin'),
        ]);
    }

    public function postSignIn(SignInRequest $request)
    {
        $user = $this->teacherService->signIn($request->all());
        if (empty($user)) {
            return redirect()->action('Teacher\AuthController@getSignIn')
                ->with('message-failed', trans('teacher.pages.auth.messages.login_failed'));
        }

        return \RedirectHelper::intended(action('Teacher\IndexController@index'), $this->teacherService->getGuardName());
    }

    public function getSignUp()
    {
        return view('pages.teacher.auth.signup', [
            'titlePage' => trans('teacher.pages.title.signin'),
        ]);
    }

    public function postSignUp(SignUpRequest $request)
    {
        $user = $this->teacherService->signUp($request->all());
        if (empty($user)) {
            return redirect()->action('Teacher\AuthController@getSignUp');
        }

        return \RedirectHelper::intended(action('Teacher\IndexController@index'), $this->teacherService->getGuardName());
    }

    public function postSignOut()
    {
        $this->teacherService->signOut();

        return redirect()->action('Teacher\AuthController@getSignIn');
    }
}
