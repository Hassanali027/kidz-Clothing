<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('accounts')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('accounts'))->with('success', 'Logged in successfully!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('accounts')->with('success', 'Profile updated successfully!');
    }

    public function updateAddress(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'address' => 'nullable|string|max:500',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
        ]);

        $user->update([
            'address' => $request->address,
            'province' => $request->province,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
        ]);

        return redirect()->route('accounts')->with('success', 'Address updated successfully!');
    }

    public function viewOrder($id)
    {
        $order = Auth::user()->orders()->with('items')->findOrFail($id);

        return view('order-details', [
            'pageTitle' => 'Order Details | Kidz Wear',
            'order' => $order
        ]);
    }

    public function cancelOrder($id)
    {
        $order = Auth::user()->orders()->findOrFail($id);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }
}
