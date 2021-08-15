<?php

namespace App\Http\Middleware;

use Closure;

class HelloMiddleware
{
    public function handle($request, Closure $next)
    {
        $hello = 'Hello this is Middleware';
        $bye = 'Good bye Middleware';
        $data = [
            'hello'=>$hello,
            'bye'=>$bye,
        ];
        $request->merge($data);
        return $next($request);
    }
}