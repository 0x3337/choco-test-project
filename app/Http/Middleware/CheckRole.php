<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string  $role
   * @return mixed
   */
  public function handle($request, Closure $next, $role)
  {
    try {
      $user = Auth::user();

      if (!$user) throw new Exception('User authorization failed', 3);
      if ($user->role !== $role) throw new Exception('Permission to perform this action is denied', 5);
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
