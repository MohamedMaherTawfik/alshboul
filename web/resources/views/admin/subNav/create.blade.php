@extends('layouts.admin')

@section('title', 'انشاء اجراء تابع ل ' . $nav->name)
@section('main_title_content', 'انشاء اجراء تابع ل ' . $nav->name)
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('subNav.index', $nav) }}">{{ $nav->name }}</a>
@endsection

@section('content')
    <div class="container-fluid">
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-plus-circle mr-2"></i>
                    إضافة إجراء جديد
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('subNav.store', $nav) }}">
                    @csrf

                    <div class="row mb-3">
                        <!-- الإجراء -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="action" class="form-label">الإجراء</label>
                                <input type="text" name="action" id="action"
                                    class="form-control @error('action') is-invalid @enderror" value="{{ old('action') }}"
                                    placeholder="الإجراء">
                                @error('action')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="created_at" class="form-label">تاريخ الادخال</label>
                                <input type="date" name="created_at" id="created_at"
                                    class="form-control @error('created_at') is-invalid @enderror"
                                    value="{{ now()->format('Y-m-d') }}" placeholder="الإجراء">
                                @error('created_at')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- الإجراء التالي -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="next_action" class="form-label">الإجراء التالي</label>
                                <input type="text" name="next_action" id="next_action"
                                    class="form-control @error('next_action') is-invalid @enderror"
                                    value="{{ old('next_action') }}" placeholder="الإجراء التالي">
                                @error('next_action')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- تاريخ الإجراء التالي -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="next_action_date" class="form-label">تاريخ الإجراء التالي</label>
                                <input type="date" name="next_action_date" id="next_action_date"
                                    class="form-control @error('next_action_date') is-invalid @enderror"
                                    value="{{ old('next_action_date') }}">
                                @error('next_action_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- المحامي -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_lawyer_id" class="form-label">المحامي المسؤول</label>
                                <select name="user_lawyer_id" id="user_lawyer_id"
                                    class="form-control @error('user_lawyer_id') is-invalid @enderror">
                                    <option value="" selected>اختر المحامي</option>
                                    @foreach ($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}"
                                            {{ old('user_lawyer_id') == $lawyer->id ? 'selected' : '' }}>
                                            {{ $lawyer->username }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_lawyer_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- المذكرة -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="note" class="form-label">الملاحظات</label>
                                <input type="text" name="note" id="note"
                                    class="form-control @error('note') is-invalid @enderror" value="{{ old('note') }}"
                                    placeholder="الملاحظات">
                                @error('note')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">

                        <!-- المستخدم المدخل -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id" class="form-label">المستخدم المدخل</label>
                                <input type="text" id="user_id" class="form-control"
                                    value="{{ Auth::user()->username }}" readonly>
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            </div>
                        </div>


                        <!-- تابع ل القائمه -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sub_nav_id" class="form-label">تابع ل القائمه</label>
                                <input type="text" name="sub_nav_id" id="sub_nav_id"
                                    class="form-control @error('sub_nav_id') is-invalid @enderror"
                                    value="{{ $nav->mainNav->title }}"readonly>
                                @error('sub_nav_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-save mr-2"></i> حفظ الإجراء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
