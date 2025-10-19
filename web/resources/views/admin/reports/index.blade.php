@extends('layouts.admin')

@section('title', 'تقارير البحث')
@section('main_title_content', 'تقارير البحث')
@section('title_content', 'نتائج البحث')

@section('content')
    <div class="container-fluid mt-4">

        {{-- ✅ فورم البحث --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-dark text-white d-flex align-items-center">
                <i class="fas fa-search me-2"></i>
                <h5 class="mb-0">بحث بالتاريخ والمحامي</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.search') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        {{-- من تاريخ --}}
                        <div class="col-md-4">
                            <label for="from_date" class="form-label fw-bold">من تاريخ</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" required>
                        </div>

                        {{-- إلى تاريخ --}}
                        <div class="col-md-4">
                            <label for="to_date" class="form-label fw-bold">إلى تاريخ</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" required>
                        </div>

                        {{-- اسم المحامي --}}
                        <div class="col-md-4">
                            <label for="person_name" class="form-label fw-bold">اسم المحامي</label>
                            <select name="person_name" id="person_name" class="form-select" required>
                                <option value="" selected disabled>اختر المحامي...</option>
                                @foreach ($lawyers as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-search me-1"></i> بحث
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ✅ نتائج البحث --}}
        @if (request()->routeIs('reports.search'))

            {{-- ✅ إجراءات القضايا --}}
            <div class="card mb-4 shadow w-100">
                <div class="card-header bg-primary text-white fw-bold">إجراءات القضايا</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>المحامي</th>
                                    <th>الوقائع</th>
                                    <th>تاريخ الإدخال</th>
                                    <th>النوع</th>
                                    <th>المستندات</th>
                                    <th>الإجراء القادم</th>
                                    <th>تاريخ الإجراء القادم</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($casesProcedurals as $proc)
                                    <tr>
                                        <td>{{ $proc->userLawyer->name ?? '-' }}</td>
                                        <td>{{ $proc->user->name ?? '-' }}</td>
                                        <td>{{ $proc->action ?? '-' }}</td>
                                        <td>{{ $proc->created_at->format('Y-m-d H:i') ?? '-' }}</td>
                                        <td>{{ $proc->type ?? '-' }}</td>
                                        <td>
                                            @forelse($proc->files as $doc)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}"
                                                    class="btn btn-info btn-sm" target="_blank">عرض المستند</a>
                                            @empty
                                                <span class="text-muted">لا توجد مستندات</span>
                                            @endforelse
                                        </td>
                                        <td>{{ $proc->next_action ?? '-' }}</td>
                                        <td>{{ $proc->next_action_date ?? '-' }}</td>
                                        <td>{{ $proc->note ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">لا توجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ✅ إجراءات التسويات --}}
            <div class="card mb-4 shadow w-100">
                <div class="card-header bg-success text-white fw-bold">إجراءات التسويات</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>المحامي</th>
                                    <th>الوقائع</th>
                                    <th>تاريخ الإدخال</th>
                                    <th>النوع</th>
                                    <th>المستندات</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($settlementProcedurals as $proc)
                                    <tr>
                                        <td>{{ $proc->userLawyer->name ?? '-' }}</td>
                                        <td>{{ $proc->user->name ?? '-' }}</td>
                                        <td>{{ $proc->action ?? '-' }}</td>
                                        <td>{{ $proc->created_at->format('Y-m-d H:i') ?? '-' }}</td>
                                        <td>{{ $proc->type ?? '-' }}</td>
                                        <td>
                                            @forelse($proc->files as $doc)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}"
                                                    class="btn btn-info btn-sm" target="_blank">عرض المستند</a>
                                            @empty
                                                <span class="text-muted">لا توجد مستندات</span>
                                            @endforelse
                                        </td>
                                        <td>{{ $proc->note ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">لا توجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ✅ إجراءات المعاملات --}}
            <div class="card mb-4 shadow w-100">
                <div class="card-header bg-warning text-dark fw-bold">إجراءات المعاملات</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>المحامي</th>
                                    <th>الوقائع</th>
                                    <th>تاريخ الإدخال</th>
                                    <th>النوع</th>
                                    <th>المستندات</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($transactionProcedurals as $proc)
                                    <tr>
                                        <td>{{ $proc->userLawyer->name ?? '-' }}</td>
                                        <td>{{ $proc->user->name ?? '-' }}</td>
                                        <td>{{ $proc->action ?? '-' }}</td>
                                        <td>{{ $proc->created_at->format('Y-m-d H:i') ?? '-' }}</td>
                                        <td>{{ $proc->type ?? '-' }}</td>
                                        <td>
                                            @forelse($proc->files as $doc)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}"
                                                    class="btn btn-info btn-sm" target="_blank">عرض المستند</a>
                                            @empty
                                                <span class="text-muted">لا توجد مستندات</span>
                                            @endforelse
                                        </td>
                                        <td>{{ $proc->note ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">لا توجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ✅ إجراءات التنفيذية --}}
            <div class="card mb-4 shadow w-100">
                <div class="card-header bg-danger text-white fw-bold">إجراءات التنفيذية</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>المحامي</th>
                                    <th>الوقائع</th>
                                    <th>تاريخ الإدخال</th>
                                    <th>النوع</th>
                                    <th>المستندات</th>
                                    <th>الإجراء القادم</th>
                                    <th>تاريخ الإجراء القادم</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($executiveProcedurals as $proc)
                                    <tr>
                                        <td>{{ $proc->userLawyer->name ?? '-' }}</td>
                                        <td>{{ $proc->user->name ?? '-' }}</td>
                                        <td>{{ $proc->action ?? '-' }}</td>
                                        <td>{{ $proc->created_at->format('Y-m-d H:i') ?? '-' }}</td>
                                        <td>{{ $proc->type ?? '-' }}</td>
                                        <td>
                                            @forelse($proc->files as $doc)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}"
                                                    class="btn btn-info btn-sm" target="_blank">عرض المستند</a>
                                            @empty
                                                <span class="text-muted">لا توجد مستندات</span>
                                            @endforelse
                                        </td>
                                        <td>{{ $proc->next_action ?? '-' }}</td>
                                        <td>{{ $proc->next_action_date ?? '-' }}</td>
                                        <td>{{ $proc->note ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">لا توجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ✅ إجراءات الموكلين --}}
            <div class="card mb-4 shadow w-100">
                <div class="card-header bg-info text-white fw-bold">إجراءات الموكلين</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>تاريخ الإدخال</th>
                                    <th>الإجراء الرئيسي</th>
                                    <th>المحامي</th>
                                    <th>الجهة</th>
                                    <th>وقائع الإجراء</th>
                                    <th>الحالة</th>
                                    <th>الموكل</th>
                                    <th>تاريخ الإجراء اللاحق</th>
                                    <th>إجراء فرعي</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($clientProcedurals as $proc)
                                    <tr>
                                        <td>{{ $proc->user->name ?? 'غير محدد' }}</td>
                                        <td>{{ $proc->created_at->format('Y-m-d') ?? 'غير محدد' }}</td>
                                        <td>{{ $proc->procedural ?? 'غير محدد' }}</td>
                                        <td>{{ $proc->lawyer->name ?? 'غير محدد' }}</td>
                                        <td>{{ $proc->side ?? '-' }}</td>
                                        <td>{{ $proc->procedural_facts ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge p-2 {{ $proc->status ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $proc->status ? 'مكتمل' : 'غير مكتمل' }}
                                            </span>
                                        </td>
                                        <td>{{ $proc->client->name ?? '-' }}</td>
                                        <td>{{ $proc->next_action_date ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('client.procedural.sub.index', $proc) }}"
                                                class="btn btn-outline-primary btn-sm">إجراء فرعي</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">لا توجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @endif
    </div>
@endsection
