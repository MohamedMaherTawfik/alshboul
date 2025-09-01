@extends('layouts.admin')

@section('title', 'الإجراءات')
@section('main_title_content', 'عرض الإجراءات')
@section('title_content', 'إجراءات')
@section('link_content')
    <a href="{{ route('settlements.procedure', $settlement) }}">العودة للقضية</a>
@endsection

@section('content')
    <div class="container mt-4">
        <!-- الإجراء الرئيسي -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">الإجراء الرئيسي</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>النوع</th>
                        <td>{{ $settlement->type }}</td>
                    </tr>
                    <tr>
                        <th>التاريخ</th>
                        <td>{{ $settlement->date }}</td>
                    </tr>
                    <tr>
                        <th>الإجراء</th>
                        <td>{{ $settlement->action }}</td>
                    </tr>
                    <tr>
                        <th>الملاحظة</th>
                        <td>{{ $settlement->note }}</td>
                    </tr>
                    <tr>
                        <th>المحامي</th>
                        <td>{{ optional($settlement->user)->name }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- الإجراءات الفرعية -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                <h5 class="mb-0">الإجراءات الفرعية</h5>
                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addSubProcedureModal">
                    + إضافة إجراء فرعي
                </button>
            </div>
            <div class="card-body">
                @if ($settlement->subProcedurals->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>الإجراء</th>
                                <th>الملاحظة</th>
                                <th>تاريخ الإنشاء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($settlement->subProcedurals as $sub)
                                <tr>
                                    <td>{{ $sub->action }}</td>
                                    <td>{{ $sub->note }}</td>
                                    <td>{{ $sub->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">لا توجد إجراءات فرعية بعد.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- مودال إضافة إجراء فرعي -->
    <div class="modal fade" id="addSubProcedureModal" tabindex="-1" aria-labelledby="addSubProcedureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('settlements.subprocedure.store', $settlement->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addSubProcedureModalLabel">إضافة إجراء فرعي</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- الإجراء -->
                        <div class="mb-3">
                            <label for="action" class="form-label">الإجراء</label>
                            <input type="text" name="action" id="action" class="form-control" required>
                        </div>

                        <!-- الملاحظة -->
                        <div class="mb-3">
                            <label for="note" class="form-label">ملاحظة</label>
                            <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
