@extends('layouts.admin')
@section('title', 'المحامين ')
@section('main_title_content', ' قائمة المحامين ')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('lawyer.index') }}"> محامين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> تعديل بيانات المحامي
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('lawyer.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id }}">
                    {{-- <input type="hidden" name="added_by" value="{{ auth()->user()->id }}"> --}}
                    {{-- <input type="hidden" name="com_code" value="{{ auth()->user()->com_code }}"> --}}

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">الاسم </label>
                            <input type="text" name="name" value="{{ old('name', $data->name) }}" class="form-control"
                                placeholder="">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">تاريخ الميلاد </label>
                            <input type="date" name="dob" value="{{ old('dob', $data->dob) }}" class="form-control">
                            @error('dob')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">البريد الإلكتروني </label>
                            <input type="email" name="email" value="{{ old('email', $data->user->email) }}"
                                class="form-control">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">رقم الهاتف</label>
                            <input type="text" name="phone" value="{{ old('phone', $data->phone) }}"
                                class="form-control" placeholder="">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">الجنسية</label>
                            <input type="text" name="nationality" value="{{ old('nationality', $data->nationality) }}"
                                class="form-control" placeholder="">
                            @error('nationality')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">عنوان </label>
                            <input type="text" name="address" value="{{ old('address', $data->address) }}"
                                class="form-control" placeholder="">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">رقم الهوية</label>
                            <input type="text" name="id_number" value="{{ old('id_number', $data->id_number) }}"
                                class="form-control" placeholder="">
                            @error('id_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">رقم الرخصة</label>
                            <input type="text" name="license_number"
                                value="{{ old('license_number', $data->license_number) }}" class="form-control"
                                placeholder="">
                            @error('license_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">النقابة</label>
                            <input type="text" name="bar_association"
                                value="{{ old('bar_association', $data->bar_association) }}" class="form-control"
                                placeholder="">
                            @error('bar_association')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">التخصص</label>
                            <input type="text" name="specialization"
                                value="{{ old('specialization', $data->specialization) }}" class="form-control"
                                placeholder="">
                            @error('specialization')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">تاريخ إصدار الرخصة</label>
                            <input type="date" name="license_issue_date"
                                value="{{ old('license_issue_date', $data->license_issue_date) }}" class="form-control">
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


                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-success">تعديل</button>
                    </div>

            </div>
            </form>
            <div class="col-md-6">
                <table id="example2" class="table table-bordered table-hover">
                    <thead class="custom_thead">
                        <th>#</th>
                        <th>المرفق</th>
                        <th>الملف</th>
                        <th>التحميل </th>
                    </thead>
                    <tbody>

                        <tr>
                            <td>1</td>
                            <td> السيرة الذاتية</td>
                            <td>
                                <a href="{{ asset(Storage::url($data->cv_file)) }}" class="btn btn-info"
                                    target="_blank">عرض</a>
                            </td>
                            <td><a href="{{ asset(Storage::url($data->cv_file)) }}" class="btn btn-info"
                                    download>تحميل</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    </div>
@endsection
