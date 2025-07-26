<?php

namespace App\Livewire;

use App\Models\Settlement;
use Livewire\Component;

class SettlementShow extends Component
{
    public $settlement;
    public $settlementId;

    public function mount($id)
    {
        $this->settlementId = $id;
        $this->settlement = Settlement::with(['client', 'user', 'settlementType', 'creator', 'updater', 'actions.files'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.settlement-show');
    }
} 