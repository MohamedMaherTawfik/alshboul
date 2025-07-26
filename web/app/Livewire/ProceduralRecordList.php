<?php

namespace App\Livewire;

use App\Models\ProceduralRecord;
use App\Models\ExecutiveCase;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ProceduralRecordList extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $action = '';
    public $lawyer = '';
    public $case_id;
    public $executiveCase;

    public $deleteId = null;
    public $showDeleteModal = false;
    protected $paginationTheme = 'bootstrap';

    public function mount($case_id = null)
    {
        $this->case_id = $case_id;
        if ($case_id) {
            $this->executiveCase = ExecutiveCase::find($case_id);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingAction()
    {
        $this->resetPage();
    }

    public function updatingLawyer()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }
    public function delete()
    {
        $proceduralRecord = ProceduralRecord::find($this->deleteId);

        if ($proceduralRecord) {
            $proceduralRecord->updated_by = Auth::id();
            $proceduralRecord->save();
            $proceduralRecord->delete();

            $this->showDeleteModal = false;
            $this->deleteId = null;
            session()->flash('success', 'تم حذف السجل الإجرائي بنجاح.');
        }
    }
    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $query = ProceduralRecord::with(['case', 'files'])
            ->when($this->case_id, function ($query) {
                $query->where('executive_case_id', $this->case_id);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('type', 'like', '%' . $this->search . '%')
                        ->orWhere('action', 'like', '%' . $this->search . '%')
                        ->orWhere('lawyer', 'like', '%' . $this->search . '%')
                        ->orWhere('notes', 'like', '%' . $this->search . '%')
                        ->orWhere('next_action', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->when($this->action, function ($query) {
                $query->where('action', $this->action);
            })
            ->when($this->lawyer, function ($query) {
                $query->where('lawyer', $this->lawyer);
            })
            ->orderBy('session_date', 'desc');

        $proceduralRecords = $query->paginate(10);

        return view('livewire.procedural-record-list', [
            'proceduralRecords' => $proceduralRecords
        ]);
    }
}
