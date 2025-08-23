@extends('layouts.admin')
@section('title', 'مهامي ')
@section('main_title_content', ' قائمة المهام ')
@section('title_content', 'المهام المسندة لي')
@section('css')
    @livewireStyles
    <style>
        :root {
            --primary-color: #3b71ca;
            --secondary-color: #f8f9fa;
            --accent-color: #14a44d;
            --warning-color: #e4a11b;
            --danger-color: #dc4c64;
            --dark-color: #332d2d;
            --light-color: #f5f5f5;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .mission-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            border: none;
            margin-bottom: 20px;
            background: linear-gradient(to bottom, #ffffff, #f9fafb);
        }

        .mission-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .mission-header {
            background: linear-gradient(to right, var(--primary-color), #4a7ed4);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mission-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .mission-body {
            padding: 20px;
        }

        .mission-title {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 15px;
            font-size: 1.25rem;
        }

        .mission-detail {
            display: flex;
            margin-bottom: 12px;
            align-items: flex-start;
        }

        .detail-icon {
            color: var(--primary-color);
            margin-left: 10px;
            font-size: 16px;
            margin-top: 3px;
            min-width: 20px;
            text-align: center;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
        }

        .detail-value {
            color: #333;
            font-weight: 500;
        }

        .mission-footer {
            padding: 15px 20px;
            background-color: #f9fafb;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .deadline-badge {
            background-color: #ffeeba;
            color: #856404;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .btn-details {
            background: linear-gradient(to right, var(--primary-color), #4a7ed4);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 18px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-details:hover {
            background: linear-gradient(to right, #2d60b1, #3b71ca);
            transform: scale(1.05);
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(to right, var(--primary-color), #4a7ed4);
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .modal-title {
            font-weight: 700;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin: 20px 0;
        }

        .empty-icon {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-text {
            color: #777;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .mission-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .mission-icon {
                margin-bottom: 10px;
            }

            .mission-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 font-weight-bold text-dark">قائمة المهام</h1>
                <p class="text-muted">المهام المسندة لي</p>
            </div>
        </div>

        <div class="row">
            @forelse ($myMissions as $mission)
                <div class="col-12">
                    <div class="mission-card">
                        <div class="mission-header">
                            <div class="d-flex align-items-center">
                                <div class="mission-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div class="me-3">
                                    <h5 class="mb-0">مهمة جديدة</h5>
                                    <small>تم الإنشاء: {{ $mission->created_at->format('Y-m-d') }}</small>
                                </div>
                            </div>
                            <div>
                                <span class="badge bg-light text-dark">#{{ $mission->id }}</span>
                            </div>
                        </div>

                        <div class="mission-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mission-detail">
                                        <div class="detail-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="detail-content">
                                            <div class="detail-label">الموكل</div>
                                            <div class="detail-value">{{ $mission->client?->name ?? '---' }}</div>
                                        </div>
                                    </div>

                                    <div class="mission-detail">
                                        <div class="detail-icon">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <div class="detail-content">
                                            <div class="detail-label">المسندة بواسطة</div>
                                            <div class="detail-value">{{ $mission->added_by?->name ?? '---' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mission-detail">
                                        <div class="detail-icon">
                                            <i class="fas fa-gavel"></i>
                                        </div>
                                        <div class="detail-content">
                                            <div class="detail-label">المحامي الأول</div>
                                            <div class="detail-value">{{ $mission->first_lawyer->name ?? 'غير محدد' }}</div>
                                        </div>
                                    </div>

                                    <div class="mission-detail">
                                        <div class="detail-icon">
                                            <i class="fas fa-gavel"></i>
                                        </div>
                                        <div class="detail-content">
                                            <div class="detail-label">المحامي الثاني</div>
                                            <div class="detail-value">{{ $mission->second_lawyer->name ?? 'غير محدد' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mission-footer">
                            <div class="deadline-badge">
                                <i class="fas fa-clock me-1"></i>
                                Deadline: {{ $mission->deadline ?? 'غير محدد' }}
                            </div>
                            <button class="btn btn-details" data-toggle="modal"
                                data-target="#missionModal{{ $mission->id }}">
                                <i class="fas fa-eye me-1"></i> عرض التفاصيل
                            </button>
                        </div>
                    </div>
                </div>

                <!-- مودال المهمة -->
                <div class="modal fade" id="missionModal{{ $mission->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">تفاصيل المهمة #{{ $mission->id }}</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mission-detail">
                                            <div class="detail-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">الموكل</div>
                                                <div class="detail-value">{{ $mission->client?->name ?? '---' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mission-detail">
                                            <div class="detail-icon">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">المسندة بواسطة</div>
                                                <div class="detail-value">{{ $mission->added_by?->name ?? '---' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mission-detail">
                                            <div class="detail-icon">
                                                <i class="fas fa-gavel"></i>
                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">المحامي الأول</div>
                                                <div class="detail-value">{{ $mission->first_lawyer->name ?? 'غير محدد' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mission-detail">
                                            <div class="detail-icon">
                                                <i class="fas fa-gavel"></i>
                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">المحامي الثاني</div>
                                                <div class="detail-value">{{ $mission->second_lawyer->name ?? 'غير محدد' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mission-detail mb-3">
                                    <div class="detail-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="detail-content">
                                        <div class="detail-label">الموعد النهائي</div>
                                        <div class="detail-value">{{ $mission->deadline ?? 'غير محدد' }}</div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="font-weight-bold text-dark">وصف المهمة:</h6>
                                    <div class="p-3 bg-light rounded">
                                        {{ $mission->description ?? 'لا يوجد وصف' }}
                                    </div>
                                </div>

                                @if ($mission->file)
                                    <div class="mission-detail">
                                        <div class="detail-icon">
                                            <i class="fas fa-paperclip"></i>
                                        </div>
                                        <div class="detail-content">
                                            <div class="detail-label">الملف المرفق</div>
                                            <a href="{{ asset('storage/' . $mission->file) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-download me-1"></i> تحميل الملف
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h4 class="empty-text">لا توجد مهام حالياً</h4>
                        <p class="text-muted">ليس لديك أي مهام مسندة إليك في الوقت الحالي</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
