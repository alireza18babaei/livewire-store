<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function abort;
use function auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $option = null): Response
    {
        $user = auth()->user();

        if (!$user->adminPanelAccess()) {
            abort(404);
        }

        if ($option === "userAccess" && !$user->userAccess()) {
            abort(404);
        }



        return $next($request);


    }
}
