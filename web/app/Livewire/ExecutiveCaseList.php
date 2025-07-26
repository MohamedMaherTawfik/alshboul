<?php

namespace App\Livewire;

use App\Models\ExecutiveCase;
use App\Models\Client;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ExecutiveCaseList extends Component
{
    use WithPagination;

    public $search = '';
    public $lawsuit_number = '';
    public $subscriber_name = '';
    public $execution_department = '';
    public $client_id = '';
    public $judged_for = '';
    public $judged_against = '';

    public $case_status = '';
    public $deleteReason = '';
    public $deleteId = null;
    public $showDeleteModal = false;
    public $case_id;
    public $type = '';

    protected $paginationTheme = 'bootstrap';

    public function mount($case_id)
    {
        $this->case_id = $case_id;
        // Optionally, you can load the executive case if needed
        switch ($this->case_id) {
            case '1':
                $this->type = 'تنفيذية';
                break;
            case '2':
                $this->type = 'منتهية';
                break;
            case '3':
                $this->type = 'موقوفة';
                break;
            case '4':
                $this->type = 'قضية تنفيذية بإنابة';
                break;
            default:
                $this->type = '';
                break;
        }
        // Initialize any necessary properties or data

    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCaseStatus()
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
        $executiveCase = ExecutiveCase::find($this->deleteId);

        if ($executiveCase) {
            $executiveCase->delete_reason = $this->deleteReason;
            $executiveCase->updated_by = Auth::id();
            $executiveCase->save();
            $executiveCase->delete();

            session()->flash('success', 'تم حذف القضية التنفيذية بنجاح.');
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
        //اسم المشترك , اسم الموكل , رقم الدعوى بحث دائرة التنفيذ بحث المحكوم عليه  بحيث المحكوم له
        $query = ExecutiveCase::where('case_status', $this->type)->with(['client', 'proceduralRecords'])
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

            ->when($this->subscriber_name, function ($query) {
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

            ->when($this->execution_department, function ($query) {
                $query->where('execution_department', 'like', '%' . $this->execution_department . '%');
            })

            ->when($this->judged_for, function ($query) {
                $query->where('judged_for', 'like', '%' . $this->judged_for . '%');
            })
            ->when($this->judged_against, function ($query) {
                $query->where('judged_against', 'like', '%' . $this->judged_against . '%');
            })
            ->orderBy('created_at', 'desc');

        $executiveCases = $query->paginate(10);

        return view('livewire.executive-case-list', [
            'executiveCases' => $executiveCases
        ]);
    }
}
