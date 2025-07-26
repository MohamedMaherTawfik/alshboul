<div>
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">
                @if ($executiveCase)
                    السجلات الإجرائية - للقضية {{ $executiveCase->id ?? 'غير محدد' }}
                @else
                    السجلات الإجرائية
                @endif
                <a href="{{ route('procedural-record.create', $case_id) }}" class="btn btn-success">إضافة جديد</a>
                @if ($case_id)
                    <a href="#" class="btn btn-secondary">العودة للقضايا</a>
                @endif
            </h3>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title card_title_center">معلومات القضية</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>اسم المشترك:</strong>
                                {{ $executiveCase->user->name ?? 'غير محدد' }}</p>
                            <p><strong>اسم الموكل:</strong> {{ $executiveCase->client->name ?? 'غير محدد' }}
                            </p>
                            <p><strong>رقم الملف المكتبي:</strong>
                                {{ $executiveCase->office_file_number ?? 'غير محدد' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>رقم الدعوى:</strong> {{ $executiveCase->lawsuit_number ?? 'غير محدد' }}
                            </p>
                            <p><strong>حالة القضية:</strong>
                                <span
                                    class="badge badge-{{ $executiveCase->case_status == 'تنفيذية' ? 'success' : ($executiveCase->case_status == 'منتهية' ? 'secondary' : ($executiveCase->case_status == 'موقوفة' ? 'warning' : 'info')) }}">
                                    {{ $executiveCase->case_status ?? 'غير محدد' }}
                                </span>
                            </p>
                            <p><strong>قيمة الدعوى:</strong>
                                {{ $executiveCase->claim_value ? number_format($executiveCase->claim_value, 2) . ' دينار' : 'غير محدد' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="mb-3 row">
                <div class="col-md-3">
                    <input wire:model.live="search" type="text" class="form-control"
                        placeholder="البحث في السجلات...">
                </div>
                <div class="col-md-2">
                    <select wire:model.live="type" class="form-control">
                        <option value="">جميع الأنواع</option>
                        <option value="إجراء">إجراء</option>
                        <option value="جلسة">جلسة</option>
                        <option value="مذكرة">مذكرة</option>
                        <option value="قرار">قرار</option>

                    </select>
                </div>

            </div>

            <!-- Table -->
            <div class="table-responsive">
                @if ($proceduralRecords->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <tr>
                                <th>إنشاء بواسطة</th>
                                <th>تاريخ الإنشاء</th>
                                <th>تاريخ الجلسة</th>
                                <th>النوع</th>
                                <th>الإجراء</th>
                                <th>المحامي</th>
                                <th>الملاحظات</th>
                                <th>الإجراء اللاحق</th>
                                <th>تاريخ الإجراء اللاحق</th>
                                <th>الملفات</th>
                                <th>التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proceduralRecords as $record)
                                <tr>
                                    <td>{{ $record->creator->name ?? 'غير محدد' }}</td>
                                    <td>{{ $record->created_at ? \Carbon\Carbon::parse($record->created_at)->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                    <td>{{ $record->session_date ? \Carbon\Carbon::parse($record->session_date)->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                    <td>{{ $record->type ?? 'غير محدد' }}</td>
                                    <td>{{ $record->action ?? 'غير محدد' }}</td>
                                    <td>{{ $record->lawyer ?? 'غير محدد' }}</td>
                                    <td>
                                        @if ($record->notes)
                                            <span class="text-truncate d-inline-block" style="max-width: 150px;"
                                                title="{{ $record->notes }}">
                                                {{ Str::limit($record->notes, 50) }}
                                            </span>
                                        @else
                                            لا توجد ملاحظات
                                        @endif
                                    </td>
                                    <td>{{ $record->next_action ?? 'غير محدد' }}</td>
                                    <td>{{ $record->next_action_date ? \Carbon\Carbon::parse($record->next_action_date)->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                    <td>
                                        @if ($record->files->count() > 0)
                                            <span class="badge badge-info">{{ $record->files->count() }} ملف</span>
                                        @else
                                            <span class="badge badge-secondary">لا توجد ملفات</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('procedural-record.show', [$record->id, $case_id]) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                        <a href="{{ route('procedural-record.edit', $record->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> تعديل
                                        </a>
                                        <button wire:click="confirmDelete({{ $record->id }})"
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
                        لا توجد سجلات إجرائية لعرضها.
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
                {{ $proceduralRecords->links() }}
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
                        <p class="text-danger">هذا الإجراء لا يمكن التراجع عنه.</p>
                        <p>يرجى التأكد من أنك تريد حذف هذا السجل الإجرائي
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
    @script
        <script>
            document.addEventListener('livewire:init', () => {
                window.Livewire.on('show-delete-modal', (event) => {
                    $('#deleteModal').modal('show');
                });
            });
        </script>
    @endscript
</div>
