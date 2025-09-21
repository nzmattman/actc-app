<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use ACTC\Core\States\Status\Cancelled;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Active
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $status = $request->user()->status;

        if (is_a($status, Cancelled::class)) {
            return redirect()->route('profile.cancelled');
        }

        return $next($request);
    }
}
