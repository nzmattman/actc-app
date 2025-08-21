<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\ACTC\Admins\Admin;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        if (auth()->check() && is_a(auth()->user(), Admin::class)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
