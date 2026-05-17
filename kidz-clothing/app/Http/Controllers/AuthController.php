<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Sign-in', [
            'pageTitle' => 'Sign-in | Kidz Wear',
            'metaDescription' => 'Log in to your Kidz Wear account.',
        ]);
    }

    public function showSignup()
    {
        return view('signup', [
            'pageTitle' => 'Create Account | Kidz Wear',
            'metaDescription' => 'Create a new account at Kidz Wear.',
        ]);
    }
}
