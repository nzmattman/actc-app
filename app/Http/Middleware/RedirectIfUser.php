<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        if (auth()->guard('web')->check()) {
            return redirect('dashboard');
        }

        return $next($request);
    }
}
