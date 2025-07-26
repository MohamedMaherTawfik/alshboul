@extends('layouts.admin')
@section('title', 'المحامين ')
@section('main_title_content', ' قائمة المحامين ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('lawyer.index') }}"> محامين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">بيانات المحامين المحذوفين
                </h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($data) and !@empty($data) and count($data) > 0)
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">

                            <th> رقم </th>
                            <th>اسم </th>
                            <th>هاتف </th>
                            <th>سبب الحذف</th>
                            <th>الحذف بواسطة</th>
                            <th>تاريخ الحذف</th>
                            <th>التحكم</th>

                        </thead>
                        <tbody>

                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td>{{ $info->name }}</td>
                                    <td>{{ $info->phone }}</td>
                                    <td>
                                        {{ $info->delete_reason }}
                                    <td>
                                        @if (@isset($info->updateby->username))
                                            {{ $info->updateby->username }}
                                        @else
                                            لم يتم التعديل
                                        @endif
                                    </td>
                                    <td>{{ $info->deleted_at }}</td>
                                    <td>
                                        <a href="{{ route('lawyer.restore', $info->id) }}"
                                            class="btn btn-warning">استرجاع</a>
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
                            <input type="text" name="reason" value="{{ old('reason') }}" class="form-control"
                                placeholder="">
                            @error('reason')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
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
