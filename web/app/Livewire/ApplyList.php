<?php

namespace App\Livewire;

use App\Models\ApplyCareer;
use App\Models\Career;
use App\Models\Client;
use App\Models\MainAction;
use App\Models\SubAction;
use App\Models\User;
use Livewire\Component;

class ApplyList extends Component
{
    public $search = null;
    public $sortOrder = 'desc';
    public $selectedJob = null;




    public function render()
    {
        $jobs = Career::all();
        $query = ApplyCareer::orderBy('created_at', $this->sortOrder);
        if ($this->search) {
            $query->where('full_name', 'like', '%' . $this->search . '%');
        }

        if ($this->search) {
            $query->where('career_id', $this->selectedJob);
        }
        $data = $query->get();


        return view('livewire.apply-list', compact('data', 'jobs'));
    }
}
