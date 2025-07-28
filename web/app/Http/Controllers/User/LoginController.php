<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\VisitClient;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('user.auth.login');
    }
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        if (Auth::guard('web')->attempt($validated)) {
            $clientid = Auth::user()->client->id;
            VisitClient::create(
                [
                    'client_id' => $clientid,
                    'visited_at' => now(),
                    'website' => 1
                ]
            );
            return redirect()->route('user.dashboard');
        } else {
            return redirect()->route('login.user')->with(['error' => 'عفوا بيانات التسجيل غير صحيحة !!']);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
