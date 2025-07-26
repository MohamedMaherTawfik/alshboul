<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\MainAction;
use App\Models\SubAction;
use App\Models\User;
use Livewire\Component;
   

class ClientList extends Component
{
    public $search = '';
    public $sortOrder = 'desc'; // الافتراضي أحدث أولًا
    public $selectedClient = null;
    public $status1 = null;
    public $id;
    public $action_date;
    public $entity;
    public $title;
    public $type;
    public $notes;
    public $status;
    public $end_date;
    public $client_id;
    public $show = null;
    public $mainActionId = null;
   public $subAction = [];

   public function loadActivity1($activityId)
    {
        $this->subAction = SubAction::where('main_action_id', $activityId)->get();
        $this->js(<<<'JS'
        window.dispatchEvent(new CustomEvent('show-sub-modal'));
    JS);
    }
    public function selectClient($clientId)
    {
        $this->selectedClient = $clientId;
    }
    public function loadActivity2($activityId)
    {
        $this->mainActionId = $activityId;
        $this->js(<<<'JS'
        window.dispatchEvent(new CustomEvent('show-update1-modal'));
    JS);
    }

    public function loadActivity($activityId)
    {
        $data = MainAction::find($activityId);

        if ($data) {
            $this->id = $data->id;
            $this->action_date = $data->action_date;
            $this->entity = $data->entity;
            $this->title = $data->title;
            $this->type = $data->type;
            $this->notes = $data->notes;
            $this->status = $data->status;
            $this->end_date = $data->end_date;
            $this->client_id = $data->client_id;

            $this->show = 1;
            $this->js(<<<'JS'
            window.dispatchEvent(new CustomEvent('show-update-modal'));
        JS);
        }
    }
    public function render()
    {
        $sub_count = SubAction::count();
        $users = User::whereIn('role', ['superadmin', 'admin', 'Lawyer'])->get();
        $data = Client::where('name', 'like', '%' . $this->search . '%')
            // ->orderBy('created_at', $this->sortOrder)
            ->get();
         $query = MainAction::where('title', 'like', '%' . $this->search . '%')
            ->with(['addedby', 'updateby'])
            ->orderBy('created_at', $this->sortOrder);
        if (!$this->selectedClient == null) {
            $query->where('client_id', $this->selectedClient);
        }
        $mainActions1 = $query->get();

  $sub = $this->subAction;
        return view('livewire.client-list', compact('data', 'mainActions1', 'users', 'sub_count','sub'));
    }
}
