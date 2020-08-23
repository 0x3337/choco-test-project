<?php

namespace App\Http\Middleware;

use Closure;

class JWTCookie
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
    $jwt = $request->cookie('jwt');
    if (!is_null($jwt)) {
      $request->headers->set('Authorization', 'Bearer '. $jwt);
    }

    return $next($request);
  }
}
