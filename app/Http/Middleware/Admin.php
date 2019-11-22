<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

class Admin
{
    use ApiResponser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->isAdmin()) {
            return $this->errorResponse('Você não tem permissão', 404);
        }

        return $next($request);
    }
}
