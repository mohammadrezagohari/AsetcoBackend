<?php

namespace App\Http\Middleware;

use App\Enums\RoleTypes;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::user()->checkedHasAnyRole([RoleTypes::ADMIN, RoleTypes::SUPER_ADMIN])) {
            return $next($request);
        }
        return response()->json([
            'message' => 'Access Denied!',
        ], HTTPResponse::HTTP_FORBIDDEN);
    }
}
