@extends('layouts.admin')
@section('title', 'الاتفاقيات المحذوفة')
@section('main_title_content', 'قائمة الاتفاقيات المحذوفة')
@section('title_content', 'عرض المحذوفة')
@section('link_content')
    <a href="{{ route('agreement.index') }}">اتفاقيات</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">الاتفاقيات المحذوفة</h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($data) and !@empty($data) and count($data) > 0)
                    <table class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <th>رقم الاتفاقية</th>
                            <th>الطرف الأول</th>
                            <th>الطرف الثاني</th>
                            <th>تاريخ الاتفاقية</th>
                            <th>سبب الحذف</th>
                            <th>تعديل بواسطة</th>
                            <th>التحكم</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->agreement_number }}</td>
                                    <td>{{ $info->firstParty->name }}</td>
                                    <td>{{ $info->second_party }}</td>
                                    <td>{{ $info->agreement_date }}</td>
                                    <td>{{ $info->delete_reason ?? 'غير محدد' }}</td>
                                    <td>{{ $info->updater->username ?? 'غير محدد' }}</td>
                                    <td>
                                        <a href="{{ route('agreement.restore', $info->id) }}"
                                            class="btn btn-success">استرجاع</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="col-md-12">
                        <div class="text-center alert alert-info">
                            لا توجد بيانات لعرضها.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
