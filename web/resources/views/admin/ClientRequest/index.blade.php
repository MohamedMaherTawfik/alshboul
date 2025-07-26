@extends('layouts.admin')
@section('title', ' طلبات الموكلين ')
@section('main_title_content', ' قائمة طلبات الموكلين ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('request.index') }}"> موكلين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">بيانات طلبات الموكلين
                   	@if(Auth::user()->role=="User")
                  <a href="{{ route('request.create') }}" class="btn btn-success">إضافة جديد</a>
                  @endif
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
                                        @if ($info->is_replied == 1)
                                            <a href="#" data-id="{{ $info->id }}"
                                                data-input="{{ $info->admin_reply }}" data-toggle="modal"
                                                data-target="#update_replay_model"
                                                class="btn btn-warning open-delete-modal">تعديل
                                                الرد</a>
                                        @else
                                            <a href="#" data-id="{{ $info->id }}" data-toggle="modal"
                                                data-target="#replay_model"
                                                class="btn btn-primary open-delete-modal1">رد</a>
                                        @endif

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
    <div class="modal fade" id="replay_model">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-center modal-title"> الرد على الملاحظة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="months_of_year_model_body">
                    <form action="{{ route('request.reply') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="request_id">
                        <div class="form-group col-md-12">
                            <label for=""> الرد</label>
                            <textarea name="admin_reply" class="form-control" cols="30" rows="10"></textarea>
                        </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">رد</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="update_replay_model">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-center modal-title"> تعديل الرد </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="months_of_year_model_body">
                    <form action="{{ route('request.replayModify') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="request_id1">
                        <div class="form-group col-md-12">
                            <label for=""> الرد</label>
                            <textarea name="admin_reply" id="reply" class="form-control" cols="30" rows="10"></textarea>
                        </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-warning">تعديل الرد</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.open-delete-modal').on('click', function() {
                let id = $(this).data('id');
                let reply = $(this).data('input');

                $('#request_id1').val(id);
                $('#reply').val(reply);

            });
            $('.open-delete-modal1').on('click', function() {
                let id = $(this).data('id');
                $('#request_id').val(id);
            });
        });
    </script>
@endsection
