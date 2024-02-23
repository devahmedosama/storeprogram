<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->id()) {
            $lang  =  auth()->user()->lang;
            if ($lang == 'ar') {
                \App::setLocale('ar');
            }else{
                \App::setLocale('en');
            }
        }
        return $next($request);
    }
}
