@extends('layouts.admin')
@section('title', 'الموكلين ')
@section('main_title_content', ' قائمة الموكلين ')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('client.index') }}"> موكلين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> تعديل بيانات الموكل
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('client.update', $data->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id }}">
                    {{-- <input type="hidden" name="added_by" value="{{ auth()->user()->id }}"> --}}
                    {{-- <input type="hidden" name="com_code" value="{{ auth()->user()->com_code }}"> --}}

                    <div class="row ">
                        <div class="form-group col-md-4">
                            <label for="">اسم الموكل </label>
                            <input type="text" name="name" value="{{ old('name', $data->name) }}" class="form-control"
                                placeholder="">
                            @error('name')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">اسم الشركة </label>
                            <input type="text" id="company_name" name="company_name"
                                value="{{ old('company_name', $data->company_name) }}" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4" id="company_national_wrapper" style="display: none;">
                            <label for="">رقم الوطني للشركة </label>
                            <input type="text" name="company_national_number"
                                value="{{ old('company_national_number', $data->company_national_number) }}"
                                class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> الرقم القومي </label>
                            <input type="text" name="national_id" value="{{ old('national_id', $data->national_id) }}"
                                class="form-control" placeholder="">
                            @error('national_id')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> الجنسية </label>
                            <input type="text" name="nationality" value="{{ old('nationality', $data->nationality) }}"
                                class="form-control" placeholder="">
                            @error('nationality')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> عنوان </label>
                            <input type="text" name="address" value="{{ old('address', $data->address) }}"
                                class="form-control" placeholder="">
                            @error('address')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">هاتف </label>
                            <input type="text" name="phone" value="{{ old('phone', $data->phone) }}"
                                class="form-control" placeholder="">
                            @error('phone')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> اسم المستخدم </label>
                            <select type="text" name="user_id" class="form-control">
                                <option value="">اختر اسم المستخدم</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $data->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->username }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
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
