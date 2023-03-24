<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('admin.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect("dashboard");
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

}
