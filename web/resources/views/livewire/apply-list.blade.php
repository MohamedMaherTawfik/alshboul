@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

<div class="overflow-auto card-body">



    <div class="row">
        <div class="form-group col-md-3">
            <label for="">اسم الوظيفة </label>
            <select class=" form-control select2" wire:model.live='selectedJob'>
                <option value="">-- اختر الوظيفة --</option>
                @foreach ($jobs as $job)
                    <option value="{{ $job->id }}">{{ $job->name_ar }}</option>
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
            <label for="">اسم المتقدم </label>
            <input wire:model.live="search" placeholder="ابحث عن  اسم المتقدم" class=" form-control">
        </div>
    </div>

    {{-- @if ($selectedClient)
        <livewire:client-action :clientId="$selectedClient" :key="'client-action-' . $selectedClient" />
    @else --}}
    @if (@isset($data) and !@empty($data) and count($data) > 0)
        <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
                <tr>
                    <th class="p-2 border"> اسم المتقدم</th>
                    <th class="p-2 border">اسم الوظيفة </th>
                    <th class="p-2 border">تاريخ الميلاد</th>
                    <th class="p-2 border">الهاتف</th>
                    <th class="p-2 border">السيرة الذاتية</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($data as $job)
                    <tr>
                        {{--  wire:click="loadActivity({{ $item->id }})" --}}
                        <td class="p-2 border">{{ $job->full_name }}</td>
                        <td class="p-2 border">{{ $job->career->name_ar }}</td>
                        <td class="p-2 border">{{ $job->brith_date }}</td>
                        <td class="p-2 border">{{ $job->phone }}</td>
                        <td class="p-2 border">
                            @if ($job->cv_file)
                                <a href="{{ Storage::url('cv_files/' . $job->cv_file) }}" target="_blank"
                                    class="text-[#D4AF37] hover:text-[#011627]">
                                    عرض الملف
                                </a>
                            @endif

                        </td>
                        {{-- <td class="p-2 border">{{ $action->entity }}</td>
                        <td class="p-2 border">{{ $action->addedby?->username }}</td>
                        <td class="p-2 border">{{ $action->updateby?->username ?? '-' }}</td>
                        <td>

                            <button wire:click="loadActivity({{ $action->id }})" class="btn btn-warning">
                                تعديل
                            </button>


                            <a href="#" data-id="{{ $action->id }}" data-toggle="modal"
                                data-target="#delete_reason" class="btn btn-danger open-delete-modal">حذف</a>
                        </td>
                        <td>
                            <button wire:click="loadActivity1({{ $action->id }})" class="btn btn-primary">
                                عرض الاجراءات الفرعية
                            </button>

                            <button wire:click="loadActivity2({{ $action->id }})" class="btn btn-primary">
                                اضافة جراء فرعي
                            </button>
                        </td> --}}
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
    {{-- @endif --}}
    {{-- update --}}

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
