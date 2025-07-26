<?php

namespace App\Livewire;

use App\Models\ExecutiveCase;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ExecutiveCaseDeletedList extends Component
{
    use WithPagination;

    public $search = '';
    public $case_status = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCaseStatus()
    {
        $this->resetPage();
    }

    public function restore($id)
    {
        $executiveCase = ExecutiveCase::withTrashed()->find($id);

        if ($executiveCase) {
            $executiveCase->delete_reason = "";
            $executiveCase->updated_by = Auth::id();
            $executiveCase->save();
            $executiveCase->restore();

            session()->flash('success', 'تم استرجاع القضية التنفيذية بنجاح.');
        }
    }

    public function render()
    {
        $query = ExecutiveCase::onlyTrashed()
            ->with(['client', 'proceduralRecords'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('subscriber_name', 'like', '%' . $this->search . '%')
                      ->orWhere('opponent_name', 'like', '%' . $this->search . '%')
                      ->orWhere('lawsuit_number', 'like', '%' . $this->search . '%')
                      ->orWhere('document_number', 'like', '%' . $this->search . '%')
                      ->orWhere('client_national_id', 'like', '%' . $this->search . '%')
                      ->orWhere('opponent_national_id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->case_status, function ($query) {
                $query->where('case_status', $this->case_status);
            })
            ->orderBy('deleted_at', 'desc');

        $deletedCases = $query->paginate(10);

        return view('livewire.executive-case-deleted-list', [
            'deletedCases' => $deletedCases
        ]);
    }
}
