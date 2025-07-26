<div class="card">
    <div class="card-header">
        <h3 class="card-title">تفاصيل التسوية</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-4"><strong>اسم المشترك:</strong> {{ $settlement->subscriber_name }}</div>
            <div class="form-group col-md-4"><strong>اسم الموكل:</strong> {{ $settlement->client?->name }}</div>
            <div class="form-group col-md-4"><strong>اسم الخصم:</strong> {{ $settlement->opponent_name }}</div>
        </div>
        <div class="row">
            <div class="form-group col-md-4"><strong>الرقم الوطني للموكل:</strong> {{ $settlement->client_national_id }}</div>
            <div class="form-group col-md-4"><strong>الرقم الوطني للخصم:</strong> {{ $settlement->opponent_national_id }}</div>
            <div class="form-group col-md-4"><strong>نوع التسوية:</strong> {{ $settlement->settlementType?->name_ar }}</div>
        </div>
        <div class="row">
            <div class="form-group col-md-4"><strong>صفة المحكوم له:</strong> {{ $settlement->judged_for_role }}</div>
            <div class="form-group col-md-4"><strong>صفة المحكوم عليه:</strong> {{ $settlement->judged_against_role }}</div>
            <div class="form-group col-md-4"><strong>حالة الالتزام:</strong> {{ $settlement->commitment_status }}</div>
        </div>
        <div class="row">
            <div class="form-group col-md-4"><strong>هاتف الخصم:</strong> {{ $settlement->opponent_phone }}</div>
            <div class="form-group col-md-4"><strong>رقم ملف المكتب:</strong> {{ $settlement->office_file_number }}</div>
            <div class="form-group col-md-4"><strong>رقم الدعوى:</strong> {{ $settlement->lawsuit_number }}</div>
        </div>
        <div class="row">
            <div class="form-group col-md-4"><strong>العنوان:</strong> {{ $settlement->address }}</div>
            <div class="form-group col-md-4"><strong>قيمة الدين:</strong> {{ $settlement->debt_value }}</div>
            <div class="form-group col-md-4"><strong>قيمة السداد:</strong> {{ $settlement->payment_value }}</div>
        </div>
        <div class="row">
            <div class="form-group col-md-4"><strong>نوع التقسيط:</strong> {{ $settlement->installment_type }}</div>
            <div class="form-group col-md-8"><strong>تفاصيل التسوية:</strong> {{ $settlement->settlement_details }}</div>
        </div>
        <div class="row">
            <div class="form-group col-md-4"><strong>أنشئ بواسطة:</strong> {{ $settlement->creator?->username ?? $settlement->creator?->name }}</div>
            <div class="form-group col-md-4"><strong>آخر تعديل بواسطة:</strong> {{ $settlement->updater?->username ?? $settlement->updater?->name }}</div>
            <div class="form-group col-md-4"><strong>سبب الحذف:</strong> {{ $settlement->delete_reason }}</div>
        </div>
        <hr>
        <h4 class="mt-4">إجراءات التسوية</h4>
        @forelse ($settlement->actions as $action)
            <div class="card mt-3">
                <div class="card-header">
                    <strong>تاريخ الإجراء:</strong> {{ $action->action_date }} |
                    <strong>نوع الإجراء:</strong> {{ $action->type }} |
                    <strong>الإجراء:</strong> {{ $action->action }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ملاحظات:</strong> {{ $action->notes ?? '---' }}</p>
                            <p><strong>الإجراء التالي:</strong> {{ $action->next_action ?? '---' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>تاريخ الإجراء التالي:</strong> {{ $action->next_action_date ?? '---' }}</p>
                            <p><strong>أنشئ بواسطة:</strong> {{ $action->creator?->name ?? '---' }}</p>
                        </div>
                    </div>
                    @if ($action->files->count() > 0)
                        <div class="mt-3">
                            <h6>الملفات المرفقة ({{ $action->files->count() }})</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم الملف</th>
                                            <th>نوع الملف</th>
                                            <th>تاريخ الرفع</th>
                                            <th>التحكم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($action->files as $index => $file)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ basename($file->file_path) }}</td>
                                                <td>
                                                    @php
                                                        $extension = pathinfo($file->file_path, PATHINFO_EXTENSION);
                                                        $icon = match (strtolower($extension)) {
                                                            'pdf' => 'fas fa-file-pdf text-danger',
                                                            'doc', 'docx' => 'fas fa-file-word text-primary',
                                                            'jpg', 'jpeg', 'png' => 'fas fa-file-image text-success',
                                                            default => 'fas fa-file text-secondary',
                                                        };
                                                    @endphp
                                                    <i class="{{ $icon }}"></i>
                                                    {{ strtoupper($extension) }}
                                                </td>
                                                <td>{{ $file->created_at ? $file->created_at->format('Y-m-d H:i') : '---' }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="btn btn-info btn-sm">
                                                        <i class="fas fa-download"></i> تحميل
                                                    </a>
                                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="btn btn-success btn-sm">
                                                        <i class="fas fa-eye"></i> عرض
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mt-2">لا توجد ملفات مرفقة لهذا الإجراء.</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-warning mt-4">لا توجد إجراءات مسجلة لهذه التسوية.</div>
        @endforelse
    </div>
</div> 