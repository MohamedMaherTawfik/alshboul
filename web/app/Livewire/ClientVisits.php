<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\VisitClient;
use Carbon\Carbon;
use Livewire\Component;

class ClientVisits extends Component
{
    public $search = '';

    public function render()
    {
        $count_visit = VisitClient::count();
        $clients = Client::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->withCount(['visits as recent_visits_count' => function ($query) {
                $query->where('visited_at', '>=', Carbon::now()->subMonth());
            }])
            ->get();

        return view('livewire.client-visits', [
            'data' => $clients,
            'count_visit' => $count_visit
        ]);
    }
}
