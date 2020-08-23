<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Response;
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

      if(!$user) throw new Exception('User not found');
    } catch (Exception $error) {
      return response()->json([
        'status' => false,
        'error' => [
          'code' => 3,
          'message' => 'User authorization failed',
        ],
      ]);
    }

    return $next($request);
  }
}
