@extends('layouts.admin')
@section('title', 'شريط التحرك')
@section('main_title_content', 'قائمة شريط التحرك')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('move-bars.index') }}">شريط التحرك</a>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">شريط التحرك</h3>
                    <div class="card-tools">
                        <a href="{{ route('move-bars.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> إضافة جديد
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (@isset($moveBars) and !@empty($moveBars) and count($moveBars) > 0)
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>النص</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($moveBars as $moveBar)
                            <tr>
                                <td>{{ $moveBar->id }}</td>
                                <td>{{ $moveBar->text }}</td>
                                <td>
                                    @if($moveBar->active)
                                        <span class="badge badge-success">نشط</span>
                                    @else
                                        <span class="badge badge-danger">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('move-bars.edit', $moveBar->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    <a href="{{ route('move-bars.destroy', $moveBar->id) }}" 
                                       class="btn btn-danger btn-sm"
                                       onclick="event.preventDefault(); if(confirm('هل أنت متأكد من حذف هذا العنصر؟')) { document.getElementById('delete-form-{{ $moveBar->id }}').submit(); }">
                                        <i class="fas fa-trash"></i> حذف
                                    </a>
                                    <form id="delete-form-{{ $moveBar->id }}" 
                                          action="{{ route('move-bars.destroy', $moveBar->id) }}" 
                                          method="POST" 
                                          style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
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
</div>
@endsection 