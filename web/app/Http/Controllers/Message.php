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
        $users = User::where('id', '!=', Auth::id())->where('role', 'Lawyer')->get(); // استثناء المستخدم الحالي
        $selectedUser = $userId ? User::find($userId) : null;

        return view('admin.Message.index', compact('users', 'selectedUser'));
    }
    public function index3($userId = null)
    {
        $users = User::where('id', '!=', Auth::id())->where('role', 'User')->get(); // استثناء المستخدم الحالي
        $selectedUser = $userId ? User::find($userId) : null;

        return view('admin.Message.index', compact('users', 'selectedUser'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
