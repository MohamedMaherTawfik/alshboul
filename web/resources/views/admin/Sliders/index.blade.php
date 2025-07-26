@extends('layouts.admin')
@section('title', 'السلايدر')
@section('main_title_content', 'قائمة السلايدر')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('sliders.index') }}">السلايدر</a>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">السلايدر</h3>
                    <div class="card-tools">
                        <a href="{{ route('sliders.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> إضافة جديد
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (@isset($data) and !@empty($data) and count($data) > 0)
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($data as $info)
                                    <tr>
                                        <td>{{ $info->id }}</td>
                                        <td>
                                            <img src="{{ asset($info->image) }}" alt="Slider Image" style="max-width: 100px; max-height: 100px;">
                                        </td>
                                        <td>
                                            <a href="{{ route('sliders.edit', $info->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                            <a href="{{ route('sliders.destroy', $info->id) }}" class="btn btn-danger btn-sm"
                                       onclick="event.preventDefault(); if(confirm('هل أنت متأكد من حذف هذا العنصر؟')) ">
                                        <i class="fas fa-trash"></i> حذف</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">لا توجد بيانات</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection 