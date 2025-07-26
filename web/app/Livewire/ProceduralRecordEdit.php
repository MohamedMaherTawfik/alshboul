<?php

namespace App\Livewire;

use App\Models\ProceduralRecord;
use App\Models\ProceduralFile;
use App\Models\ExecutiveCase;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProceduralRecordEdit extends Component
{
    use WithFileUploads;

    // Form fields
    public $proceduralRecord;
    public $executive_case_id;
    public $session_date;
    public $type;
    public $action;
    public $lawyer;
    public $notes;
    public $next_action;
    public $next_action_date;
    public $files = [];
    public $existingFiles = [];

    // Related data
    public $executiveCase;

    protected $rules = [
        'executive_case_id' => 'required|exists:executive_cases,id',
        'session_date' => 'nullable|date',
        'type' => 'nullable|string|max:255',
        'action' => 'nullable|string|max:255',
        'lawyer' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'next_action' => 'nullable|string|max:255',
        'next_action_date' => 'nullable|date|after_or_equal:session_date',
        'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
    ];

    protected $successs = [
        'executive_case_id.required' => 'يجب اختيار القضية التنفيذية',
        'executive_case_id.exists' => 'القضية التنفيذية غير موجودة',
        'session_date.required' => 'تاريخ الجلسة مطلوب',
        'session_date.date' => 'تاريخ الجلسة يجب أن يكون تاريخ صحيح',
        'type.required' => 'نوع الإجراء مطلوب',
        'action.required' => 'الإجراء مطلوب',
        'lawyer.required' => 'المحامي مطلوب',
        'next_action_date.after_or_equal' => 'تاريخ الإجراء اللاحق يجب أن يكون بعد أو يساوي تاريخ الجلسة',
        'files.*.file' => 'يجب أن يكون الملف صحيح',
        'files.*.mimes' => 'نوع الملف غير مدعوم',
        'files.*.max' => 'حجم الملف يجب أن يكون أقل من 10 ميجابايت'
    ];

    public function mount($id)
    {
        $this->proceduralRecord = ProceduralRecord::with(['case', 'files'])->findOrFail($id);
        $this->executive_case_id = $this->proceduralRecord->executive_case_id;
        $this->session_date = $this->proceduralRecord->session_date;
        $this->type = $this->proceduralRecord->type;
        $this->action = $this->proceduralRecord->action;
        $this->lawyer = $this->proceduralRecord->lawyer;
        $this->notes = $this->proceduralRecord->notes;
        $this->next_action = $this->proceduralRecord->next_action;
        $this->next_action_date = $this->proceduralRecord->next_action_date;
        $this->existingFiles = $this->proceduralRecord->files;

        $this->executiveCase = $this->proceduralRecord->case;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function deleteFile($fileId)
    {
        $file = ProceduralFile::find($fileId);
        if ($file && $file->procedural_record_id == $this->proceduralRecord->id) {
            // Delete physical file
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }

            // Delete database record
            $file->delete();

            // Refresh existing files
            $this->existingFiles = $this->proceduralRecord->fresh()->files;

            session()->flash('success', 'تم حذف الملف بنجاح.');
        }
    }

    public function save()
    {
        $this->validate();

        $this->proceduralRecord->update([
            'executive_case_id' => $this->executive_case_id,
            'session_date' => $this->session_date,
            'type' => $this->type,
            'action' => $this->action,
            'lawyer' => $this->lawyer,
            'notes' => $this->notes,
            'next_action' => $this->next_action,
            'next_action_date' => $this->next_action_date,
            'updated_by' => Auth::id()
        ]);

        // Handle new file uploads
        if ($this->files) {
            foreach ($this->files as $file) {
                if ($file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('procedural_files', $fileName, 'public');

                    ProceduralFile::create([
                        'procedural_record_id' => $this->proceduralRecord->id,
                        'file_path' => $filePath,
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id()
                    ]);
                }
            }
        }

        session()->flash('success', 'تم تحديث السجل الإجرائي بنجاح.');

        return redirect()->route('procedural-record.index', $this->executive_case_id);
    }

    public function render()
    {
        $executiveCases = ExecutiveCase::with('client')->get();

        return view('livewire.procedural-record-edit', [
            'executiveCases' => $executiveCases
        ]);
    }
}
