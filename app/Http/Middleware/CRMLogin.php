<?php

namespace App\Http\Middleware;

use Closure;
use Request;

class CRMLogin
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
        $admin_id = Request::cookie('admin_id');
        if(!$admin_id){
            return redirect('/');
        }
        return $next($request);
    }
}
