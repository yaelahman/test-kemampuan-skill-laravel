<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            return redirect()->to(url('/'));
        };

        return redirect()->back()->with('error', 'Harap periksa email dan password!')->withInput(['email']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->to(url('/'));
    }
}
