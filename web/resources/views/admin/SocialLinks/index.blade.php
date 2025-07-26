@extends('layouts.admin')
@section('title', 'روابط التواصل الاجتماعي')
@section('main_title_content', 'روابط التواصل الاجتماعي')
@section('title_content', 'عرض')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">روابط التواصل الاجتماعي</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>القيمة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>فيسبوك</td>
                                <td>{{ $data->facebook ?? 'غير محدد' }}</td>
                            </tr>
                            <tr>
                                <td>تويتر</td>
                                <td>{{ $data->x ?? 'غير محدد' }}</td>
                            </tr>
                            <tr>
                                <td>انستجرام</td>
                                <td>{{ $data->instagram ?? 'غير محدد' }}</td>
                            </tr>
                            <tr>
                                <td>واتساب</td>
                                <td>{{ $data->whatsapp ?? 'غير محدد' }}</td>
                            </tr>
                            <tr>
                                <td>البريد الإلكتروني</td>
                                <td>{{ $data->email ?? 'غير محدد' }}</td>
                            </tr>
                            <tr>
                                <td>رقم المكتب</td>
                                <td>{{ $data->phone ?? 'غير محدد' }}</td>
                            </tr>
                            <tr>
                                <td>رقم الهاتف الخاص</td>
                                <td>{{ $data->phone_spical ?? 'غير محدد' }}</td>
                            </tr>
                            <tr>
                                <td>رقم تليفاكس</td>
                                <td>{{ $data->fax ?? 'غير محدد' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('sociallinks.edit') }}" class="btn btn-warning">تعديل</a>
                </div>
            </div>
        </div>
    </div>
@endsection
