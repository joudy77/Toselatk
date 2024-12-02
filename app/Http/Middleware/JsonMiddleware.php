<?php

namespace App\Http\Middleware;

use Closure;

class JsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // تعيين Content-Type تلقائيًا إلى application/json إذا لم يكن محددًا
        if (!$request->headers->has('Content-Type')) {
            $request->headers->set('Content-Type', 'application/json');
        }

        return $next($request);
    }
}
?>