<?php

namespace App\Livewire;

use App\Models\Settlement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SettlementDeletedList extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function restore($id)
    {
        $settlement = Settlement::withTrashed()->find($id);
        if ($settlement) {
            $settlement->delete_reason = "";
            $settlement->updated_by = Auth::id();
            $settlement->save();
            $settlement->restore();
            session()->flash('success', 'تم استرجاع التسوية بنجاح.');
        }
    }

    public function render()
    {
        $settlements = Settlement::onlyTrashed()
            ->when($this->search, fn($q) => $q->where('subscriber_name', 'like', '%'.$this->search.'%'))
            ->orderByDesc('id')
            ->paginate(10);
        return view('livewire.settlement-deleted-list', compact('settlements'));
    }
} 