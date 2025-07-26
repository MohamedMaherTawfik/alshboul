<div class="card">
    <div class="card-header">
        <h3 class="card-title">إضافة إجراء جديد للتسوية: {{ $settlement->user->name }}</h3>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="save">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>تاريخ الإجراء <span class="text-danger">*</span></label>
                        <input type="date" wire:model="action_date" class="form-control @error('action_date') is-invalid @enderror">
                        @error('action_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>نوع الإجراء <span class="text-danger">*</span></label>
                        <input type="text" wire:model="type" class="form-control @error('type') is-invalid @enderror">
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>الإجراء <span class="text-danger">*</span></label>
                <textarea wire:model="action" class="form-control @error('action') is-invalid @enderror" rows="3"></textarea>
                @error('action')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>ملاحظات</label>
                <textarea wire:model="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"></textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>الإجراء التالي</label>
                        <textarea wire:model="next_action" class="form-control @error('next_action') is-invalid @enderror" rows="3"></textarea>
                        @error('next_action')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>تاريخ الإجراء التالي</label>
                        <input type="date" wire:model="next_action_date" class="form-control @error('next_action_date') is-invalid @enderror">
                        @error('next_action_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="files">الملفات المرفقة</label>
                <input wire:model="files" type="file" class="form-control @error('files.*') is-invalid @enderror" multiple>
                <small class="form-text text-muted">
                    يمكنك رفع ملفات PDF, DOC, DOCX, JPG, JPEG, PNG. الحد الأقصى 10 ميجابايت لكل ملف.
                </small>
                @error('files.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> إضافة الإجراء
                </button>
                <a href="{{ route('settlement-action.list', $settlement->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div> 