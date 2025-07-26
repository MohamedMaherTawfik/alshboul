@extends('layouts.admin')
@section('title', 'السلايدر')
@section('main_title_content', 'قائمة السلايدر')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('sliders.index') }}">السلايدر</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">إضافة صور جديدة</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('sliders.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">الصور</label>
                            <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                            @error('images')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-success">إضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 