<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
 class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

   protected function authenticated(Request $request, $user)
{
    
    if ($user->hasRole('administrateur')) {
        return redirect()->route('admin.dashboard');
    }
 
    if ($user->hasRole('enseignant')) {
        return redirect()->route('enseignants.dashboard');
    }

    if ($user->hasRole('parents')) {
        return redirect()->route('parents.dashboard');
    }

    if ($user->hasRole('eleve')) {
        return redirect()->route('eleve.dashboard');
    }

    return redirect('/');
}

}
