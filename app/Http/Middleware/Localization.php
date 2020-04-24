<?php

namespace App\Http\Middleware;
use Closure;
use Auth;
class Localization
{
  /**
  * Handle an incoming request.
  *
  * @param \Illuminate\Http\Request $request
  * @param \Closure $next
  * @return mixed
  */
  public function handle($request, Closure $next)
  {
     // Check user and determine localizaton
     $local = Auth::check() ? Auth::user()->lang : 'en';
     // set laravel localization
     app()->setLocale($local);
    // continue request
    return $next($request);
  }
}