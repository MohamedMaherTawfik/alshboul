<?php

namespace App\Livewire;

use App\Models\SettlementAction;
use App\Models\Settlement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SettlementActionList extends Component
{
    use WithPagination;

    public $settlement_id;
    public $search = '';
    public $type = '';
    public $action = '';
    public $deleteId = null;
    public $showDeleteModal = false;
    public $deleteReason = '';
    protected $paginationTheme = 'bootstrap';

    public function mount($settlement_id)
    {
        $this->settlement_id = $settlement_id;
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

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $action = SettlementAction::find($this->deleteId);
        if ($action) {
            $action->notes = $this->deleteReason;
            $action->updated_by = Auth::id();
            $action->save();
            $action->delete();
            session()->flash('success', 'تم حذف الإجراء بنجاح.');
        }
        $this->showDeleteModal = false;
        $this->deleteReason = '';
        $this->deleteId = null;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteReason = '';
        $this->deleteId = null;
    }

    public function render()
    {
        $actions = SettlementAction::where('settlement_id', $this->settlement_id)
            ->when($this->type, fn($q) => $q->where('type', 'like', '%'.$this->type.'%'))
            ->when($this->action, fn($q) => $q->where('action', 'like', '%'.$this->action.'%'))
            ->orderByDesc('id')
            ->paginate(10);
        $settlement = Settlement::find($this->settlement_id);
        return view('livewire.settlement-action-list', compact('actions', 'settlement'));
    }
} 