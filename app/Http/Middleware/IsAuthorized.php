<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {

        if($request->user()->tokenCan($permission)){
            return $next($request);
        }
        if($request->route('user')){
            if($request->user()->id === $request->route('user')->id){
                return $next($request);
            }
        }


        return response()->json([
            'message' => 'the action is not authorized!',
        ], 403);
    }
}
