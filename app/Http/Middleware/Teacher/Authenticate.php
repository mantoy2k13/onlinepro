<?php
namespace App\Http\Middleware\Teacher;

use App\Services\TeacherServiceInterface;
use Closure;

class Authenticate
{
    /** @var TeacherServiceInterface */
    protected $teacherService;

    /**
     * Create a new filter instance.
     *
     * @param TeacherServiceInterface $teacherService
     */
    public function __construct(TeacherServiceInterface $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->teacherService->isSignedIn()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return \RedirectHelper::guest(action('Teacher\AuthController@getSignIn'), $this->teacherService->getGuardName());
            }
        }
        view()->share('authUser', $this->teacherService->getUser());

        return $next($request);
    }
}
