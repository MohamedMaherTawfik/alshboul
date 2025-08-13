@extends('layouts.admin')
@section('title', 'المستخدمين ')
@section('main_title_content', ' قائمة المستخدمين ')
@section('title_content', 'أضافة')
@section('link_content')
    <a href="{{ route('user.index') }}"> المستخدمين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> اضافة موكل جديد
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('user.store') }}" method="post">
                    @csrf
                    {{-- <input type="hidden" name="updated_by" value="{{ auth()->user()->id }}"> --}}
                    <input type="hidden" name="added_by" value="{{ Auth::user()->id }}">



                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for=""> اسم المشترك </label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                placeholder="">
                            @error('name')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> اسم المستخدم </label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control"
                                placeholder="">
                            @error('username')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> البريد الإلكتروني </label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="">
                            @error('email')
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
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>وكيل</option>
                                <option value="Lawyer" {{ old('role') == 'Lawyer' ? 'selected' : '' }}>محامي</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>أدمن</option>
                                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>سوبر أدمن
                                </option>
                            </select>
                            @error('active')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-success">أضافة</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const companyInput = document.getElementById("company_name");
            const nationalWrapper = document.getElementById("company_national_wrapper");

            function toggleNationalField() {
                if (companyInput.value.trim() !== "") {
                    nationalWrapper.style.display = "block";
                } else {
                    nationalWrapper.style.display = "none";
                }
            }

            companyInput.addEventListener("input", toggleNationalField);

            // تشغيل الفحص أول ما يفتح الصفحة لو في قيمة مسبقة
            toggleNationalField();
        });
    </script>


@endsection
