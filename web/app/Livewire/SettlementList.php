<?php

namespace App\Livewire;

use App\Models\Settlement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SettlementList extends Component
{
    use WithPagination;

    public $search = '';
    public $subscriber_name = '';
    public $client_national_id = '';
    public $opponent_name = '';
    public $lawsuit_number = '';
    public $office_file_number = '';
    public $client_id = '';
    public $judged_for = '';
    public $judged_against = '';
    public $deleteReason = '';
    public $deleteId = null;
    public $showDeleteModal = false;
    public $type_id = null;
    protected $paginationTheme = 'bootstrap';
    public function mount($type_id)
    {
        $this->type_id = $type_id;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
  
 public function toggleCommitment($settlementId)
    {
        $settlement = Settlement::findOrFail($settlementId);
        $settlement->commitment_status =
            $settlement->commitment_status === 'ملتزم' ? 'غير ملتزم' : 'ملتزم';

        $settlement->save();
    }
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $settlement = Settlement::find($this->deleteId);
        if ($settlement) {
            $settlement->delete_reason = $this->deleteReason;
            $settlement->updated_by = Auth::id();
            $settlement->save();
            $settlement->delete();
            session()->flash('success', 'تم حذف التسوية بنجاح.');
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
        $query = Settlement::with(['client', 'settlementType']);
        if ($this->type_id) {
            $query->where('settlement_type_id', $this->type_id);
        }


        $query->when($this->subscriber_name, function ($query) {
            $query->whereHas('user', function ($q) {
                $q->where('username', 'like', '%' . $this->subscriber_name . '%');
            });
        })
            ->when($this->client_id, function ($query) {
                $query->whereHas('client', function ($q) {
                    $q->where('name', 'like', '%' . $this->client_id . '%');
                });
            })
            ->when($this->lawsuit_number, function ($query) {
                $query->where('lawsuit_number', 'like', '%' . $this->lawsuit_number . '%');
            })

            ->when($this->opponent_name, function ($query) {
                $query->where('opponent_name', 'like', '%' . $this->opponent_name . '%');
            })

            ->when($this->office_file_number, function ($query) {
                $query->where('office_file_number',  $this->office_file_number);
            })

            ->orderBy('created_at', 'desc');

        $settlements = $query->paginate(10);
        return view('livewire.settlement-list', compact('settlements'));
    }
}
