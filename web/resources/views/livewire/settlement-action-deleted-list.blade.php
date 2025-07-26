<div class="card">
    <div class="card-header">
        <h3 class="card-title">الإجراءات المحذوفة للتسوية: {{ $settlement->subscriber_name }}
            <span class="badge badge-info">{{ $actions->total() }}</span>
        </h3>
    </div>
    <div class="card-body">
        <div class="mb-3 row">
            <div class="col-md-4">
                <input wire:model.live="search" type="text" class="form-control" placeholder="بحث نوع الإجراء">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>تاريخ الإجراء</th>
                        <th>نوع الإجراء</th>
                        <th>الإجراء</th>
                        <th>ملاحظات</th>
                        <th>الإجراء التالي</th>
                        <th>تاريخ الإجراء التالي</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($actions as $action)
                        <tr>
                            <td>{{ $action->id }}</td>
                            <td>{{ $action->action_date }}</td>
                            <td>{{ $action->type }}</td>
                            <td>{{ $action->action }}</td>
                            <td>{{ $action->notes }}</td>
                            <td>{{ $action->next_action }}</td>
                            <td>{{ $action->next_action_date }}</td>
                            <td>
                                <button wire:click="restore({{ $action->id }})" class="btn btn-success btn-sm">
                                    <i class="fas fa-undo"></i> استرجاع
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">لا توجد إجراءات محذوفة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $actions->links() }}
            </div>
        </div>
    </div>
</div> 