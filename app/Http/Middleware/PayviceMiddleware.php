<?php

namespace App\Http\Middleware;

use Closure;

class PayviceMiddleware
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
        if (\Session::has('curUsr') && \Session::has('curAcc') && \Session::has('curEm')){
            return $next($request);
        } else {
            return redirect('./');
        }
        return redirect('/');
    }
}
