<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAudit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->user() && $request->isMethod('POST') && $request->user()->hasRole('admin')) {
            $action = $request->path();
            if ($request->is('*/store')) {
                $action = 'create';
            } elseif ($request->is('*/update')) {
                $action = 'update';
            } elseif ($request->is('*/destroy')) {
                $action = 'delete';
            }

            \App\Models\AuditLog::create([
                'user_id' => $request->user()->id,
                'action' => $action,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $response;
    }
}
