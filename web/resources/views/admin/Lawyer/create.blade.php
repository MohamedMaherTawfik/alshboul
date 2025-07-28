@extends('layouts.admin')
@section('title', 'المحامين ')
@section('main_title_content', ' قائمة المحامين ')
@section('title_content', 'إنشاء')
@section('link_content')
    <a href="{{ route('lawyer.index') }}"> محامين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> اضافة محامي جديد
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('lawyer.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="updated_by" value="{{ auth()->user()->id }}"> --}}
                    <input type="hidden" name="added_by" value="{{ Auth::user()->id }}">

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">الاسم </label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                placeholder="">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">تاريخ الميلاد </label>
                            <input type="date" name="dob" value="{{ old('dob') }}" class="form-control">
                            @error('dob')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">البريد الإلكتروني </label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">رقم الهاتف</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                placeholder="">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">الجنسية</label>
                            <input type="text" name="nationality" value="{{ old('nationality') }}" class="form-control"
                                placeholder="">
                            @error('nationality')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">عنوان </label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                                placeholder="">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">رقم الهوية</label>
                            <input type="text" name="id_number" value="{{ old('id_number') }}" class="form-control"
                                placeholder="">
                            @error('id_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">رقم الرخصة</label>
                            <input type="text" name="license_number" value="{{ old('license_number') }}"
                                class="form-control" placeholder="">
                            @error('license_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">النقابة</label>
                            <input type="text" name="bar_association" value="{{ old('bar_association') }}"
                                class="form-control" placeholder="">
                            @error('bar_association')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">التخصص</label>
                            <input type="text" name="specialization" value="{{ old('specialization') }}"
                                class="form-control" placeholder="">
                            @error('specialization')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">تاريخ إصدار الرخصة</label>
                            <input type="date" name="license_issue_date" value="{{ old('license_issue_date') }}"
                                class="form-control">
                            @error('license_issue_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">السيرة الذاتية (اختياري)</label>
                            <input type="file" name="cv_file" class="form-control">
                            @error('cv_file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for=""> اسم المستخدم </label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control"
                                placeholder="">
                            @error('username')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for=""> رقم الهاتف</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                placeholder="">
                            @error('phone')
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
