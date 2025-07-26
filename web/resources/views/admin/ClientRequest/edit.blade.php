@extends('layouts.admin')
@section('title', ' طلبات الموكلين ')
@section('main_title_content', ' قائمة طلبات الموكلين ')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('request.index') }}"> موكلين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> تعديل بيانات الموكل
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('request.update', $data->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id }}">
                    {{-- <input type="hidden" name="added_by" value="{{ auth()->user()->id }}"> --}}
                    {{-- <input type="hidden" name="com_code" value="{{ auth()->user()->com_code }}"> --}}

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">اسم الفرع </label>
                            <input type="text" name="name" value="{{ old('name', $data->name) }}" class="form-control"
                                placeholder="">
                            @error('name')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for=""> عنوان الفرع</label>
                            <input type="text" name="address" value="{{ old('address', $data->address) }}"
                                class="form-control" placeholder="">
                            @error('address')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">هاتف الفرع </label>
                            <input type="text" name="phones" value="{{ old('phones', $data->phones) }}"
                                class="form-control" placeholder="">
                            @error('phones')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for=""> بريد الفرع</label>
                            <input type="text" name="email" value="{{ old('email', $data->email) }}"
                                class="form-control" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="الحالة"></label>
                            <select class="form-control" name="active">
                                <option value="1" {{ old('active', $data->active) == 1 ? 'selected' : '' }}>فعال
                                </option>
                                <option value="0" {{ old('active', $data->active) == 0 ? 'selected' : '' }}>معطل
                                </option>
                            </select>
                            @error('active')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
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
