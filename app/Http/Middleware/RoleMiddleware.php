<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin/articles*')) {
            if ($request->user() && ($request->user()->hasRole('admin') || $request->user()->can('delete-article'))) {
                return $next($request);
            }

            return response()->json([
                'message' => 'Akses ditolak. Anda tidak memiliki izin untuk melakukan tindakan ini.'
            ], 403);
        }

        return $next($request);
    }
}
