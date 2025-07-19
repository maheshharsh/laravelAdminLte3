<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (! Auth::user()->hasAnyRole(Role::AUTH_USER_ROLES)) {
                Auth::logout();
                throw UnauthorizedException::forRoles(Role::AUTH_USER_ROLES);
            }
        } else {
            return redirect(route('admin.login'));
        }

        return $next($request);
    }
}
