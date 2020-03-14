<?php

namespace App\Http\Middleware;

use Closure;

use Auth;


class CheckPlan
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

        $getUser=Auth::user();
        $getPlanType=$getUser['PlanType'];

        if($getPlanType != "0"){
            return $next($request);
        }
        else{
            return redirect()->route("SetPlan");
        }

        



    }
}
