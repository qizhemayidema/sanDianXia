<?php

namespace App\Http\Middleware\Pc;

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
        if (!Session::has('pc')){
            return redirect()->route('pc.index.index');
        }
        return $next($request);
    }
}
