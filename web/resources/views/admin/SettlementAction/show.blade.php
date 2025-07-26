@extends('layouts.admin')
@section('title', 'تفاصيل إجراء التسوية')
@section('main_title_content', 'إجراءات التسوية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('settlement-action.list', $settlementAction->settlement_id) }}">إجراءات التسوية</a>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">
                    تفاصيل إجراء التسوية
                    <a href="{{ route('settlement-action.edit', $settlementAction->id) }}" class="btn btn-warning">تعديل</a>
                    <a href="{{ route('settlement-action.list', $settlementAction->settlement_id) }}" class="btn btn-secondary">العودة للقائمة</a>
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Settlement Action Details -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title card_title_center">معلومات إجراء التسوية</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>تاريخ الإجراء:</strong> {{ $settlementAction->action_date ? \Carbon\Carbon::parse($settlementAction->action_date)->format('Y-m-d') : 'غير محدد' }}</p>
                                        <p><strong>نوع الإجراء:</strong> {{ $settlementAction->type ?? 'غير محدد' }}</p>
                                        <p><strong>الإجراء:</strong> {{ $settlementAction->action ?? 'غير محدد' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>الإجراء التالي:</strong> {{ $settlementAction->next_action ?? 'غير محدد' }}</p>
                                        <p><strong>تاريخ الإجراء التالي:</strong> {{ $settlementAction->next_action_date ? \Carbon\Carbon::parse($settlementAction->next_action_date)->format('Y-m-d') : 'غير محدد' }}</p>
                                        <p><strong>تاريخ الإنشاء:</strong> {{ $settlementAction->created_at ? $settlementAction->created_at->format('Y-m-d H:i') : 'غير محدد' }}</p>
                                        <p><strong>آخر تحديث:</strong> {{ $settlementAction->updated_at ? $settlementAction->updated_at->format('Y-m-d H:i') : 'غير محدد' }}</p>
                                    </div>
                                </div>
                                @if ($settlementAction->notes)
                                    <div class="mt-3 row">
                                        <div class="col-md-12">
                                            <h6>الملاحظات:</h6>
                                            <div class="alert alert-info">
                                                {{ $settlementAction->notes }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Files Section -->
                    @if ($settlementAction->files->count() > 0)
                        <div class="mt-3 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title card_title_center">الملفات المرفقة ({{ $settlementAction->files->count() }})</h5>
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
                                                @foreach ($settlementAction->files as $index => $file)
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
                                                        <td>{{ $file->created_at ? $file->created_at->format('Y-m-d H:i') : 'غير محدد' }}</td>
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
                            </div>
                        </div>
                    @else
                        <div class="mt-3 col-md-12">
                            <div class="alert alert-info">
                                لا توجد ملفات مرفقة لهذا الإجراء.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
