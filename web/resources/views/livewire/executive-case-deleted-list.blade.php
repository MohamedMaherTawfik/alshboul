<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('message') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">قائمة القضايا التنفيذية المحذوفة</h3>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="mb-3 row">
                <div class="col-md-4">
                    <input wire:model.live="search" type="text" class="form-control"
                        placeholder="البحث في القضايا المحذوفة...">
                </div>
                <div class="col-md-3">
                    <select wire:model.live="case_status" class="form-control">
                        <option value="">جميع الحالات</option>
                        <option value="تنفيذية">تنفيذية</option>
                        <option value="منتهية">منتهية</option>
                        <option value="موقوفة">موقوفة</option>
                        <option value="قضية تنفيذية بإنابة">قضية تنفيذية بإنابة</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                @if ($deletedCases->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <tr>
                                <th>رقم الملف المكتبي</th>
                                <th>اسم المشترك</th>
                                <th>اسم الموكل</th>
                                <th>اسم الخصم</th>
                                <th>رقم الدعوى</th>
                                <th>قيمة الدعوى</th>
                                <th>حالة القضية</th>
                                <th>تاريخ التسجيل</th>
                                <th>تاريخ الحذف</th>
                                <th>سبب الحذف</th>
                                <th>التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deletedCases as $case)
                                <tr>
                                    <td>{{ $case->office_file_number ?? 'غير محدد' }}</td>
                                    <td>{{ $case->user->name ?? 'غير محدد' }}</td>
                                    <td>{{ $case->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $case->opponent_name ?? 'غير محدد' }}</td>
                                    <td>{{ $case->lawsuit_number ?? 'غير محدد' }}</td>
                                    <td>{{ $case->claim_value ? number_format($case->claim_value, 2) . ' ريال' : 'غير محدد' }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $case->case_status == 'تنفيذية' ? 'success' : ($case->case_status == 'منتهية' ? 'secondary' : ($case->case_status == 'موقوفة' ? 'warning' : 'info')) }}">
                                            {{ $case->case_status ?? 'غير محدد' }}
                                        </span>
                                    </td>
                                    <td>{{ $case->registration_date ? \Carbon\Carbon::parse($case->registration_date)->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                    <td>{{ $case->deleted_at ? \Carbon\Carbon::parse($case->deleted_at)->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                    <td>{{ $case->delete_reason ?? 'غير محدد' }}</td>
                                    <td>
                                        <button wire:click="restore({{ $case->id }})"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-undo"></i> استرجاع
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center alert alert-info">
                        لا توجد قضايا تنفيذية محذوفة لعرضها.
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
                {{ $deletedCases->links() }}
            </div>
        </div>
    </div>
</div>
