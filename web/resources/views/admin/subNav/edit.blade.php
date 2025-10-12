@extends('layouts.admin')

@section('title', 'تعديل الإجراء')
@section('main_title_content', 'تعديل الإجراء')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('subNav.index', $nav->subNav) }}">{{ $nav->subNav->name ?? 'القائمة الفرعية' }}</a>
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
                    <i class="fas fa-edit mr-2"></i>
                    تعديل الإجراء
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('subNav.update', $nav) }}">
                    @csrf

                    <div class="row mb-3">
                        <!-- الإجراء -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="action" class="form-label">الإجراء</label>
                                <input type="text" name="action" id="action"
                                    class="form-control @error('action') is-invalid @enderror"
                                    value="{{ old('action', $nav->action) }}" placeholder="الإجراء">
                                @error('action')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- المذكرة -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="note" class="form-label">المذكرة</label>
                                <input type="text" name="note" id="note"
                                    class="form-control @error('note') is-invalid @enderror"
                                    value="{{ old('note', $nav->note) }}" placeholder="المذكرة">
                                @error('note')
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
                                    value="{{ old('next_action', $nav->next_action) }}" placeholder="الإجراء التالي">
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
                                    value="{{ old('next_action_date', $nav->next_action_date ? $nav->next_action_date : '') }}">
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
                                            {{ old('user_lawyer_id', $nav->user_lawyer_id) == $lawyer->id ? 'selected' : '' }}>
                                            {{ $lawyer->username }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_lawyer_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- المستخدم المدخل -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="created_at" class="form-label">تاريخ الادخال</label>
                                <input type="date" id="created_at" class="form-control"
                                    value="{{ $nav->created_at->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-save mr-2"></i> تحديث الإجراء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
