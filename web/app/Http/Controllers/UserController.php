<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\LocalNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = User::whereIn('role', ['User', 'Lawyer'])->orderBy('id', 'desc')->get();
        $data = User::orderBy('id', 'desc')->get();

        return view('admin.User.index', compact('data'));
    }
    public function indexDelete()
    {
        // $data = User::whereIn('role', ['User', 'Lawyer'])->onlyTrashed()->get();
        $data = User::onlyTrashed()->get();
        return view('admin.User.index-delete', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.User.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'name'=>'required|string',
            'role'
        ]);
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->date = now();
        $user->role = $request->role;
        $user->added_by = Auth::id();
        $user->save();
        // $data = [
        //     'title' => 'add',
        //     'body' => "create_User",
        //     'target' => 'user',
        //     'link' => route('user.index', ['user_id' => $user->id]),
        //     'target_id' => $user->id,
        //     'sender' => $user->id,
        // ];
        $data = [
            'title' => 'مرحبا بك في موقع شمول للمحاماة',
            'body' => "create_User",
            'target' => 'user',
            'link' => route('user.index', ['user_id' => $user->id]),
            'target_id' => $user->id,
            'sender' => $user->id,
        ];
        $user->notify(new LocalNotification($data));
        $data1 = [
            'title' => ' تم تسجيل حساب جديد ' . $user->username,
            'body' => "create_User",
            'target' => 'user',
            'link' => route('user.index', ['user_id' => $user->id]),
            'target_id' => $user->id,
            'sender' => $user->id,
        ];
        $users = User::whereIn('role', ['admin', 'superadmin'])->where('active', 1)->get();
        foreach ($users as $user) {

            $user->notify(new LocalNotification($data1));
        }

        return redirect()->route('user.index')->with('success', 'تم إضافة البيانات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::findOrFail($id);
        return view('admin.User.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrFail($id);
        return view('admin.User.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            DB::beginTransaction();
            $request->validate([
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($id),
                ],
                'username' => [
                    'required',
                    'string',
                    Rule::unique('users', 'username')->ignore($id),
                ],
              'password' => 'nullable|min:8',
                'name' => 'required|string',

            ]);

            $data = $request->except('_token');

            if (!$request->filled('password')) {
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($request->password);
            }

            $data['updated_by'] = Auth::id();
            $data['updated_at'] = now();
            User::where('id', $id)->update($data);

            DB::commit();
            return redirect()->route('user.index')->with(['success' => 'تم تعديل البيانات بنجاح']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفواً حدث خطأ  ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {


        $User = User::findOrFail($request->id);
        if (!$User) {
            return redirect()->back()->with(['error' => 'عفواً لا توجد بيانات']);
        }
        $request->validate([
            'reason' => 'required|string',
        ]);
        $User->updated_by = Auth::id();
        $User->delete_reason = $request->reason;
        $User->active = 0;
        $User->save();
        $User->delete();
        return redirect()->route('user.index')->with(['success' => 'تم حذف البيانات بنجاح']);
    }
    public function restore($id)
    {
        User::withTrashed()->find($id)->restore();

        $User = User::findOrFail($id);
        if (!$User) {
            return redirect()->route('user.indexDelete')->with(['error' => 'عفواً لا توجد بيانات']);
        }
        $User->updated_by = Auth::id();
        $User->delete_reason = "";
        $User->active = 1;
        $User->save();
        return redirect()->route('user.indexDelete')->with(['success' => 'تم استرجاع البيانات بنجاح']);
    }
}
