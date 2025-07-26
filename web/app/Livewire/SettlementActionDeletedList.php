<?php

namespace App\Livewire;

use App\Models\SettlementAction;
use App\Models\Settlement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SettlementActionDeletedList extends Component
{
    use WithPagination;

    public $settlement_id;
    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function mount($settlement_id)
    {
        $this->settlement_id = $settlement_id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function restore($id)
    {
        $action = SettlementAction::withTrashed()->find($id);
        if ($action) {
            $action->notes = '';
            $action->updated_by = Auth::id();
            $action->save();
            $action->restore();
            session()->flash('success', 'تم استرجاع الإجراء بنجاح.');
        }
    }

    public function render()
    {
        $actions = SettlementAction::onlyTrashed()
            ->where('settlement_id', $this->settlement_id)
            ->when($this->search, fn($q) => $q->where('type', 'like', '%'.$this->search.'%'))
            ->orderByDesc('id')
            ->paginate(10);
        $settlement = Settlement::find($this->settlement_id);
        return view('livewire.settlement-action-deleted-list', compact('actions', 'settlement'));
    }
} 