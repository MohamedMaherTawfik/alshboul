@extends('layouts.admin')
@section('title', 'الاتفاقيات')
@section('main_title_content', 'قائمة الاتفاقيات')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('agreement.index') }}">اتفاقيات</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">بيانات الاتفاقيات
                    <a href="{{ route('agreement.create') }}" class="btn btn-success">إضافة جديد</a>
                </h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($data) and !@empty($data) and count($data) > 0)
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <th>رقم الاتفاقية</th>
                            <th>الطرف الأول</th>
                            <th>الطرف الثاني</th>
                            <th>تاريخ الاتفاقية</th>
                            <th>الموضوع</th>
                            <th>المبلغ</th>
                            <th>نوع الاتفاقية</th>
                            <th>عدد الأقساط</th>
                            <th>تمثيل بواسطة</th>
                            <th>إضافة بواسطة</th>
                            <th>تعديل بواسطة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>التحكم</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->agreement_number }}</td>
                                    <td>{{ $info->firstParty->name }}</td>
                                    <td>{{ $info->second_party }}</td>
                                    <td>{{ $info->agreement_date }}</td>
                                    <td>{{ $info->subject ?? 'غير محدد' }}</td>
                                    <td>{{ $info->amount ? number_format($info->amount, 2) . ' دينار' : 'غير محدد' }}</td>
                                    <td>
                                        @if ($info->agreement_type == 'public')
                                            عامة
                                        @elseif($info->agreement_type == 'private')
                                            خاصة
                                        @else
                                            غير محدد
                                        @endif
                                    </td>
                                    <td>{{ $info->installments_count }}</td>
                                    <td>{{ $info->representor->username ?? 'غير محدد' }}</td>
                                    <td>{{ $info->creator->username ?? 'غير محدد' }}</td>
                                    <td>
                                        @if (@isset($info->updater->username))
                                            {{ $info->updater->username }}
                                        @else
                                            لم يتم التعديل
                                        @endif
                                    </td>
                                    <td>{{ $info->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('agreement.show', $info->id) }}" class="btn btn-info">عرض</a>
                                        <a href="{{ route('agreement.edit', $info->id) }}"
                                            class="btn btn-warning">تعديل</a>
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
                    <h4 class="text-center modal-title">حذف البيانات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="months_of_year_model_body">
                    <form action="{{ route('agreement.delete') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" id="delete_id">
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
