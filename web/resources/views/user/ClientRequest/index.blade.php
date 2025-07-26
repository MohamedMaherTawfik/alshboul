@extends('layouts.user')
@section('title', ' طلبات الموكلين ')
@section('main_title_content', ' قائمة طلبات الموكلين ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('user.request.index') }}"> موكلين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">بيانات طلبات الموكلين
                    <a href="{{ route('user.request.create') }}" class="btn btn-success">إضافة جديد</a>
                </h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($data) and !@empty($data) and count($data) > 0)
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">

                            <th> رقم الطلب</th>
                            <th>اسم الموكل</th>
                            <th>اسم المستخدم</th>
                            <th>عنوان الطلب </th>
                            <th> الرد</th>
                            <th>الرد بواسطة</th>
                            <th>تاريخ </th>
                            <th>التحكم</th>

                        </thead>
                        <tbody>

                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td>{{ $info->addedby->client->name }}</td>
                                    <td>{{ $info->addedby->username }}</td>
                                    <td>{{ $info->title }}</td>

                                    <td>
                                        @if ($info->is_replied == 1)
                                            {{ $info->admin_reply }}
                                        @else
                                            لا يوجد رد
                                        @endif
                                    </td>
                                    <td>
                                        @if (@isset($info->repliedby))
                                            {{ $info->repliedby->username }}
                                        @else
                                            لم يتم التعديل
                                        @endif
                                    </td>
                                    <td>{{ $info->created_at }}</td>
                                    <td>
                                        {{-- @if ($info->is_replied == 1)
                                            <a href="#" data-id="{{ $info->id }}"
                                                data-input="{{ $info->admin_reply }}" data-toggle="modal"
                                                data-target="#update_replay_model"
                                                class="btn btn-warning open-delete-modal">تعديل
                                                الرد</a>
                                        @else
                                            <a href="#" data-id="{{ $info->id }}" data-toggle="modal"
                                                data-target="#replay_model"
                                                class="btn btn-primary open-delete-modal1">رد</a>
                                        @endif --}}

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="text-center bg-danger">لا يوجد بيانات للنظام</p>
                @endif
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>
\
    </script>
@endsection
