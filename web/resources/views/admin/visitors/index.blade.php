@extends('layouts.admin')
@section('title', ' اراء الزوار')
@section('main_title_content', ' اراء الزوار')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('admin.dashboard') }}"> الصفحة الرئيسية</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center"
            style="background: var(--primary-color); color: #fff;">
            <h5 class="m-0">
                <i class="fas fa-comments me-2"></i> جميع اراء الزوار
            </h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover text-center">
                <thead style="background: #f5f5f5;">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد الالكتروني</th>
                        <th>الرسالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visitors as $index => $visitor)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $visitor->name }}</td>
                            <td>{{ $visitor->email }}</td>
                            <td>{{ $visitor->message }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
