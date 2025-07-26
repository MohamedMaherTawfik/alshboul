@extends('layouts.admin')
@section('title', 'روابط التواصل الاجتماعي')
@section('main_title_content', 'روابط التواصل الاجتماعي')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('sociallinks.index') }}">روابط التواصل الاجتماعي</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">تعديل البيانات</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('sociallinks.update') }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">فيسبوك</label>
                            <input type="text" name="facebook" value="{{ old('facebook', $data->facebook) }}"
                                class="form-control">
                            @error('facebook')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">تويتر</label>
                            <input type="text" name="x" value="{{ old('x', $data->x) }}" class="form-control">
                            @error('x')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">انستجرام</label>
                            <input type="text" name="instagram" value="{{ old('instagram', $data->instagram) }}"
                                class="form-control">
                            @error('instagram')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">واتساب</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $data->whatsapp) }}"
                                class="form-control">
                            @error('whatsapp')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ old('email', $data->email) }}"
                                class="form-control">
                            @error('email')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">رقم المكتب</label>
                            <input type="text" name="phone" value="{{ old('phone', $data->phone) }}"
                                class="form-control">
                            @error('phone')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">الهاتف الخاص </label>
                            <input type="text" name="phone_spical"
                                value="{{ old('phone_spical', $data->phone_spical) }}" class="form-control">
                            @error('phone_spical')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">رقم تليفاكس</label>
                            <input type="text" name="fax" value="{{ old('fax', $data->fax) }}" class="form-control">
                            @error('fax')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-success">تعديل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
