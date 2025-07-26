@extends('layouts.admin')
@section('title', 'شريط التحرك')
@section('main_title_content', 'قائمة شريط التحرك')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('move-bars.index') }}">شريط التحرك</a>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">تعديل شريط التحرك</h3>
                        <div class="card-tools">
                            <a href="{{ route('move-bars.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> العودة للقائمة
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('move-bars.update', $moveBar->id) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="text">النص</label>
                                <input type="text" class="form-control @error('text') is-invalid @enderror"
                                    id="text" name="text" value="{{ old('text', $moveBar->text) }}" required>
                                @error('text')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="active">الحالة</label>
                                <select class="form-control @error('active') is-invalid @enderror" id="active"
                                    name="active" required>
                                    <option value="1" {{ old('active', $moveBar->active) == '1' ? 'selected' : '' }}>
                                        نشط</option>
                                    <option value="0" {{ old('active', $moveBar->active) == '0' ? 'selected' : '' }}>
                                        غير نشط</option>
                                </select>
                                @error('active')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">تحديث</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
