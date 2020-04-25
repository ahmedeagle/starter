<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;

class Authenticate extends Middleware
{

    protected  $guards = [];

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;


        if (Auth::guard($this->guards)->guest()) {
            switch ($this->guards) {
                case 'admin':
                    return redirect() -> route('admin');
                case 'web':
                    return redirect() -> route('site');
                default:
                    return redirect("/login");
            }
        }
        return $next($request);
    }

}
