<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\User;

Route::post('/login', function (Request $request) {
  try {
    $email = $request->input('email');
    $password = $request->input('password');

    $user = User::where('email', $email)->first();

    if (!Hash::check($password, $user->password)) {
      throw new Exception('Password does not match');
    }

    $token = Auth::fromUser($user);

    return Response::json([
      'success' => true,
      'accessToken' => $token,
    ])->cookie('jwt', $token, env('JWT_TTL', 60));
  } catch (Exception $error) {
    return Response::json([
      'success' => false,
    ]);
  }
});

Route::post('/logout', function (Request $request) {
  try {
    Auth::logout();

    return Response::json([
      'success' => true,
    ]);
  } catch (Exception $error) {
    return Response::json([
      'success' => false,
    ]);
  }
});