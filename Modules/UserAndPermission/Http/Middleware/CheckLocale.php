<?php

namespace Modules\UserAndPermission\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CheckLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()
            && ! is_null(auth()->user()->setting)
            && ! App::isLocale(auth()->user()->setting->language)
        ) {
            App::setlocale(auth()->user()->setting->language);
        }

        return $next($request);
    }
}
