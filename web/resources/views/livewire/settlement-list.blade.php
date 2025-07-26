<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center">قائمة التسويات
            <span class="badge badge-info">{{ $settlements->total() }}</span>
            <br>
            <a href="{{ route('settlement.create') }}" class="btn btn-success">إضافة جديد</a>
        </h3>
    </div>
    <div class="card-body">
        <div class="mb-3 row">

            <div class="col-md-3">
                <input wire:model.live="office_file_number" type="text" class="form-control" placeholder="رقم الملف">
            </div>
            <div class="col-md-3">
                <input wire:model.live="subscriber_name" type="text" class="form-control"
                    placeholder="بحث اسم المشترك">
            </div>
            <div class="col-md-3">
                <input wire:model.live="client_id" type="text" class="form-control" placeholder="بحث اسم الموكل">
            </div>
            <div class="col-md-3">
                <input wire:model.live="opponent_name" type="text" class="form-control" placeholder="بحث اسم الخصم">
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
                        <th>رقم الوطني للموكل</th>
                        <th>رقم الوطني للخصم</th>
                        <th>رقم هاتف الخصم</th>
                        <th>العنوان</th>
                        <th>صفة الموكل</th>
                        <th>صفة الخصم</th>
                        <th>رقم الملف</th>
                        <th>رقم الدعوى</th>
                        <th>نوع التسوية</th>
                        <th>قيمة الدين</th>
                        <th>نوع القسط</th>
                        <th>قيمة القسط</th>
                        <th>تفاصيل التسوية</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($settlements as $settlement)
                        <tr>
                            <td>{{ $settlement->id }}</td>
                            <td>{{ $settlement->user->name }}</td>
                            <td>{{ $settlement->client?->name }}</td>
                            <td>{{ $settlement->opponent_name }}</td>
                            <td>{{ $settlement->client_national_id }}</td>
                            <td>{{ $settlement->opponent_national_id }}</td>
                            <td>{{ $settlement->opponent_phone }}</td>
                            <td>{{ $settlement->address }}</td>
                            <td>{{ $settlement->judged_for_role }}</td>

                            <td>{{ $settlement->judged_against_role }}</td>


                            <td>{{ $settlement->office_file_number }}</td>

                            <td>{{ $settlement->lawsuit_number }}</td>
                            <td>{{ $settlement->settlementType?->name_ar }}</td>
                            <td>{{ $settlement->debt_value }}</td>
                            <td>{{ $settlement->installment_type }}</td>
                            <td>{{ $settlement->payment_value }}</td>
                            <td>{{ $settlement->settlement_details }}</td>


                            <td>
                                <a href="{{ route('settlement.edit', $settlement->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <a href="{{ route('settlement-action.list', $settlement->id) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> الاجراءات
                                </a>
                                      <button wire:click="toggleCommitment({{  $settlement->id}})"
                                    class="btn
            {{ $settlement->commitment_status === 'ملتزم' ? 'btn-success' : 'btn-danger' }}">
                                    {{ $settlement->commitment_status ?? 'غير محدد' }}
                                </button>
                                <button wire:click="confirmDelete({{ $settlement->id }})"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="17" class="text-center">لا توجد تسويات لعرضها.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $settlements->links() }}
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade @if ($showDeleteModal) show d-block @endif" tabindex="-1" role="dialog"
        style="@if ($showDeleteModal) display:block; background:rgba(0,0,0,0.5); @endif">
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
