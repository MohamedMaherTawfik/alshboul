<div class="card">
    <div class="card-header">
        <h3 class="card-title">إجراءات التسوية: {{ $settlement->subscriber_name }}
            <span class="badge badge-info">{{ $actions->total() }}</span>
            <br>
            <a href="{{ route('settlement-action.create', $settlement->id) }}" class="btn btn-success">إضافة إجراء جديد</a>
        </h3>
    </div>
    <div class="card-body">
        <div class="mb-3 row">
            <div class="col-md-4">
                <input wire:model.live="type" type="text" class="form-control" placeholder="بحث نوع الإجراء">
            </div>
            <div class="col-md-4">
                <input wire:model.live="action" type="text" class="form-control" placeholder="بحث الإجراء">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                   
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
                    </tr>
                </thead>
                <tbody>
                    @forelse ($actions as $action)
                        <tr>
                        <td>{{ $action->creator->name ?? 'غير محدد' }}</td>
                                    <td>{{ $action->created_at ? \Carbon\Carbon::parse($action->created_at)->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                    <td>{{ $action->session_date ? \Carbon\Carbon::parse($action->session_date)->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                    <td>{{ $action->type ?? 'غير محدد' }}</td>
                                    <td>{{ $action->action ?? 'غير محدد' }}</td>
                                    <td>{{ $action->lawyer ?? 'غير محدد' }}</td>
                                    <td>
                                        @if ($action->notes)
                                            <span class="text-truncate d-inline-block" style="max-width: 150px;"
                                                title="{{ $action->notes }}">
                                                {{ Str::limit($action->notes, 50) }}
                                            </span>
                                        @else
                                            لا توجد ملاحظات
                                        @endif
                                    </td>
                                    <td>{{ $action->next_action ?? 'غير محدد' }}</td>
                                    <td>{{ $action->next_action_date ? \Carbon\Carbon::parse($action->next_action_date)->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                    <td>
                                        @if ($action->files->count() > 0)
                                            <span class="badge badge-info">{{ $action->files->count() }} ملف</span>
                                        @else
                                            <span class="badge badge-secondary">لا توجد ملفات</span>
                                        @endif
                                    </td>
                            <td>
                            <a href="{{ route('settlement-action.show', [$action->id]) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                <a href="{{ route('settlement-action.edit', $action->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button wire:click="confirmDelete({{ $action->id }})" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">لا توجد إجراءات لعرضها.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $actions->links() }}
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade @if($showDeleteModal) show d-block @endif" tabindex="-1" role="dialog" style="@if($showDeleteModal) display:block; background:rgba(0,0,0,0.5); @endif">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تأكيد الحذف</h5>
                    <button type="button" class="close" wire:click="cancelDelete"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <label>سبب الحذف</label>
                    <input type="text" class="form-control" wire:model.defer="deleteReason">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="cancelDelete">إلغاء</button>
                    <button type="button" class="btn btn-danger" wire:click="delete">حذف</button>
                </div>
            </div>
        </div>
    </div>
</div> 