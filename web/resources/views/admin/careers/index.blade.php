@extends('layouts.admin')
@section('title', 'الوظائف')
@section('main_title_content', 'قائمة الوظائف')
@section('title_content', 'الوظائف')
@section('link_content')
    <a href="{{ route('careers.index') }}">الوظائف</a>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">الوظائف</h3>
                        <div class="card-tools">
                            <a href="{{ route('careers.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> إضافة وظيفة جديدة
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم بالعربية</th>
                                        <th>الاسم بالإنجليزية</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($careers as $career)
                                        <tr>
                                            <td>{{ $career->id }}</td>
                                            <td>{{ $career->name_ar }}</td>
                                            <td>{{ $career->name_en }}</td>
                                            <td>
                                                @if ($career->active)
                                                    <span class="badge badge-success">نشط</span>
                                                @else
                                                    <span class="badge badge-danger">غير نشط</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('careers.edit', $career->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('careers.destroy', $career->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('هل أنت متأكد من حذف هذه الوظيفة؟')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">لا توجد بيانات</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
