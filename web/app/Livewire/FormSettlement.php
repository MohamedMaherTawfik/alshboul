<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\User;
use Livewire\Component;

class FormSettlement extends Component
{
    public $clients;
    public $selectedClientId;
    public $nationalId;
    public $partners;

    public function mount()
    {
        $this->clients = Client::all();
        $this->partners = User::whereIn('role', ['superadmin', 'admin', 'Lawyer'])->get();
    }

    public function updatedSelectedClientId($value)
    {
        $client = Client::find($value);
        $this->nationalId = $client?->national_id ?? '';
    }
    public function render()
    {
        return view('livewire.form-settlement');
    }
}
