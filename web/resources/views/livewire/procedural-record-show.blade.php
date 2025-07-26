<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">
                تفاصيل السجل الإجرائي
                <a href="{{ route('procedural-record.edit', $proceduralRecord->id) }}" class="btn btn-warning">تعديل</a>
                <a href="{{ route('procedural-record.index', $proceduralRecord->executive_case_id) }}"
                    class="btn btn-secondary">العودة للقائمة</a>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Case Information -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title card_title_center">معلومات القضية</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>اسم المشترك:</strong>
                                        {{ $proceduralRecord->case->user->name ?? 'غير محدد' }}</p>
                                    <p><strong>اسم الموكل:</strong>
                                        {{ $proceduralRecord->case->client->name ?? 'غير محدد' }}</p>
                                    <p><strong>رقم الملف المكتبي:</strong>
                                        {{ $proceduralRecord->case->office_file_number ?? 'غير محدد' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>رقم الدعوى:</strong>
                                        {{ $proceduralRecord->case->lawsuit_number ?? 'غير محدد' }}</p>
                                    <p><strong>حالة القضية:</strong>
                                        <span
                                            class="badge badge-{{ $proceduralRecord->case->case_status == 'تنفيذية' ? 'success' : ($proceduralRecord->case->case_status == 'منتهية' ? 'secondary' : ($proceduralRecord->case->case_status == 'موقوفة' ? 'warning' : 'info')) }}">
                                            {{ $proceduralRecord->case->case_status ?? 'غير محدد' }}
                                        </span>
                                    </p>
                                    <p><strong>قيمة الدعوى:</strong>
                                        {{ $proceduralRecord->case->claim_value ? number_format($proceduralRecord->case->claim_value, 2) . ' دينار' : 'غير محدد' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Procedural Record Details -->
                <div class="mt-3 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title card_title_center">تفاصيل السجل الإجرائي</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>تاريخ الجلسة:</strong>
                                        {{ $proceduralRecord->session_date ? \Carbon\Carbon::parse($proceduralRecord->session_date)->format('Y-m-d') : 'غير محدد' }}
                                    </p>
                                    <p><strong>النوع:</strong> {{ $proceduralRecord->type ?? 'غير محدد' }}</p>
                                    <p><strong>الإجراء:</strong> {{ $proceduralRecord->action ?? 'غير محدد' }}</p>
                                    <p><strong>المحامي:</strong> {{ $proceduralRecord->lawyer ?? 'غير محدد' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>الإجراء اللاحق:</strong>
                                        {{ $proceduralRecord->next_action ?? 'غير محدد' }}</p>
                                    <p><strong>تاريخ الإجراء اللاحق:</strong>
                                        {{ $proceduralRecord->next_action_date ? \Carbon\Carbon::parse($proceduralRecord->next_action_date)->format('Y-m-d') : 'غير محدد' }}
                                    </p>
                                    <p><strong>تاريخ الإنشاء:</strong>
                                        {{ $proceduralRecord->created_at ? $proceduralRecord->created_at->format('Y-m-d H:i') : 'غير محدد' }}
                                    </p>
                                    <p><strong>آخر تحديث:</strong>
                                        {{ $proceduralRecord->updated_at ? $proceduralRecord->updated_at->format('Y-m-d H:i') : 'غير محدد' }}
                                    </p>
                                </div>
                            </div>

                            @if ($proceduralRecord->notes)
                                <div class="mt-3 row">
                                    <div class="col-md-12">
                                        <h6>الملاحظات:</h6>
                                        <div class="alert alert-info">
                                            {{ $proceduralRecord->notes }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Files Section -->
                @if ($proceduralRecord->files->count() > 0)
                    <div class="mt-3 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title card_title_center">الملفات المرفقة
                                    ({{ $proceduralRecord->files->count() }})</h5>
                            </div>
                            <div class="card-body">
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
                                            @foreach ($proceduralRecord->files as $index => $file)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ basename($file->file_path) }}</td>
                                                    <td>
                                                        @php
                                                            $extension = pathinfo($file->file_path, PATHINFO_EXTENSION);
                                                            $icon = match (strtolower($extension)) {
                                                                'pdf' => 'fas fa-file-pdf text-danger',
                                                                'doc', 'docx' => 'fas fa-file-word text-primary',
                                                                'jpg',
                                                                'jpeg',
                                                                'png'
                                                                    => 'fas fa-file-image text-success',
                                                                default => 'fas fa-file text-secondary',
                                                            };
                                                        @endphp
                                                        <i class="{{ $icon }}"></i>
                                                        {{ strtoupper($extension) }}
                                                    </td>
                                                    <td>{{ $file->created_at ? $file->created_at->format('Y-m-d H:i') : 'غير محدد' }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-download"></i> تحميل
                                                        </a>
                                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fas fa-eye"></i> عرض
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-3 col-md-12">
                        <div class="alert alert-info">
                            لا توجد ملفات مرفقة لهذا السجل الإجرائي.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
