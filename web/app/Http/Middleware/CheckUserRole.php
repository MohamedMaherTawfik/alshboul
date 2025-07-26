<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            // لو مش مسجل دخول
            return redirect()->route('login');
        }

        if (!in_array($user->role, $roles)) {
            // لو الرول تبعه مش ضمن المسموحين
            abort(403, 'ليس لديك صلاحية الوصول.');
        }

        return $next($request);
    }
}
