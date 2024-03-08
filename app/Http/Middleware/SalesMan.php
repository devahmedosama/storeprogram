<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesMan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Auth::guest()) {
            return redirect('login');
        }else{
            if (auth()->user()->type != 3 && auth()->user()->type != 0) {
                return redirect('admin');
            }
        }
        return $next($request);
    }
}
