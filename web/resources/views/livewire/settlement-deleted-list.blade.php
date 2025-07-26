<div class="card">
    <div class="card-header">
        <h3 class="card-title">التسويات المحذوفة
            <span class="badge badge-info">{{ $settlements->total() }}</span>
        </h3>
    </div>
    <div class="card-body">
        <div class="mb-3 row">
            <div class="col-md-4">
                <input wire:model.live="search" type="text" class="form-control" placeholder="بحث اسم المشترك">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المشترك</th>
                        <th>اسم الموكل</th>
                        <th>اسم الخصم</th>
                        <th>رقم الدعوى</th>
                        <th>نوع التسوية</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($settlements as $settlement)
                        <tr>
                            <td>{{ $settlement->id }}</td>
                            <td>{{ $settlement->subscriber_name }}</td>
                            <td>{{ $settlement->client?->name }}</td>
                            <td>{{ $settlement->opponent_name }}</td>
                            <td>{{ $settlement->lawsuit_number }}</td>
                            <td>{{ $settlement->settlementType?->name }}</td>
                            <td>
                                <button wire:click="restore({{ $settlement->id }})" class="btn btn-success btn-sm">
                                    <i class="fas fa-undo"></i> استرجاع
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد تسويات محذوفة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $settlements->links() }}
            </div>
        </div>
    </div>
</div> 