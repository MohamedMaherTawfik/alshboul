<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Message extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId = null)
    {
        $users = User::where('id', '!=', Auth::id())->whereIn('role', ['superadmin', 'admin'])->get(); // استثناء المستخدم الحالي
        $selectedUser = $userId ? User::find($userId) : null;

        return view('admin.Message.index', compact('users', 'selectedUser'));
    }

    public function index1($userId = null)
    {
        $users = User::where('id', '!=', Auth::id())->whereIn('role', ['superadmin', 'admin'])->get(); // استثناء المستخدم الحالي
        $selectedUser = $userId ? User::find($userId) : null;
        return view('user.Message.index', compact('users', 'selectedUser'));
    }
    public function index2($userId = null)
    {
        $users = User::where('id', '!=', Auth::id())->where('role', 'lawyer')->get(); // استثناء المستخدم الحالي
        $selectedUser = $userId ? User::find($userId) : null;

        return view('admin.Message.index', compact('users', 'selectedUser'));
    }
    public function index3($userId = null)
    {
        $users = User::where('id', '!=', Auth::id())->where('role', 'user')->get(); // استثناء المستخدم الحالي
        $selectedUser = $userId ? User::find($userId) : null;

        return view('admin.Message.index', compact('users', 'selectedUser'));
    }


    public function showNotifications()
    {
        $notifications = \App\Models\Message::where('receiver_id', Auth::id())->where('seen', 0)->get();
        return view('admin.Message.show', compact('notifications'));
    }

    public function readMessage(\App\Models\Message $message)
    {
        if ($message->receiver_id == Auth::id()) {
            $message->seen = 1;
            $message->save();
            return redirect()->back()->with('success', 'تم تعليم الإشعار كمقروء.');
        }

        return abort(403);
    }

}