<?php

namespace App\Livewire;

use App\Models\ExecutiveCase;
use App\Models\Client;
use App\Models\ProceduralRecord;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ExecutiveCaseCreate extends Component
{
    // Form fields
    public $user_id;
    public $subscriber_name;
    public $client_id;
    public $client_national_id;
    public $opponent_name;
    public $opponent_national_id;
    public $office_file_number;
    public $lawsuit_number;
    public $suggested_file_number;
    public $case_status;
    public $claim_value;
    public $execution_department;
    public $document_type;
    public $judged_for;
    public $judged_against;
    public $registration_date;
    public $document_number;
    public $judged_for_role;
    public $judged_against_role;
    public $client_national_id1;
    public $client_name = null;
    public $session_date = null;

    // Related data
    public $clients;
    public $users;

    protected $rules = [
        'user_id' => 'nullable|exists:users,id',
        'subscriber_name' => 'nullable|string|max:255',
        'client_id' => 'nullable|exists:clients,id',
        'client_national_id1' => 'nullable|string|max:255',
        'opponent_name' => 'nullable|string|max:255',
        'opponent_national_id' => 'nullable|string|max:255',
        'office_file_number' => 'nullable|integer',
        'lawsuit_number' => 'nullable|string|max:255',
        'suggested_file_number' => 'nullable|integer',
        'case_status' => 'nullable|in:تنفيذية,منتهية,موقوفة,قضية تنفيذية بإنابة',
        'claim_value' => 'nullable|numeric|min:0',
        'execution_department' => 'nullable|string|max:255',
        'document_type' => 'nullable|string|max:255',
        'judged_for' => 'nullable|string|max:255',
        'judged_against' => 'nullable|string|max:255',
        'registration_date' => 'nullable|date',
        'document_number' => 'nullable|string|max:255',
        'judged_for_role' => 'nullable|string|max:255',
        'judged_against_role' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        // Load related data
        $lastFileNumber = ExecutiveCase::max('office_file_number') ?? 0;
        $this->office_file_number = $lastFileNumber + 1; // Increment the last file number
        $this->suggested_file_number = $this->office_file_number; // Set suggested file number to the same value
        $this->clients = Client::all();
        $this->users = User::whereIn('role', ['User'])->get();
    }
    public function updatedUserId($value)
    {
        if ($value) {
            $this->clients = Client::where('user_id', $value)->get();
        } else {
            $this->clients = Client::all();
        }
    }
    public function updatedOfficeFileNumber($value)
    {
        $this->suggested_file_number = $value; // Automatically set suggested file number to the office file number
    }

    public function updatedClientId($value)
    {
        if ($value) {
            $client = Client::find($value);
            $this->client_national_id = $client?->national_id ?? '';
        } else {
            $this->client_national_id = '';
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->client_name) {
            Client::create([
                'user_id' => $this->user_id,
                'name' => $this->client_name,
                'national_id' => $this->client_national_id1,
                'added_by' => Auth::id(),
            ]);
        }
        $data = ExecutiveCase::create([
            'user_id' => $this->user_id,
            'subscriber_name' => $this->subscriber_name,
            'client_id' => $this->client_id,
            'client_national_id' => $this->client_national_id1,
            'opponent_name' => $this->opponent_name,
            'opponent_national_id' => $this->opponent_national_id,
            'office_file_number' => $this->office_file_number,
            'lawsuit_number' => $this->lawsuit_number,
            'suggested_file_number' => $this->suggested_file_number,
            'case_status' => $this->case_status,
            'claim_value' => $this->claim_value,
            'execution_department' => $this->execution_department,
            'document_type' => $this->document_type,
            'judged_for' => $this->judged_for,
            'judged_against' => $this->judged_against,
            'registration_date' => $this->registration_date,
            'document_number' => $this->document_number,
            'judged_for_role' => $this->judged_for_role,
            'judged_against_role' => $this->judged_against_role,
            'created_by' => Auth::id(),
        ]);

        $id = null;
        switch ($this->case_status) {
            case 'تنفيذية':
                $id = 1;
                break;
            case 'منتهية':
                $id = 2;
                break;
            case 'موقوفة':
                $id = 3;
                break;
            case 'قضية تنفيذية بإنابة':
                $id = 4;
                break;
            default:
                $id = 1;
                break;
        }
        if (!$data) {
            session()->flash('error', 'حدث خلل أثناء إضافة القضية التنفيذية.');
            return redirect()->route('executive-case.index', $id);
        }
        if ($this->session_date) {
            ProceduralRecord::create([
                'executive_case_id' => $data->id,
                'action' => '',
                'action_date' => now(),
                'session_date' => $this->session_date,
                'type' => 'إجراء',
                'lawyer' => 'عمر الشبول',
                'created_by' => Auth::id(),
            ]);
        }

        session()->flash('success', 'تم إضافة القضية التنفيذية بنجاح.');

        return redirect()->route('executive-case.index', $id);
    }

    public function render()
    {
        return view('livewire.executive-case-create');
    }
}
