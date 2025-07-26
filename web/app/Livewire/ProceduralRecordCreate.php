<?php

namespace App\Livewire;

use App\Models\ProceduralRecord;
use App\Models\ProceduralFile;
use App\Models\ExecutiveCase;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProceduralRecordCreate extends Component
{
    use WithFileUploads;

    // Form fields
    public $executive_case_id;
    public $session_date;
    public $type;
    public $action;
    public $lawyer = 'عمر الشبول';
    public $notes;
    public $next_action;
    public $next_action_date;
    public $files = [];

    // Related data
    public $executiveCase;
    public $case_id;

    protected $rules = [
        'executive_case_id' => 'required|exists:executive_cases,id',
        'session_date' => 'nullable|date',
        'type' => 'required|string|max:255',
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
        'session_date.date' => 'تاريخ الجلسة يجب أن يكون تاريخ صحيح',
        'type.required' => 'نوع الإجراء مطلوب',
        'action.required' => 'الإجراء مطلوب',
        'lawyer.required' => 'المحامي مطلوب',
        'next_action_date.after_or_equal' => 'تاريخ الإجراء اللاحق يجب أن يكون بعد أو يساوي تاريخ الجلسة',
        'files.*.file' => 'يجب أن يكون الملف صحيح',
        'files.*.mimes' => 'نوع الملف غير مدعوم',
        'files.*.max' => 'حجم الملف يجب أن يكون أقل من 10 ميجابايت'
    ];

    public function mount($case_id = null)
    {
        $this->case_id = $case_id;
        if ($case_id) {
            $this->executive_case_id = $case_id;
            $this->executiveCase = ExecutiveCase::find($case_id);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $proceduralRecord = ProceduralRecord::create([
            'executive_case_id' => $this->executive_case_id,
            'session_date' => $this->session_date,
            'type' => $this->type,
            'action' => $this->action,
            'lawyer' => $this->lawyer,
            'notes' => $this->notes,
            'next_action' => $this->next_action,
            'next_action_date' => $this->next_action_date,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id()
        ]);

        // Handle file uploads
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

        session()->flash('success', 'تم إضافة السجل الإجرائي بنجاح.');

        if ($this->case_id) {
            return redirect()->route('procedural-record.index', $this->case_id);
        } else {
            return redirect()->route('procedural-record.index');
        }
    }

    public function render()
    {
        $executiveCases = ExecutiveCase::with('client')->get();

        return view('livewire.procedural-record-create', [
            'executiveCases' => $executiveCases
        ]);
    }
}
