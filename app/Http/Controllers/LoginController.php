<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginshow(){
        return view('login');
    }

    public function login(Request $request)
{
    $request->validate([
        'contact_number' => 'required',
        'password' => 'required',
    ]);

    $user = DB::table('users')->where('contact_number', $request->contact_number)->first();

    if ($user && $request->password === $user->password) {
        $user_id = Auth::loginUsingId($user->id);

        if (strtolower($user->designation) === 'admin') {
            return redirect()->route('admin.dashboard.dashboard');
        } else {
            return redirect()->route('user.dashboard.dashboard');
        }
    }

    return back()->withErrors(['contact_number' => 'Invalid credentials']);
}

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
