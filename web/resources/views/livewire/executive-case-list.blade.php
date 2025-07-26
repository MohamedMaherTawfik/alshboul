<div>


    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> عدد القضايا التنفيذية @if ($case_id == 1)
                    فعالة
                @elseif ($case_id ==3)
                    موقوفة
                @elseif ($case_id == 2)
                    منتهية
                @else
                    انابات
                @endif


                <span class="badge badge-info">{{ $executiveCases->count() }}</span>
                <br>
                <a href="{{ route('executive-case.create', $case_id) }}" class="btn btn-success">إضافة جديد</a>
            </h3>
        </div>

        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="mb-3 row">
                <div class="col-md-4">
                    <input wire:model.live="subscriber_name" type="text" class="form-control"
                        placeholder="بحث إسم المشترك">
                </div>
                <div class="col-md-4">
                    <input wire:model.live="client_id" type="text" class="form-control" placeholder="بحث إسم الموكل">
                </div>
                <div class="col-md-4">
                    <input wire:model.live="lawsuit_number" type="text" class="form-control"
                        placeholder=" بحث رقم الدعوى">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-4">
                    <input wire:model.live="execution_department" type="text" class="form-control"
                        placeholder=" بحث دائرة التنفيذ">
                </div>
                <div class="col-md-4">
                    <input wire:model.live="judged_for" type="text" class="form-control"
                        placeholder=" بحث المحكوم له">
                </div>
                <div class="col-md-4">
                    <input wire:model.live="judged_against" type="text" class="form-control"
                        placeholder="بحث المحكوم عليه">
                </div>
            </div>



            <!-- Table -->
            <div class="table-responsive">
                @if ($executiveCases->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <tr>
                                <th>رقم الملف المكتبي</th>
                                <th>اسم المشترك</th>
                                <th>اسم الموكل</th>
                                <th> اسم الخصم</th>
                                <th>الرقم الوطني للموكل</th>
                                <th>الرقم الوطني للخصم</th>
                                <th>رقم الدعوى</th>
                                <th>قيمة الدعوى</th>
                                <th>دائرة التنفيذ</th>
                                <th>تاريخ أخر حدث</th>
                                <th>أخر اجراء </th>
                                <th>التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($executiveCases as $case)
                                <tr>
                                    <td>{{ $case->office_file_number ?? 'غير محدد' }}</td>
                                    <td>{{ $case->user->name ?? 'غير محدد' }}</td>
                                    <td>{{ $case->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $case->opponent_name ?? 'غير محدد' }}</td>
                                    <td>{{ $case->client_national_id ?? 'غير محدد' }}</td>
                                    <td>{{ $case->opponent_national_id ?? 'غير محدد' }}</td>
                                    <td> {{ $case->lawsuit_number ?? 'غير محدد' }}</td>
                                    <td>{{ $case->claim_value ? number_format($case->claim_value, 2) . ' دينار' : 'غير محدد' }}
                                    </td>
                                    <td>{{ $case->execution_department ?? 'غير محدد' }}</td>

                                    {{-- <td>
                                        <span
                                            class="badge badge-{{ $case->case_status == 'تنفيذية' ? 'success' : ($case->case_status == 'منتهية' ? 'secondary' : ($case->case_status == 'موقوفة' ? 'warning' : 'info')) }}">
                                            {{ $case->case_status ?? 'غير محدد' }}
                                        </span>
                                    </td> --}}
                                    <td>{{ $case->updated_at ? \Carbon\Carbon::parse($case->updated_at)->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                    <td>
                                        @if ($case->proceduralRecords->count() > 0)
                                            <span class="badge badge-secondary">
                                                {{ $case->proceduralRecords->last()->action ?? 'لا يوجد اجراء' }}
                                            </span>
                                        @else
                                            <span class="badge badge-warning">لا يوجد اجراء</span>
                                        @endif
                                    </td>
                                    <td>

                                        <a href="{{ route('executive-case.edit', $case->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> تعديل
                                        </a>
                                        <a href="{{ route('procedural-record.index', $case->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-file"></i>جلسة إجرائية
                                        </a>
                                        <button wire:click="confirmDelete({{ $case->id }})"
                                            class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center alert alert-info">
                        لا توجد قضايا تنفيذية لعرضها.
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
                {{ $executiveCases->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    @if ($showDeleteModal)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تأكيد الحذف</h5>
                        <button type="button" class="close" wire:click="cancelDelete">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>هل أنت متأكد من حذف هذه القضية التنفيذية؟</p>
                        <div class="form-group">
                            <label for="delete_reason">سبب الحذف:</label>
                            <textarea wire:model="deleteReason" class="form-control" rows="3" placeholder="يرجى كتابة سبب الحذف"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelDelete">إلغاء</button>
                        <button type="button" class="btn btn-danger" wire:click="delete">حذف</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
