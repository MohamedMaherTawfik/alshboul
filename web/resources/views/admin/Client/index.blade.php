@extends('layouts.admin')
@section('title', 'الموكلين ')
@section('main_title_content', ' قائمة الموكلين ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('client.index') }}"> موكلين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">بيانات الموكلين
                    <a href="{{ route('client.create') }}" class="btn btn-success">إضافة جديد</a>
                </h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($data) and !@empty($data) and count($data) > 0)
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">

                            <th> رقم الموكل</th>
                            <th>اسم الموكل</th>
                            <th> العنوان </th>
                            <th>هاتف </th>
                            <th>الحالة</th>
                            <th>اضافة بواسطة</th>
                            <th>تعديل بواسطة</th>
                            <th>تاريخ التسجيل</th>
                            <th>التحكم</th>

                        </thead>
                        <tbody>

                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td>{{ $info->name }}</td>
                                    <td>{{ $info->address }}</td>
                                    <td>{{ $info->phone }}</td>
                                    <td>
                                        @if ($info->user->active == 1)
                                            مفعل
                                        @else
                                            معطل
                                        @endif
                                    </td>
                                    <td>{{ $info->addedby->username }}</td>
                                    <td>
                                        @if (@isset($info->updateby->username))
                                            {{ $info->updateby->username }}
                                        @else
                                            لم يتم التعديل
                                        @endif
                                    </td>
                                    <td>{{ $info->user->date }}</td>
                                    <td>
                                        <a href="{{ route('client.edit', $info->id) }}" class="btn btn-warning">تعديل</a>
                                        <a href="#" data-id="{{ $info->id }}" data-toggle="modal"
                                            data-target="#delete_reason" class="btn btn-danger open-delete-modal">حذف</a>
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
    <div class="modal fade" id="delete_reason">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-center modal-title"> حذف البيانات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="months_of_year_model_body">
                    <form action="{{ route('client.delete') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" id="delete_id">
                        <div class="form-group col-md-12">
                            <label for=""> سبب الحذف </label>
                            <textarea name="reason" class="form-control" cols="30" rows="10">{{ old('reason') }}</textarea>
                        </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-danger">حذف</button>
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
                $('#delete_id').val(id);
            });
        });
    </script>
@endsection
