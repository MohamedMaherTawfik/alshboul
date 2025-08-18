@extends('layouts.admin')
@section('title', 'تعديل أرشيف')
@section('main_title_content', 'قائمة الأرشيف')
@section('title_content', 'تعديل')
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
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">تعديل الأرشيف</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('archive.update', $archive) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <!-- Row 1: Client + Another Names -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_id" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-folder-open me-2 text-primary"></i> اسم المشترك <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="client_id" id="client_id"
                                        class="form-select border-2 border-primary rounded-4 shadow-sm py-2 px-2 @error('client_id') is-invalid border-danger @enderror"
                                        required>
                                        <option value="" disabled>-- اختر من القائمة --</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $archive->client_id == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <div class="invalid-feedback d-block mt-1 fw-bold">{{ $message }}</div>
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
                                        value="{{ old('another_names', $archive->another_names) }}" placeholder="اكتب هنا"
                                        required style="font-size: 0.9rem; max-width: 21%;">
                                </div>
                                @error('another_names')
                                    <div class="invalid-feedback d-block mt-1 fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Row 2: Main Menu + Time -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="main_menu_id" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-folder-open me-2 text-primary"></i> القسم الرئيسي <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="main_menu_id" id="main_menu_id"
                                        class="form-select border-2 border-primary rounded-4 shadow-sm py-2 px-2 @error('main_menu_id') is-invalid border-danger @enderror"
                                        required>
                                        <option value="" disabled>-- اختر من القائمة --</option>
                                        @foreach ($archiveMainMenues as $menu)
                                            <option value="{{ $menu->id }}"
                                                {{ $archive->archivesSubMenues->main_menu_id == $menu->id ? 'selected' : '' }}>
                                                {{ $menu->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('main_menu_id')
                                        <div class="invalid-feedback d-block mt-1 fw-bold">{{ $message }}</div>
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
                                        value="{{ old('time', $archive->time) }}" style="width: 25%;" required>
                                </div>
                            </div>

                            <!-- Row 3: Sub Menu + File -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sub_menu_id" class="form-label fw-bold text-dark mb-2">
                                        <i class="fas fa-list-alt me-2 text-primary"></i> القسم الفرعي <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="sub_menu_id" id="sub_menu_id"
                                        class="form-select border-2 border-primary rounded-4 shadow-sm py-2 px-2 @error('sub_menu_id') is-invalid border-danger @enderror"
                                        required>
                                        <option value="" disabled>-- اختر من القائمة --</option>
                                        @foreach ($archivesSubMenues as $submenu)
                                            <option value="{{ $submenu->id }}" data-parent="{{ $submenu->main_menu_id }}"
                                                {{ $archive->sub_menu_id == $submenu->id ? 'selected' : '' }}>
                                                {{ $submenu->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sub_menu_id')
                                        <div class="invalid-feedback d-block mt-1 fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="file" class="form-label fw-bold text-dark mb-0 me-3">
                                        <i class="fas fa-file-upload me-2 text-primary"></i> الملف
                                    </label>
                                    @if ($archive->file)
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $archive->file) }}" target="_blank"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-file"></i> عرض الملف الحالي
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" name="file" id="file"
                                        class="form-control p-2 border-2 border-primary rounded-4 shadow-sm py-2 px-2 @error('file') is-invalid border-danger @enderror"
                                        style="font-size: 0.9rem; width: 60%;">
                                    @error('file')
                                        <div class="invalid-feedback d-block mt-1 fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- الملاحظة -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">الملاحظة</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
                                placeholder="أدخل أي ملاحظات إضافية">{{ old('notes', $archive->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- حقل مخفي -->
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <!-- زر الإرسال -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="fas fa-save me-2"></i> تحديث
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
        let currentMain = "{{ $archive->archivesSubMenues->main_menu_id ?? '' }}";

        function filterSubMenus(mainId) {
            subMenu.innerHTML = "";
            subMenu.appendChild(new Option("-- اختر من القائمة --", "", true, true));
            subMenu.options[0].disabled = true;

            allOptions.forEach(opt => {
                if (opt.getAttribute("data-parent") === mainId) {
                    subMenu.appendChild(opt);
                }
            });
        }

        if (currentMain) {
            filterSubMenus(currentMain);
            subMenu.value = "{{ $archive->sub_menu_id }}";
        }

        mainMenu.addEventListener("change", function() {
            filterSubMenus(this.value);
        });
    });
</script>
