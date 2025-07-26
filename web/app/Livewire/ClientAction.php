<?php

namespace App\Livewire;

use App\Models\MainAction;
use App\Models\SubAction;
use Livewire\Component;

class ClientAction extends Component
{
    public $clientId;
    public $searchMain = '';
    public $searchSub = '';
    public $id;
    public $action_date;
    public $entity;
    public $title;
    public $type;
    public $notes;
    public $status;
    public $end_date;
    public $client_id;

    public function loadActivity1($activityId)
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

            $this->js(<<<'JS'
            window.dispatchEvent(new CustomEvent('show-update-modal'));
        JS);
        }
    }
    public function render()
    {
        $mainActions = MainAction::where('client_id', $this->clientId)
            ->where('title', 'like', '%' . $this->searchMain . '%')
            ->where('notes', 'like', '%' . $this->searchSub . '%')
            ->with(['addedby', 'updateby'])
            ->orderBy('action_date', 'desc')
            ->get();

        $subActions = SubAction::whereHas('mainAction', function ($query) {
            $query->where('client_id', $this->clientId);
        })
            ->where('details', 'like', '%' . $this->searchSub . '%')
            ->orderBy('action_date', 'desc')
            ->get();
        return view('livewire.client-action', compact('mainActions', 'subActions'));
    }
}
