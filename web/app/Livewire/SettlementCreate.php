<?php

namespace App\Livewire;

use App\Models\Settlement;
use App\Models\Client;
use App\Models\SettlementType;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SettlementCreate extends Component
{
    public $user_id;
    public $subscriber_name;
    public $client_id;
    public $client_national_id;
    public $opponent_name;
    public $opponent_national_id;
    public $settlement_type_id;
    public $judged_for_role;
    public $judged_against_role;
    public $commitment_status;
    public $opponent_phone;
    public $office_file_number;
    public $lawsuit_number;
    public $address;
    public $debt_value;
    public $payment_value;
    public $installment_type;
    public $settlement_details;
    public $clients;
    public $users;
    public $settlementTypes;

    protected $rules = [
        'user_id' => 'nullable|exists:users,id',
        'subscriber_name' => 'nullable|string|max:255',
        'client_id' => 'nullable|exists:clients,id',
        'client_national_id' => 'nullable|string|max:255',
        'opponent_name' => 'nullable|string|max:255',
        'opponent_national_id' => 'nullable|string|max:255',
        'settlement_type_id' => 'nullable|exists:settlement_types,id',
        'judged_for_role' => 'nullable|string|max:255',
        'judged_against_role' => 'nullable|string|max:255',
        'commitment_status' => 'nullable|string|max:255',
        'opponent_phone' => 'nullable|string|max:255',
        'office_file_number' => 'nullable',
        'lawsuit_number' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'debt_value' => 'nullable|numeric',
        'payment_value' => 'nullable|numeric',
        'installment_type' => 'nullable|string|max:255',
        'settlement_details' => 'nullable|string',
    ];

    public function mount()
    {
        $this->clients = Client::all();
        $this->users = User::whereIn('role', ['User'])->get();
        $this->settlementTypes = SettlementType::all();
        $lastFileNumber = Settlement::max('office_file_number') ?? 0;
        $this->office_file_number = $lastFileNumber + 1; // Increment the last file number
    }

    public function updatedUserId($value)
    {
        if ($value) {
            $this->clients = Client::where('user_id', $value)->get();
        } else {
            $this->clients = Client::all();
        }
    }

    public function updatedClientId($value)
    {
        $client = Client::find($value);
        $this->client_national_id = $client?->national_id ?? '';
    }

    public function save()
    {
        $this->validate();
        Settlement::create([
            'user_id' => $this->user_id,
            'subscriber_name' => $this->subscriber_name,
            'client_id' => $this->client_id,
            'client_national_id' => $this->client_national_id,
            'opponent_name' => $this->opponent_name,
            'opponent_national_id' => $this->opponent_national_id,
            'settlement_type_id' => $this->settlement_type_id,
            'judged_for_role' => $this->judged_for_role,
            'judged_against_role' => $this->judged_against_role,
            'commitment_status' => $this->commitment_status,
            'opponent_phone' => $this->opponent_phone,
            'office_file_number' => $this->office_file_number,
            'lawsuit_number' => $this->lawsuit_number,
            'address' => $this->address,
            'debt_value' => $this->debt_value,
            'payment_value' => $this->payment_value,
            'installment_type' => $this->installment_type,
            'settlement_details' => $this->settlement_details,
            'created_by' => Auth::id(),
        ]);
        session()->flash('success', 'تم إضافة التسوية بنجاح.');
        return redirect()->route('settlement.index');
    }

    public function render()
    {
        return view('livewire.settlement-create');
    }
}
