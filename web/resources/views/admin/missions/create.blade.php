@extends('layouts.admin')

@section('title', 'المهام')
@section('main_title_content', 'قائمة المهام')
@section('title_content', 'عرض')

@section('link_content')
    <a href="{{ route('mission.unfinished') }}">المهام</a>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- زر الرجوع -->
        <a href="{{ route('mission.unfinished') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> رجوع
        </a>

        <!-- كرت النموذج -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus-circle"></i> إضافة مهمه جديده</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mission.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- العمود الشمال -->
                        <div class="col-md-6">
                            <!-- Client -->
                            <div class="mb-3">
                                <label for="client_id" class="form-label">اختر اسم الموكل هنا</label>
                                <select name="client_id" id="client1" class="form-control" required>
                                    <option value="">-- اختر العميل --</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lawyer 1-->
                            <div class="mb-3">
                                <label for="lawyer1" class="form-label">اختر المحامي الاول</label>
                                <select name="first_lawyer_id" id="lawyer1" class="form-control" required>
                                    <option value="">-- اختر المحامي --</option>
                                    @foreach ($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lawyer 2-->
                            <div class="mb-3">
                                <label for="lawyer2" class="form-label">اختر المحامي الثاني</label>
                                <select name="second_lawyer_id" id="lawyer2" class="form-control" required>
                                    <option value="">-- اختر المحامي --</option>
                                    @foreach ($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- العمود اليمين -->
                        <div class="col-md-6">
                            <!-- Deadline -->
                            <div class="mb-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="deadlineCheck">
                                    <label class="form-check-label" for="deadlineCheck">إضافة موعد نهائي</label>
                                </div>
                                <div id="deadlineWrapper" style="display: none;">
                                    <label for="deadline" class="form-label">اختر الموعد النهائي:</label>
                                    <input type="date" id="deadline" name="deadline" class="form-control">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">الوصف</label>
                                <input type="text" name="description" id="description" class="form-control">
                            </div>

                            <!-- File Input -->
                            <div class="mb-3">
                                <label for="file" class="form-label">إرفاق ملف</label>
                                <input type="file" name="file" id="file" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- زر الإرسال -->
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> حفظ
                        </button>
                    </div>
                </form>

                <!-- JavaScript -->
                <script>
                    document.getElementById('deadlineCheck').addEventListener('change', function() {
                        document.getElementById('deadlineWrapper').style.display = this.checked ? 'block' : 'none';
                    });
                </script>

            </div>
        </div>
    </div>

@endsection
