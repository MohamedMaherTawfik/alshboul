<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\visitWeb;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }
    public function login(LoginRequest $request)
    {
        if (Auth::guard('web')->attempt(['username' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = Auth::guard('web')->user();
            visitWeb::create([
                'user_id' => $user->id,
                'type' => 'login'
            ]);
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('login')->with(['error' => 'عفوا بيانات التسجيل غير صحيحة !!']);
        }
    }
    public function logout()
    {
        $user = Auth::guard('web')->user();
        visitWeb::create([
            'user_id' => $user->id,
            'type' => 'logout'
        ]);
        Auth::logout();
        return redirect()->route('login');
    }
}