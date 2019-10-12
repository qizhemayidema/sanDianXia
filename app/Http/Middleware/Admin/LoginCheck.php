<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Session;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('admin.manager')){
            return redirect()->route('admin.login');

        }
        return $next($request);
    }
}
