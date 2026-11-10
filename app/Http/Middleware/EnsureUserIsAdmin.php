<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next, string $guard = 'web')
    {
        abort_unless($request->user($guard)?->role === 'admin', 403);

        return $next($request);
    }
}
