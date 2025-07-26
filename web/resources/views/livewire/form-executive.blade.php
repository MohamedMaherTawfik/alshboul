<div class="card-body">
    <form action="{{ route('executive-case.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">رقم القضية</label>
                <input type="text" name="case_number" value="{{ old('case_number') }}" class="form-control"
                    placeholder="أدخل رقم القضية">
                @error('case_number')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="">رقم الملف</label>
                <input type="text" name="file_number" value="{{ old('file_number') }}" class="form-control"
                    placeholder="أدخل رقم الملف">
                @error('file_number')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            {{-- <div class="form-group col-md-4">
                <label for="">اسم المدعي</label>
                <input type="text" name="plaintiff_name" value="{{ old('plaintiff_name') }}" class="form-control"
                    placeholder="أدخل اسم المدعي">
                @error('plaintiff_name')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div> --}}
            <div class="form-group col-md-4">
                <label for="">اسم الموكل</label>
                <select wire:model.live="selectedClientId" name="plaintiff_id" value="{{ old('plaintiff_id') }}"
                    class="form-control">
                    <option value="">-- اختر الموكل --</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
                @error('selectedClientId')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">الرقم الوطني للموكل</label>
                <input type="text" class="form-control" name="national_id" value="{{ $nationalId }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="">اسم المدعى عليه</label>
                <input type="text" name="defendant_name" value="{{ old('defendant_name') }}" class="form-control"
                    placeholder="أدخل اسم المدعى عليه">
                @error('defendant_name')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">موقع التنفيذ</label>
                <input type="text" name="execution_location" value="{{ old('execution_location') }}"
                    class="form-control" placeholder="أدخل موقع التنفيذ">
                @error('execution_location')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">نوع التنفيذ</label>
                <select name="execution_type" class="form-control">
                    <option value="">اختر نوع التنفيذ</option>
                    <option value="مالي" {{ old('execution_type') == 'مالي' ? 'selected' : '' }}>مالي</option>
                    <option value="غير مالي" {{ old('execution_type') == 'غير مالي' ? 'selected' : '' }}>غير مالي
                    </option>
                </select>
                @error('execution_type')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="">اسم المحامي</label>
                <select name="execution_id" class="form-control">
                    <option value="">-- اختر موظف --</option>
                    @foreach ($partners as $partner)
                        <option value="{{ $partner->id }}">{{ $partner->username }}</option>
                    @endforeach
                </select>
                @error('execution_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">تاريخ التنفيذ</label>
                <input type="date" name="execution_date" value="{{ old('execution_date') }}" class="form-control">
                @error('execution_date')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">طريقة التنفيذ</label>
                <select name="execution_method" class="form-control">
                    <option value="">اختر طريقة التنفيذ</option>
                    <option value="يدوي" {{ old('execution_method') == 'يدوي' ? 'selected' : '' }}>يدوي</option>
                    <option value="الكتروني" {{ old('execution_method') == 'الكتروني' ? 'selected' : '' }}>الكتروني
                    </option>
                </select>
                @error('execution_method')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">حالة التنفيذ</label>
                <select name="execution_status" class="form-control">
                    <option value="">اختر حالة التنفيذ</option>
                    <option value="منفذ" {{ old('execution_status') == 'منفذ' ? 'selected' : '' }}>منفذ</option>
                    <option value="غير منفذ" {{ old('execution_status') == 'غير منفذ' ? 'selected' : '' }}>غير منفذ
                    </option>
                </select>
                @error('execution_status')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">مصدر التنفيذ</label>
                <select name="execution_source" class="form-control">
                    <option value="">اختر مصدر التنفيذ</option>
                    <option value="الصندوق" {{ old('execution_source') == 'الصندوق' ? 'selected' : '' }}>الصندوق
                    </option>
                    <option value="الفرع" {{ old('execution_source') == 'الفرع' ? 'selected' : '' }}>الفرع</option>
                    <option value="مستند رسمي" {{ old('execution_source') == 'مستند رسمي' ? 'selected' : '' }}>مستند
                        رسمي</option>
                    <option value="إجراء آخر" {{ old('execution_source') == 'إجراء آخر' ? 'selected' : '' }}>إجراء آخر
                    </option>
                </select>
                @error('execution_source')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">رقم المرجع</label>
                <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                    class="form-control" placeholder="أدخل رقم المرجع">
                @error('reference_number')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">تاريخ المرجع</label>
                <input type="date" name="reference_date" value="{{ old('reference_date') }}"
                    class="form-control">
                @error('reference_date')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="">رقم المحكمة أو الحكم</label>
                <input type="text" name="court_or_ruling_number" value="{{ old('court_or_ruling_number') }}"
                    class="form-control" placeholder="أدخل رقم المحكمة أو الحكم">
                @error('court_or_ruling_number')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="">اسم المحكمة أو الحكم</label>
                <input type="text" name="court_or_ruling_name" value="{{ old('court_or_ruling_name') }}"
                    class="form-control" placeholder="أدخل اسم المحكمة أو الحكم">
                @error('court_or_ruling_name')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="">نسخة ملف التنفيذ</label>
                <input type="file" name="execution_file_copy" class="form-control"
                    placeholder="أدخل نسخة ملف التنفيذ">
                @error('execution_file_copy')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="">الحالة</label>
                <select name="status" class="form-control">
                    <option value="">اختر الحالة</option>
                    <option value="جديد" {{ old('status', 'جديد') == 'جديد' ? 'selected' : '' }}>جديد</option>
                    <option value="مؤرشف" {{ old('status') == 'مؤرشف' ? 'selected' : '' }}>مؤرشف</option>
                    <option value="ملغي" {{ old('status') == 'ملغي' ? 'selected' : '' }}>ملغي</option>
                </select>
                @error('status')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label for="">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="أدخل الملاحظات">{{ old('notes') }}</textarea>
                @error('notes')
                    <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="text-center col-md-12">
            <button type="submit" class="btn btn-success">إضافة</button>
        </div>
    </form>
</div>
