@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('cases.all') }}">جميع القضايا</a>
@endsection

<style>
    :root {
        --primary-color: #3498db;
        --danger-color: #e74c3c;
        --warning-color: #f39c12;
        --success-color: #27ae60;
        --secondary-color: #2c3e50;
        --accent-color: #f8f9fa;
        --border-color: #dee2e6;
        --text-muted: #6c757d;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .header-title {
        color: var(--secondary-color);
        border-right: 4px solid var(--primary-color);
        padding-right: 15px;
        font-weight: 700;
        font-size: 1.75rem;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: #1d6fa5;
    }

    .breadcrumb-item.active {
        color: var(--secondary-color);
        font-weight: 500;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: var(--secondary-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1.2rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
        font-size: 1.2rem;
    }

    .case-type-card {
        border-radius: 10px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        height: 100%;
        background-color: white;
        text-align: center;
        padding: 1.5rem 1rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
    }

    .case-type-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-color);
    }

    .case-type-count {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1;
    }

    .case-type-name {
        font-weight: 600;
        color: var(--secondary-color);
        margin: 0.5rem 0;
    }

    .text-muted-small {
        color: var(--text-muted);
        font-size: 0.875rem;
    }

    .table th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table td,
    .table th {
        vertical-align: middle;
        white-space: nowrap;
    }

    .badge-count {
        background-color: var(--primary-color);
        color: white;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Duration Status Colors */
    .status-overdue {
        background-color: #ffebee !important;
        color: var(--danger-color) !important;
        font-weight: bold;
    }

    .status-warning {
        background-color: #fff3cd !important;
        color: #856404;
    }

    .duration-date {
        font-weight: 500;
    }

    .btn-dark {
        background-color: var(--secondary-color);
        border: none;
    }

    .btn-dark:hover {
        background-color: #1a252f;
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 3rem;
        opacity: 0.5;
    }

    .empty-state p {
        margin-top: 0.5rem;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.8rem;
        }

        .case-type-count {
            font-size: 1.75rem;
        }

        .table td,
        .table th {
            padding: 0.4rem 0.3rem;
            font-size: 0.75rem;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>

@section('content')
    <div class="container-fluid px-4 px-md-5 py-4">
        <!-- Breadcrumb & Header -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="header-title">قائمة أنواع القضايا والمدد القانونية</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cases.all') }}">جميع القضايا</a></li>
                        <li class="breadcrumb-item active" aria-current="page">أنواع القضايا والمدد</li>
                    </ol>
                </nav>
            </div>
        </div>

        <a href="{{ route('mission.unfinished') }}"
            class="alert bg-dark text-white py-2 px-3 d-flex justify-content-between align-items-center fs-4 text-decoration-none"
            style="width:20%;">
            <span><i class="bi bi-exclamation-circle me-2"></i> عدد المهام الغير منجزة</span>
            <span class="badge bg-danger fs-3">
                {{ $unfinishedMissions }}
            </span>
        </a>




        <!-- Case Types Section -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-3 pb-2">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="mb-0"><i class="bi bi-folder  me-2"></i>أنواع القضايا</h5>

                    </div>
                    <span class="badge bg-primary mr-2 fs-6 px-3 py-2">{{ $caseTypes->count() }} نوع</span>
                </div>
            </div>
            <div class="card-body">
                @if ($caseTypes->isEmpty())
                    <div class="empty-state">
                        <i class="bi bi-folder-x text-muted" style="font-size: 3rem;"></i>
                        <p class="mt-2 mb-0">لا توجد أنواع قضايا مسجلة</p>
                    </div>
                @else
                    <div class="row g-3">
                        @foreach ($caseTypes as $caseType)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="case-type-card h-100">
                                    <div class="case-type-count">{{ $caseType->suggestedCases->count() }}</div>
                                    <div class="case-type-name">{{ $caseType->name }}</div>
                                    <div class="text-muted-small">قضية</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>


    </div>
@endsection
