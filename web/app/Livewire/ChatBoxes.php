<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatBoxes extends Component
{
    public $selectedUser;
    public $messageText;
    public $messages = [];


    protected $rules = [
        'messageText' => 'required|string'
    ];

    public function mount($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $newMessages  = Message::where(function ($query) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $this->selectedUser->id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->selectedUser->id)
                ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();
        $this->messages = array_merge([], $newMessages->toArray());
    }

    public function sendMessage()
    {
     
        $this->validate();
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->messageText
        ]);

        $this->messageText = '';
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat-boxes');
    }
}
