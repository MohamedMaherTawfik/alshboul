@extends('layouts.admin')
@section('title', 'المستخدمين ')
@section('main_title_content', ' قائمة المستخدمين ')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('user.index') }}"> المستخدمين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> تعديل بيانات المستخدم
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('user.update', $data->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id }}">
                    {{-- <input type="hidden" name="added_by" value="{{ auth()->user()->id }}"> --}}
                    {{-- <input type="hidden" name="com_code" value="{{ auth()->user()->com_code }}"> --}}

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for=""> اسم المشترك </label>
                            <input type="text" name="name" value="{{ old('name', $data->name) }}" class="form-control"
                                placeholder="">
                            @error('name')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> اسم المستخدم </label>
                            <input type="text" name="username" value="{{ old('username', $data->username) }}"
                                class="form-control" placeholder="">
                            @error('username')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> البريد الإلكتروني </label>
                            <input type="email" name="email" value="{{ old('email', $data->email) }}"
                                class="form-control" placeholder="">
                            @error('username')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> كلمة المرور</label>
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control"
                                placeholder="">
                            @error('password')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="الحالة">نوع المستخدم</label>
                            <select class="form-control" name="role">
                                <option value="User" {{ old('role', $data->role) == 'User' ? 'selected' : '' }}>وكيل
                                </option>
                                <option value="Lawyer" {{ old('role', $data->role) == 'Lawyer' ? 'selected' : '' }}>
                                    محامي</option>
                                <option value="admin" {{ old('role', $data->role) == 'admin' ? 'selected' : '' }}>أدمن
                                </option>
                                <option value="superadmin"
                                    {{ old('role', $data->role) == 'superadmin' ? 'selected' : '' }}>سوبر أدمن
                                </option>

                            </select>
                            @error('active')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>


                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-success">تعديل</button>
                    </div>

            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
