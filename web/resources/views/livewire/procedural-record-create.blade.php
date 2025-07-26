<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">
                إضافة سجل إجرائي جديد
                @if ($case_id)
                    <a href="{{ route('procedural-record.index', $case_id) }}" class="btn btn-secondary">العودة
                        للقائمة</a>
                @else
                    <a href="{{ route('procedural-record.index') }}" class="btn btn-secondary">العودة للقائمة</a>
                @endif
            </h3>
        </div>
        <div class="card-body">
            <form wire:submit="save">
                <div class="row">
                    <!-- Executive Case Selection -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="executive_case_id">القضية التنفيذية <span class="text-danger">*</span></label>
                            <select wire:model="executive_case_id"
                                class="form-control @error('executive_case_id') is-invalid @enderror"
                                {{ $case_id ? 'disabled' : '' }}>
                                <option value="">اختر القضية التنفيذية</option>
                                @foreach ($executiveCases as $case)
                                    <option value="{{ $case->id }}">
                                        {{ $case->id ?? 'غير محدد' }} - {{ $case->client->name ?? 'غير محدد' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('executive_case_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Session Date -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="session_date">تاريخ الجلسة <span class="text-danger">*</span></label>
                            <input wire:model="session_date" type="date"
                                class="form-control @error('session_date') is-invalid @enderror">
                            @error('session_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lawyer">المحامي <span class="text-danger">*</span></label>
                            <input wire:model="lawyer" class="form-control @error('lawyer') is-invalid @enderror">
                            @error('lawyer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type">النوع <span class="text-danger">*</span></label>
                            <select wire:model="type" class="form-control @error('type') is-invalid @enderror">
                                <option value="">اختر النوع</option>
                                <option value="إجراء">إجراء</option>
                                <option value="جلسة">جلسة</option>
                                <option value="مذكرة">مذكرة</option>
                                <option value="قرار">قرار</option>
                                <option value="تنفيذ">تنفيذ</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="action">الاجراء</label>
                    <textarea wire:model="action" class="form-control @error('action') is-invalid @enderror" rows="3"
                        placeholder="أدخل الملاحظات هنا..."></textarea>
                    @error('action')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes">الملاحظات</label>
                    <textarea wire:model="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"
                        placeholder="أدخل الملاحظات هنا..."></textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Next Action -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="next_action">الإجراء اللاحق</label>
                            <textarea wire:model="next_action" class="form-control @error('next_action') is-invalid @enderror" rows="3"
                                placeholder="أدخل الاجراء اللاحق هنا..."></textarea>
                            @error('next_action')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Next Action Date -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="next_action_date">تاريخ الإجراء اللاحق</label>
                            <input wire:model="next_action_date" type="date"
                                class="form-control @error('next_action_date') is-invalid @enderror">
                            @error('next_action_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- File Upload -->
                <div class="form-group">
                    <label for="files">الملفات المرفقة</label>
                    <input wire:model="files" type="file" class="form-control @error('files.*') is-invalid @enderror"
                        multiple>
                    <small class="form-text text-muted">
                        يمكنك رفع ملفات PDF, DOC, DOCX, JPG, JPEG, PNG. الحد الأقصى 10 ميجابايت لكل ملف.
                    </small>
                    @error('files.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> حفظ السجل الإجرائي
                    </button>
                    @if ($case_id)
                        <a href="{{ route('procedural-record.index', $case_id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                    @else
                        <a href="{{ route('procedural-record.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
