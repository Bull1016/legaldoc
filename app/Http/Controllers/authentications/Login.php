<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
  public function login()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login', ['pageConfigs' => $pageConfigs]);
  }
  public function loginStore(Request $request)
  {
    try {
      $request->validate([
        'email' => 'required',
        'password' => 'required',
      ], [
        'email.required' => 'Votre email est requis',
        'password.required' => 'Votre mot de passe est requis'
      ]);

      $credentials = $request->only('email', 'password');

      if (Auth::attempt($credentials)) {
        return response()->json([
          'success' => true,
          'redirect' => route('dashboard'),
          'notyf' => [
            'type' => 'success',
            'message' => 'Connexion réussie ✅'
        ]
        ], 200);
      } else {
        return response()->json([
          'success' => false,
          'notyf' => [
            'type' => 'error',
            'message' => 'Identifiants invalides ❌'
        ]
        ], 401);
      }
    } catch (\Throwable $th) {
      Session::flush();
      Auth::logout();
      return response()->json([
        'success' => false,
        'error' => $th->getMessage(),
        'notyf' => [
          'type' => 'error',
          'message' => 'Une erreur est survenue ❌'
        ]
      ], 500);
    }
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('home')->with('success', 'Deconnexion effectuee ✅');
  }
}
