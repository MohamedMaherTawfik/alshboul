@extends('layouts.admin')
@section('title', 'إضافة أرشيف جديد')
@section('main_title_content', 'قائمة الأرشيف')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('archive.index') }}">الأرشيف</a>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- زر الرجوع -->
        <a href="{{ route('archive.index') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> رجوع
        </a>

        <!-- كرت النموذج -->
        <div class="card shadow">
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">إضافة أرشيف جديد</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('archive.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <!-- Row 1: Client + Name -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_id" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-folder-open me-2 text-primary"></i> اسم المشترك <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="client_id" id="client_id"
                                        class="form-select border-2 border-primary rounded-4 shadow-sm py-2 px-2 @error('client_id') is-invalid border-danger @enderror"
                                        required style="font-size: 0.9rem; transition: all 0.3s;">
                                        <option value="" disabled selected class="text-muted">-- اختر من القائمة --
                                        </option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <div class="invalid-feedback d-block mt-1 fw-bold" style="font-size: 0.8rem;">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="another_names" class="form-label fw-bold text-dark mb-0 me-2">
                                        <i class="fas fa-user text-primary"></i>
                                        اطراف اخري <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="another_names" id="another_names"
                                        class="form-control border-2 border-primary rounded-4 shadow-sm py-2 px-2 @error('another_names') is-invalid border-danger @enderror"
                                        value="{{ old('another_names') }}" placeholder="اكتب هنا" required
                                        style="font-size: 0.9rem; max-width: 21%;">
                                </div>
                                @error('another_names')
                                    <div class="invalid-feedback d-block mt-1 fw-bold" style="font-size: 0.8rem;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>



                            <!-- Row 2: Main Menu + Sub Menu -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="main_menu_id" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-folder-open me-2 text-primary"></i> قسم الرئيسي <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="main_menu_id" id="main_menu_id"
                                        class="form-select border-2 border-primary rounded-4 shadow-sm py-2 px-2 @error('main_menu_id') is-invalid border-danger @enderror"
                                        required style="font-size: 0.9rem; transition: all 0.3s;">
                                        <option value="" disabled selected class="text-muted">-- اختر من القائمة --
                                        </option>
                                        @foreach ($archiveMainMenues as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('main_menu_id')
                                        <div class="invalid-feedback d-block mt-1 fw-bold" style="font-size: 0.8rem;">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="time" class="form-label fw-bold text-dark mb-0 me-2">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i> التاريخ <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="date" id="time" name="time"
                                        class="form-control border-2 border-primary rounded-4 shadow-sm py-2 px-2"
                                        style="font-size: 0.9rem; width: 25%;" dir="ltr" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sub_menu_id" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-list-alt me-2 text-primary"></i> قسم الفرعيي <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="sub_menu_id" id="sub_menu_id"
                                        class="form-select border-2 border-primary rounded-4 shadow-sm py-2 px-2 @error('sub_menu_id') is-invalid border-danger @enderror"
                                        required style="font-size: 0.9rem; transition: all 0.3s;">
                                        <option value="" disabled selected class="text-muted">-- اختر من القائمة --
                                        </option>
                                        @foreach ($archivesSubMenues as $submenu)
                                            <option value="{{ $submenu->id }}"
                                                data-parent="{{ $submenu->main_menu_id }}">
                                                {{ $submenu->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sub_menu_id')
                                        <div class="invalid-feedback d-block mt-1 fw-bold" style="font-size: 0.8rem;">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="file" class="form-label fw-bold text-dark mb-0 me-3">
                                        <i class="fas fa-file-upload me-2 text-primary"></i> رفع الملف <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file" id="file"
                                        class="form-control p-2 border-2 border-primary rounded-4 shadow-sm py-2 px-2 @error('file') is-invalid border-danger @enderror"
                                        style="font-size: 0.9rem; width: 22%;" required>
                                </div>
                                @error('file')
                                    <div class="invalid-feedback d-block mt-1 fw-bold" style="font-size: 0.8rem;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        <!-- الملاحظة -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">الملاحظة</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
                                placeholder="أدخل أي ملاحظات إضافية">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- حقل مخفي -->
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <!-- زر الإرسال -->
                        <div class="text-end">
                            <button type="mainmit" class="btn btn-success px-4">
                                <i class="fas fa-save me-2"></i> حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let mainMenu = document.getElementById("main_menu_id");
        let subMenu = document.getElementById("sub_menu_id");
        let allOptions = Array.from(subMenu.options);

        mainMenu.addEventListener("change", function() {
            let selectedMain = this.value;

            // رجع الاختيارات الأصلية
            subMenu.innerHTML = "";

            // أضف الاختيار الافتراضي
            subMenu.appendChild(new Option("-- اختر من القائمة --", "", true, true));
            subMenu.options[0].disabled = true;

            // فلترة الفرعيات تبع الرئيسي
            allOptions.forEach(opt => {
                if (opt.getAttribute("data-parent") === selectedMain) {
                    subMenu.appendChild(opt);
                }
            });

            subMenu.disabled = false;
        });
    });
</script>
