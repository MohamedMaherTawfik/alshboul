@extends('layouts.admin')

@section('title', 'القوائم الرئيسية')
@section('main_title_content', 'القوائم الرئيسية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('MainTypes.index') }}">القوائم الرئيسية</a>
@endsection

@section('content')
    <div class="container-fluid">
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-list-ul mr-2"></i> القوائم الرئيسية
                </h3>
                <!-- زرار فتح المودال -->
                <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#createMainModal">
                    <i class="fas fa-plus-circle mr-1"></i> إنشاء قائمة جديدة
                </button>
            </div>

            <div class="card-body">
                @if ($main->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p>لا توجد قوائم رئيسية حالياً.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width: 70px;">#</th>
                                    <th>العنوان</th>
                                    <th class="text-center" style="width: 150px;">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($main as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('MainTypes.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من الحذف؟');"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt mr-1"></i> حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- مودال الإنشاء -->
    <div class="modal fade" id="createMainModal" tabindex="-1" role="dialog" aria-labelledby="createMainModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('MainTypes.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="createMainModalLabel">
                            <i class="fas fa-plus-circle mr-1"></i> إنشاء قائمة جديدة
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="إغلاق">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">عنوان القائمة</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror" placeholder="أدخل عنوان القائمة"
                                required>
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> حفظ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card-header {
            border-radius: 0.375rem 0.375rem 0 0 !important;
        }

        table th,
        table td {
            vertical-align: middle !important;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }
    </style>
@endsection
