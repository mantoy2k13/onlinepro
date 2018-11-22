<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SignInPopUpRequest;
use App\Http\Requests\User\SignInRequest;
use App\Http\Requests\User\SignUpRequest;
use App\Models\User;
use App\Services\MailServiceInterface;
use App\Services\UserServiceInterface;
use ClassPreloader\Config;

class AuthController extends Controller
{
    /** @var \App\Services\UserServiceInterface UserService */
    protected $userService;
    /** @var \App\Services\MailServiceInterface $mailService */
    protected $mailService;

    public function __construct(
        UserServiceInterface $userService,
        MailServiceInterface $mailService
    ) {
        $this->userService = $userService;
        $this->mailService = $mailService;
    }

    public function getSignIn()
    {
        return view('pages.user.auth.signin', [
            'titlePage' => trans('user.pages.title.signin'),
        ]);
    }

    public function postSignIn(SignInRequest $request)
    {
        $user = $this->userService->signIn($request->all());
        if (empty($user)) {
            return redirect()->action('User\AuthController@getSignIn')
                ->with('message-failed', trans('teacher.pages.auth.messages.login_failed'));
        }

        return \RedirectHelper::intended(action('User\IndexController@index'), $this->userService->getGuardName());
    }

    public function postSignInPopUp(SignInPopUpRequest $request)
    {
        $input['email']       = $request->get('field_email');
        $input['password']    = $request->get('field_password');
        $input['remember_me'] = $request->get('remember_me');
        $user                 = $this->userService->signIn($input);

        if (empty($user)) {
            return redirect()->back()->with('error_code', config('constants.error_code.login_failed'));
        }

        return redirect()->back();
    }

    public function getSignUp()
    {
        return view('pages.user.auth.signup', [
            'titlePage' => trans('user.pages.title.signup'),
        ]);
    }

    public function postSignUp(SignUpRequest $request)
    {
        $input                    = $request->all();
        $validationCode           = $this->userService->generateValidationCode();
        $input['validation_code'] = $validationCode;
        $user                     = $this->userService->signUp($input);

        if (empty($user)) {
            return redirect()->action('User\AuthController@getSignUp');
        }
        $this->mailService->sendMailVerifyCode($user);

        return \RedirectHelper::intended(action('User\AuthController@signUpSuccessful'), $this->userService->getGuardName());
    }

    public function postSignOut()
    {
        $this->userService->signOut();

        return redirect()->back();
    }

    public function verify($validationCode)
    {
        if (!$validationCode) {
            abort(404);
        }

        $confirm = $this->userService->confirmUser($validationCode);

        if (!$confirm) {
            abort(404);
        }

        return \RedirectHelper::intended(action('User\AuthController@getSignIn'), $this->userService->getGuardName());
    }

    public function signUpSuccessful()
    {
        return view('pages.user.auth.signup-successful', [
        ]);
    }

    public function verifyChangeEmail($validationCode)
    {
        if (!$validationCode) {
            abort(404);
        }

        $confirm = $this->userService->confirmChangeEmail($validationCode);

        if (!$confirm) {
            abort(404);
        }

        return view('pages.user.auth.email-change-successful', [
        ]);
    }
}
