@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

<div class="overflow-auto card-body">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-tasks"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد الاجراءات الرئيسية </span>
                    <span class="info-box-number">
                        {{ count($mainActions1) }}
                        <small></small>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-clipboard-list"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد الاجراءات الفرعية </span>
                    <span class="info-box-number">
                        {{ $sub_count }}
                        <small></small>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>


    <div class="row">
        <div class="form-group col-md-3">
            <label for="">اسم الموكل </label>
            <select class=" form-control" wire:model.live="selectedClient">
                <option value="">-- اختر موكل --</option>
                @foreach ($data as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for=""> حسب الأحدث/أقدم</label>
            <select wire:model.live="sortOrder" class="form-control">
                <option value="desc">الأحدث</option>
                <option value="asc">الأقدم</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="">عنوان الإجراء</label>
            <input wire:model.live="search" placeholder="ابحث عن عنوان الاجراء" class=" form-control">
        </div>
    </div>

 
        @if (@isset($mainActions1) and !@empty($mainActions1) and count($mainActions1) > 0)
            <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">
                    <tr>
                        <th class="p-2 border"> اسم الموكل</th>
                        <th class="p-2 border">تاريخ الإجراء</th>
                        <th class="p-2 border">ملاحظات</th>
                        <th class="p-2 border">عنوان الإجراء</th>
                        <th class="p-2 border">الجهة</th>
                      <th class="p-2 border">عدد الاجراءات الفرعية</th>
                        <th class="p-2 border">أُضيف بواسطة</th>
                        <th class="p-2 border">عُدّل بواسطة</th>
                        <th class="p-2 border" colspan="2">التحكم </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mainActions1 as $action)
                        <tr>
                            {{--  wire:click="loadActivity({{ $item->id }})" --}}
                            <td class="p-2 border">{{ $action->client->name }}</td>
                            <td class="p-2 border">{{ $action->action_date }}</td>
                            <td class="p-2 border">{{ $action->notes }}</td>
                            <td class="p-2 border">{{ $action->title }}</td>
                            <td class="p-2 border">{{ $action->entity }}</td>
                          <td class="p-2 border">{{ count($action->subActions) }}</td>
                         
                            <td class="p-2 border">{{ $action->addedby?->username }}</td>
                            <td class="p-2 border">{{ $action->updateby?->username ?? '-' }}</td>
                            <td>

                                <button wire:click="loadActivity({{ $action->id }})" class="btn btn-warning mb-1">
                                    تعديل
                                </button>


                                <a href="#" data-id="{{ $action->id }}" data-toggle="modal"
                                    data-target="#delete_reason" class="btn btn-danger open-delete-modal">حذف</a>
                            </td>
                            <td> 
                              @if(count($action->subActions)>0)
                               <button wire:click="loadActivity1({{ $action->id }})" class="btn btn-info mb-1">
                                عرض الاجراءات الفرعية
                            </button>
							@endif
                              <button wire:click="loadActivity2({{ $action->id }})" class="btn btn-primary">
                                    اضافة إجراء فرعي
                                </button>
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
   
  
  <div class="modal fade" id="show_sub">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-center modal-title"> الاجراءات الفرعية </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="months_of_year_model_body">

                    @if (@isset($sub) and !@empty($sub) and count($sub) > 0)
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <tr>
                                    <th class="p-2 border"> التفاصيل</th>
                                    <th class="p-2 border">تاريخ الاجراء</th>
                                    <th class="p-2 border">تاريخ الاجراء اللاحق</th>
                                    <th class="p-2 border"> المنفذ</th>
                                    <th class="p-2 border">الحالة</th>
                                    <th class="p-2 border">أُضيف بواسطة</th>
                                    <th class="p-2 border">عُدّل بواسطة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sub as $action)
                                    <tr>
                                        {{--  wire:click="loadActivity({{ $item->id }})" --}}
                                        <td class="p-2 border">{{ $action->details }}</td>
                                        <td class="p-2 border">{{ $action->action_date }}</td>
                                        <td class="p-2 border">{{ $action->next_action_date }}</td>
                                        <td class="p-2 border">{{ $action->executor->username }}</td>
                                        <td class="p-2 border">{{$action->status? "مكتمل":"غير مكتمل"}}</td>
                                        <td class="p-2 border">{{ $action->addedby?->username }}</td>
                                        <td class="p-2 border">{{ $action->updateby?->username ?? '-' }}</td>

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
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">إغلاق</button>
                </div>

            </div>

        </div>

    </div>
    {{-- update --}}
    <div class="modal fade" id="updateAction" tabindex="-1" role="dialog" aria-labelledby="addActionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg {{ $show ? 'relative' : 'hidden' }}" role="document">
            <form method="POST" action="{{ route('client.action.update', $id ?? 0) }}">
                @csrf


                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="copyModalLabel">تعديل اجراء </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="client_id"> الموكل </label>
                                <select class="text-left form-control select2" wire:model='client_id'
                                    style="direction: ltr; text-align: left;" name="client_id" id="client_id">
                                    <option> اختر الموكل</option>
                                    @foreach ($data as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="title"> عنوان الاجراء </label>
                                <input type="text" wire:model='title' name="title" id="title"
                                    class="form-control" placeholder="إدخل عنوان الاجراء" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="type"> نوع الاجراء </label>
                                <input type="text" wire:model='type' placeholder="إدخل نوع الاجراء  "
                                    name="type" id="type" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="entity"> الجهة </label>
                                <input type="text" wire:model='entity' placeholder="إدخل نوع الاجراء  "
                                    name="entity" id="entity" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="action_date"> تاريخ الاجراء</label>
                                <input type="date" wire:model='action_date' placeholder=" تاريخ الاجراء  "
                                    value="{{ date('Y-m-d') }}" name="action_date" id="action_date"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="status"> الحالة </label>
                                <select class="text-left form-control " wire:model='status'
                                    style="direction: ltr; text-align: left;" name="status" id="status"
                                    onchange="toggleEndDate()">
                                    <option> اختر الحالة </option>
                                    <option value="0"> غير مكتمل </option>
                                    <option value="1"> مكتمل </option>

                                </select>
                            </div>

                            <div class="form-group col-md-4" id="endDateGroup" style="display: none;">
                                <label for="end_date"> تاريخ أكمال الاجراء </label>
                                <input type="date" wire:model='end_date' placeholder="إدخل تاريخ الانتهاء"
                                    name="end_date" id="end_date" class="form-control" onchange="checkDeadline()">

                            </div>


                            <div class="form-group col-md-8">
                                <label for="notes"> ملاحظات</label>
                                <textarea name="notes" wire:model='notes' id="notes" class="form-control"></textarea>
                            </div>
                            <small id="deadlineWarning" class="mt-1 text-danger" style="display: none;">
                                ⚠️ يجب إكمال الإجراء قبل الموعد المحدد!
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-warning">تعديل</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Add --}}
    <div class="modal fade" id="addAction" tabindex="-1" role="dialog" aria-labelledby="addActionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('client.action.store') }}">
                @csrf


                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="copyModalLabel">اضافة اجراء </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="client_id"> الموكل </label>
                                <select class="text-left form-control select2"
                                    style="direction: ltr; text-align: left;" name="client_id" id="client_id">
                                    <option> اختر الموكل</option>
                                    @foreach ($data as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="title"> عنوان الاجراء </label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="إدخل عنوان الاجراء" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="type"> نوع الاجراء </label>
                                <input type="text" placeholder="إدخل نوع الاجراء  " name="type" id="type"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="entity"> الجهة </label>
                                <input type="text" placeholder="إدخل نوع الاجراء  " name="entity" id="entity"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="action_date"> تاريخ الاجراء</label>
                                <input type="date" placeholder=" تاريخ الاجراء  " value="{{ date('Y-m-d') }}"
                                    name="action_date" id="action_date" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="status"> الحالة </label>
                                <select class="text-left form-control " style="direction: ltr; text-align: left;"
                                    name="status" id="status1" onchange="toggleEndDate1()">
                                    <option> اختر الحالة </option>
                                    <option value="0"> غير مكتمل </option>
                                    <option value="1"> مكتمل </option>

                                </select>
                            </div>

                            <div class="form-group col-md-4" id="endDateGroup1" style="display: none;">
                                <label for="end_date"> تاريخ أكمال الاجراء </label>
                                <input type="date" placeholder="إدخل تاريخ الانتهاء" name="end_date"
                                    id="end_date1" class="form-control" onchange="checkDeadline1()">

                            </div>


                            <div class="form-group col-md-8">
                                <label for="notes"> ملاحظات</label>
                                <textarea name="notes" id="notes" class="form-control"></textarea>
                            </div>
                            <small id="deadlineWarning1" class="mt-1 text-danger" style="display: none;">
                                ⚠️ يجب إكمال الإجراء قبل الموعد المحدد!
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Add Sub action --}}
    <div class="modal fade" id="addSubAction" tabindex="-1" role="dialog" aria-labelledby="addActionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('client.subaction.store') }}">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="copyModalLabel">اضافة اجراء فرعي </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="details"> تفاصيل الإجراء</label>
                                <textarea name="details" id="details" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="action_date"> تاريخ الاجراء</label>
                                <input type="date" placeholder=" تاريخ الاجراء  " value="{{ date('Y-m-d') }}"
                                    name="action_date" id="action_date" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="next_action_date"> تاريخ الاجراء اللاحق -اختياري</label>
                                <input type="date" placeholder=" تاريخ الاجراء  " value="{{ date('Y-m-d') }}"
                                    name="next_action_date" id="next_action_date" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="executed_by"> المنفذ </label>
                                <select class="text-left form-control select2"
                                    style="direction: ltr; text-align: left;" name="executed_by" id="executed_by">
                                    <option> اختر المنفذ</option>
                                    @foreach ($data as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['name'] }} -
                                            {{ $item->role == 'Lawyer' ? 'محامي' : 'ادمن' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="status"> الحالة </label>
                                <select class="text-left form-control " style="direction: ltr; text-align: left;"
                                    name="status" id="status">
                                    <option> اختر الحالة </option>
                                    <option value="0"> غير مكتمل </option>
                                    <option value="1"> مكتمل </option>

                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Delete --}}
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
   window.addEventListener('show-update-modal', event => {
            $('#updateAction').modal('show');
        });
        window.addEventListener('show-update1-modal', event => {
            $('#addSubAction').modal('show');
        });
 window.addEventListener('show-sub-modal', event => {
            $('#show_sub').modal('show');
        });
        function toggleEndDate() {
            const status = document.getElementById('status').value;
            const endDateGroup = document.getElementById('endDateGroup');

            if (status == '0') {
                endDateGroup.style.display = 'block';
            } else {
                endDateGroup.style.display = 'none';
                document.getElementById('deadlineWarning').style.display = 'none';
            }
        }

        function checkDeadline() {
            const endDate = new Date(document.getElementById('end_date').value);
            const today = new Date();
            const warning = document.getElementById('deadlineWarning');

            // إذا كان التاريخ بعد اليوم بأقل من 3 أيام أنبهه
            const timeDiff = (endDate - today) / (1000 * 60 * 60 * 24); // فرق بالأيام

            if (timeDiff <= 30 && timeDiff >= 0) {
                warning.style.display = 'block';
            } else {
                warning.style.display = 'none';
            }
        }

        function toggleEndDate1() {
            const status = document.getElementById('status1').value;
            const endDateGroup = document.getElementById('endDateGroup1');

            if (status == '0') {
                endDateGroup.style.display = 'block';
            } else {
                endDateGroup.style.display = 'none';
                document.getElementById('deadlineWarning1').style.display = 'none';
            }
        }

        function checkDeadline1() {
            const endDate = new Date(document.getElementById('end_date1').value);
            const today = new Date();
            const warning = document.getElementById('deadlineWarning1');

            // إذا كان التاريخ بعد اليوم بأقل من 3 أيام أنبهه
            const timeDiff = (endDate - today) / (1000 * 60 * 60 * 24); // فرق بالأيام

            if (timeDiff <= 30 && timeDiff >= 0) {
                warning.style.display = 'block';
            } else {
                warning.style.display = 'none';
            }
        }
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

        });
    </script>
@endsection
