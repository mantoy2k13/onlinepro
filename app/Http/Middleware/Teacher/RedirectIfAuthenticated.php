<?php
namespace App\Http\Middleware\Teacher;

use App\Services\TeacherServiceInterface;

class RedirectIfAuthenticated
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
    public function handle($request, \Closure $next)
    {
        if ($this->teacherService->isSignedIn()) {
            return redirect()->action('Teacher\IndexController@index');
        }

        return $next($request);
    }
}
