<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;

class Authenticate
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
    try {
      $user = Auth::user();

      if (!$user) throw new Exception('User authorization failed', 3);
    } catch (Exception $error) {
      return response()->json([
        'status' => false,
        'error' => [
          'code' => $error->getCode(),
          'message' => $error->getMessage(),
        ],
      ]);
    }

    return $next($request);
  }
}
