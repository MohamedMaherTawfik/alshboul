@extends('layouts.admin')

@section('title', 'تقارير البحث')
@section('main_title_content', 'تقارير البحث')
@section('title_content', 'نتائج البحث')

@section('content')
    <div class="container-fluid mt-4">
        {{-- فورم البحث --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-search me-2"></i> بحث بالتاريخ والاسم</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.search') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="from_date" class="form-label">من تاريخ</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="to_date" class="form-label">إلى تاريخ</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="person_name" class="form-label">اسم الشخص</label>
                            <input type="text" name="person_name" id="person_name" class="form-control"
                                placeholder="ادخل اسم الشخص">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-search me-1"></i> بحث
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if (request()->routeIs('reports.search'))

            {{-- إجراءات القضايا --}}
            <div class="card mb-4 shadow w-100">
                <div class="card-header bg-primary text-white fw-bold">إجراءات القضايا</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>المحامي</th>
                                    <th>الوقائع</th>
                                    <th>تاريخ الادخال</th>
                                    <th>النوع</th>
                                    <th>المستندات</th>
                                    <th>الاجراء القادم</th>
                                    <th>تاريخ الاجراء القادم</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($casesProcedurals as $proc)
                                    <tr>
                                        <td>{{ $proc->userLawyer->name ?? '-' }}</td>
                                        <td>{{ $proc->user->name ?? '-' }}</td>
                                        <td>{{ $proc->action ?? '-' }}</td>
                                        <td>{{ $proc->created_at->format('Y-m-d H:i') ?? '-' }}</td>
                                        <td>{{ $proc->type ?? '-' }}</td>
                                        <td>
                                            @forelse($proc->files as $doc)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" class="btn btn-info"
                                                    target="_blank">عرض
                                                    المستند</a>
                                            @empty
                                                لا توجد مستندات
                                            @endforelse
                                        </td>
                                        <td>{{ $proc->next_action ?? '-' }}</td>
                                        <td>{{ $proc->next_action_date ?? '-' }}</td>
                                        <td>{{ $proc->note }}</td>
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

            {{-- إجراءات التسويات --}}
            <div class="card mb-4 shadow w-100">
                <div class="card-header bg-success text-white fw-bold">إجراءات التسويات</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>المحامي</th>
                                    <th>الوقائع</th>
                                    <th>تاريخ الادخال</th>
                                    <th>النوع</th>
                                    <th>المستندات</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($settlementProcedurals as $proc)
                                    <tr>
                                        <td>{{ $proc->userLawyer->name ?? '-' }}</td>
                                        <td>{{ $proc->user->name ?? '-' }}</td>
                                        <td>{{ $proc->action ?? '-' }}</td>
                                        <td>{{ $proc->created_at->format('Y-m-d H:i') ?? '-' }}</td>
                                        <td>{{ $proc->type ?? '-' }}</td>
                                        <td>
                                            @forelse($proc->files as $doc)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" class="btn btn-info"
                                                    target="_blank">عرض
                                                    المستند</a>
                                            @empty
                                                لا توجد مستندات
                                            @endforelse
                                        </td>
                                        <td>{{ $proc->note }}</td>
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

            {{-- إجراءات المعاملات --}}
            <div class="card mb-4 shadow w-100">
                <div class="card-header bg-warning text-dark fw-bold">إجراءات المعاملات</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>المحامي</th>
                                    <th>الوقائع</th>
                                    <th>تاريخ الادخال</th>
                                    <th>النوع</th>
                                    <th>المستندات</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactionProcedurals as $proc)
                                    <tr>
                                        <td>{{ $proc->userLawyer->name ?? '-' }}</td>
                                        <td>{{ $proc->user->name ?? '-' }}</td>
                                        <td>{{ $proc->action ?? '-' }}</td>
                                        <td>{{ $proc->created_at->format('Y-m-d H:i') ?? '-' }}</td>
                                        <td>{{ $proc->type ?? '-' }}</td>
                                        <td>
                                            @forelse($proc->files as $doc)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" class="btn btn-info"
                                                    target="_blank">عرض
                                                    المستند</a>
                                            @empty
                                                لا توجد مستندات
                                            @endforelse
                                        </td>
                                        <td>{{ $proc->note }}</td>
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

            {{-- إجراءات التنفيذية --}}
            <div class="card mb-4 shadow w-100">
                <div class="card-header bg-danger text-white fw-bold">إجراءات التنفيذية</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>المحامي</th>
                                    <th>الوقائع</th>
                                    <th>تاريخ الادخال</th>
                                    <th>النوع</th>
                                    <th>المستندات</th>
                                    <th>الاجراء القادم</th>
                                    <th>تاريخ الاجراء القادم</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($executiveProcedurals as $proc)
                                    <tr>
                                        <td>{{ $proc->userLawyer->name ?? '-' }}</td>
                                        <td>{{ $proc->user->name ?? '-' }}</td>
                                        <td>{{ $proc->action ?? '-' }}</td>
                                        <td>{{ $proc->created_at->format('Y-m-d H:i') ?? '-' }}</td>
                                        <td>{{ $proc->type ?? '-' }}</td>
                                        <td>
                                            @forelse($proc->files as $doc)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" class="btn btn-info"
                                                    target="_blank">عرض
                                                    المستند</a>
                                            @empty
                                                لا توجد مستندات
                                            @endforelse
                                        </td>
                                        <td>{{ $proc->next_action ?? '-' }}</td>
                                        <td>{{ $proc->next_action_date ?? '-' }}</td>
                                        <td>{{ $proc->note }}</td>
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

            {{-- إجراءات الموكلين --}}
            <div class="card mb-4 shadow w-100">
                <div class="card-header bg-info text-white fw-bold">إجراءات الموكلين</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">اسم المدخل</th>
                                    <th class="text-center">تاريخ الادخال</th>
                                    <th class="text-center"> الاجراء الرئيسي</th>
                                    <th class="text-center"> المحامي</th>
                                    <th class="text-center">الجهة</th>
                                    <th class="text-center">وقائع الإجراء</th>
                                    <th class="text-center">الحالة</th>
                                    <th class="text-center">الموكل</th>
                                    <th class="text-center">تاريخ الاجراء اللاحق</th>
                                    <th class="text-center">اجراء فرعي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clientProcedurals as $proc)
                                    <tr>
                                        <td class="text-center">{{ $proc->user->name ?? 'غير محدد' }}</td>
                                        <td class="text-center">
                                            {{ $proc->created_at->format('Y-m-d') ?: 'غير محدد' }}</td>
                                        <td class="text-center procedural-col">
                                            {{ $proc->procedural ?? 'غير محدد' }}</td>
                                        <td class="text-center">
                                            {{ $proc->lawyer->name ?? 'غير محدد' }}</td>
                                        <td class="text-center">{{ $proc->side }}</td>
                                        <td class="facts-col">
                                            {{ $proc->procedural_facts }}
                                        </td>

                                        <td class="text-center">
                                            <span class="badge p-2 {{ $proc->status ? 'bg-success' : 'bg-warning' }}">
                                                {{ $proc->status ? 'مكتمل' : 'غير مكتمل' }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $proc->client->name ?? 'غير محدد' }}</td>
                                        <td class="text-center">{{ $proc->next_action_date ?? 'غير محدد' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('client.procedural.sub.index', $proc) }}">اجراء
                                                فرعي</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">لا توجد بيانات</td>
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
