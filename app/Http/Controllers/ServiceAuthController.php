<?php
namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Services\AuthenticatableServiceInterface;
use App\Services\ServiceAuthenticationServiceInterface;
use Laravel\Socialite\Contracts\Factory as Socialite;

class ServiceAuthController extends Controller
{
    /** @var string */
    protected $driver = '';

    /** @var string */
    protected $redirectAction = '';

    /** @var string */
    protected $errorRedirectAction = '';

    /** @var \App\Services\AuthenticatableServiceInterface */
    protected $authenticatableService;

    /** @var \App\Services\ServiceAuthenticationServiceInterface */
    protected $serviceAuthenticationService;

    /** @var Socialite */
    protected $socialite;

    public function __construct(
        AuthenticatableServiceInterface $authenticatableService,
        ServiceAuthenticationServiceInterface $serviceAuthenticationService,
        Socialite $socialite
    ) {
        $this->authenticatableService       = $authenticatableService;
        $this->serviceAuthenticationService = $serviceAuthenticationService;
        $this->socialite                    = $socialite;
    }

    public function redirect(BaseRequest $request)
    {
        $lastUrl   = \URL::previous();
        $userAgent = $this->authenticatableService->genMD5UserAgent($request->header('User-Agent'));
        \Session::put('lastUrl_'.$userAgent, $lastUrl);
        \Config::set("services.$this->driver.redirect", action(config("services.$this->driver.redirect_action")));

        return $this->socialite->driver($this->driver)->redirect();
    }

    public function callback(BaseRequest $request)
    {
        \Config::set("services.$this->driver.redirect", action(config("services.$this->driver.redirect_action")));

        if ($this->driver == 'google') {
            session()->regenerate();
            $state = $request->get('state');
            $request->session()->put('state', $state);
        }

        try {
            $serviceUser = $this->socialite->driver($this->driver)->user();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect()->action($this->errorRedirectAction)->withErrors([trans('auth.sign_in_failed_title'), trans('auth.social_sign_in_failed')]);
        }

        $serviceUserId = $serviceUser->getId();
        $name          = $serviceUser->getName();
        $email         = $serviceUser->getEmail();

        if (empty($email)) {
            return redirect()->action($this->errorRedirectAction)->withErrors([trans('auth.sign_in_failed_title'), trans('auth.failed_to_get_email')]);
        }

        $authUserId = $this->serviceAuthenticationService->getAuthModelId($this->driver, [
            'service'    => $this->driver,
            'service_id' => $serviceUserId,
            'name'       => $name,
            'email'      => $email,
        ]);

        if (!empty($authUserId)) {
            $this->authenticatableService->signInById($authUserId);
        } else {
            return redirect()->action($this->errorRedirectAction)->withErrors(trans('validation.email_unique'));
        }
        $userAgent   = $this->authenticatableService->genMD5UserAgent($request->header('User-Agent'));
        $redirectUrl = \Session::get('lastUrl_'.$userAgent);
        if (!empty($redirectUrl)) {
            \Session::forget('lastUrl');

            return redirect($redirectUrl);
        }

        return redirect()->intended(action($this->redirectAction));
    }
}
