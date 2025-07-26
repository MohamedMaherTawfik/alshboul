@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('casetypes.index') }}">أنواع القضايا</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">بيانات أنواع القضايا
                    <a href="{{ route('casetypes.create') }}" class="btn btn-success">إضافة جديد</a>
                </h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($data) and !@empty($data) and count($data) > 0)
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <th>#</th>
                            <th>الاسم بالعربية</th>
                            <th>الاسم بالإنجليزية</th>
                            <th>الوصف بالعربية</th>
                            <th>الوصف بالإنجليزية</th>
                            <th>الصورة</th>
                            <th>التحكم</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td>{{ $info->name_ar }}</td>
                                    <td>{{ $info->name_en }}</td>
                                    <td>{{ Str::limit($info->description_ar, 50) }}</td>
                                    <td>{{ Str::limit($info->description_en, 50) }}</td>
                                    <td>
                                        @if ($info->image)
                                            <img src="{{ asset($info->image) }}" alt="Case Type Image"
                                                style="max-width: 50px; max-height: 50px;">
                                        @else
                                            لا توجد صورة
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('casetypes.edit', $info->id) }}" class="btn btn-warning">تعديل</a>
                                        <a href="{{ route('casetypes.destroy', $info->id) }}"
                                            class="btn btn-danger ">حذف</a>
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
                    <h4 class="text-center modal-title">حذف البيانات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="months_of_year_model_body">
                    <form action="{{ route('casetypes.destroy', '1') }}" method="post" id="delete_form">
                        @csrf
                        @method('DELETE')
                        <div class="form-group col-md-12">
                            <label for="">سبب الحذف</label>
                            <textarea name="reason" class="form-control" cols="30" rows="10">{{ old('reason') }}</textarea>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-danger">حذف</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // $(document).ready(function() {
        //     $('.open-delete-modal').on('click', function() {
        //         let id = $(this).data('id');
        //         $('#delete_form').attr('action', "{{ route('casetypes.destroy', '+id+') }}" );
        //     });
        // });
    </script>
@endsection
