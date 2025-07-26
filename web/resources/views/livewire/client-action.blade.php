@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
<div class="p-4 mt-6 bg-white rounded shadow">

    <div class="row">
        <div class="form-group col-md-4">
            <input type="text" wire:model.live="searchMain" placeholder="بحث عن عنوان الإجراء الرئيسي..."
                class="form-control" />
        </div>

        <div class="form-group col-md-4">
            <input type="text" wire:model.live="searchSub" placeholder="بحث عن تفاصيل الإجراء الفرعي..."
                class="form-control" />
        </div>
    </div>

    <h4 class="mb-2 text-lg font-bold">الإجراءات الرئيسية</h4>
    <table id="example2" class="table table-bordered table-hover">
        <thead class="custom_thead">
            <tr>
                <th class="p-2 border">تاريخ الإجراء</th>
                <th class="p-2 border">ملاحظات</th>
                <th class="p-2 border">عنوان الإجراء</th>
                <th class="p-2 border">الجهة</th>
                <th class="p-2 border">أُضيف بواسطة</th>
                <th class="p-2 border">عُدّل بواسطة</th>
                <th class="p-2 border"> التحكم</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($mainActions as $action)
                <tr>
                    <td class="p-2 border">{{ $action->action_date }}</td>
                    <td class="p-2 border">{{ $action->notes }}</td>
                    <td class="p-2 border">{{ $action->title }}</td>
                    <td class="p-2 border">{{ $action->entity }}</td>
                    <td class="p-2 border">{{ $action->addedby?->username }}</td>
                    <td class="p-2 border">{{ $action->updateby?->username ?? '-' }}</td>
                    <td>
                        <button wire:click="loadActivity1({{ $action->id }})" class="btn btn-warning">
                            تعديل
                        </button>
                        <a href="#" data-id="{{ $action->id }}" data-toggle="modal"
                            data-target="#delete_reason1" class="btn btn-danger open-delete-modal">حذف</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="delete_reason1">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-center modal-title"> حذف البيانات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="months_of_year_model_body">
                    <form action="{{ route('client.action.delete') }}" method="post">
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

        </div>

    </div>
</div>
@section('script')
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

        });
    </script>
@endsection
