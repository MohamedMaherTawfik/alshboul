<?php

namespace App\Livewire;

use App\Models\SettlementAction;
use App\Models\Settlement;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class SettlementActionCreate extends Component
{
    use WithFileUploads;
    public $settlement_id;
    public $action_date;
    public $type;
    public $action;
    public $notes;
    public $next_action;
    public $next_action_date;
    public $files = [];

    public function mount($settlement_id)
    {
        $this->settlement_id = $settlement_id;
    }

    protected $rules = [
        'action_date' => 'required|date',
        'type' => 'required|string|max:255',
        'action' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'next_action' => 'nullable|string|max:255',
        'next_action_date' => 'nullable|date|after_or_equal:action_date',
        'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
    ];

    public function save()
    {
        $this->validate();
        $settlementAction = SettlementAction::create([
            'settlement_id' => $this->settlement_id,
            'action_date' => $this->action_date,
            'type' => $this->type,
            'action' => $this->action,
            'notes' => $this->notes,
            'next_action' => $this->next_action,
            'next_action_date' => $this->next_action_date,
            'created_by' => Auth::id(),
        ]);
        // Handle file uploads
        if ($this->files) {
            foreach ($this->files as $file) {
                if ($file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('settlement_files', $fileName, 'public');
                    \App\Models\SettlementFile::create([
                        'settlement_action_id' => $settlementAction->id,
                        'file_path' => $filePath,
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);
                }
            }
        }
        session()->flash('success', 'تم إضافة الإجراء بنجاح.');
        return redirect()->route('settlement-action.list', $this->settlement_id);
    }

    public function render()
    {
        $settlement = Settlement::find($this->settlement_id);
        return view('livewire.settlement-action-create', compact('settlement'));
    }
} 