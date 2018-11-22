<?php
namespace App\Http\Middleware;

use Closure;

class Locale
{
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
        $locale = \LocaleHelper::getLocale();
        \Session::set('locale', $locale);
        \App::setLocale($locale);

        return $next($request);
    }
}
