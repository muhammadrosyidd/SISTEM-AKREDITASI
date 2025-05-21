<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            abort(401, 'Unauthorized');
        }

        $userRole = $request->user()->getRole(); // Get role from UserModel
        Log::info('Checking role: ' . $userRole . ' against allowed roles: ' . implode(', ', $roles));

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Forbidden, kamu tidak punya akses ke halaman ini');
    }
}