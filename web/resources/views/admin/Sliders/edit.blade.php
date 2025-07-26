@extends('layouts.admin')
@section('title', 'السلايدر')
@section('main_title_content', 'قائمة السلايدر')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('sliders.index') }}">السلايدر</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">تعديل الصورة</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('sliders.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">الصورة الحالية</label>
                            <div class="mb-2">
                                <img src="{{ asset($data->image) }}" alt="Current Image" style="max-width: 200px; max-height: 200px;">
                            </div>
                            <label for="">تغيير الصورة</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @error('image')
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