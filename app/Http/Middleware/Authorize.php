<?php

namespace App\Http\Middleware;

use Closure;
use App\Lib\Permission;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    

    public function handle($request, Closure $next,$permission_name)
    {
        $current_action = \Route::currentRouteAction();        
        $permission = new Permission();
        $permission_name = $permission->getName($permission_name,$current_action);

        return $next($request);
    }


}
