<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\ChatMessage;

class Chat extends Component
{
    public $users;
    public $selectedUser;
    public $message = ''; 
    public $messages = []; 
    public $showModal = false;

    protected $listeners = ['toggle-chat-modal' => 'toggleModal'];

    public function mount() {
        $this->users = User::whereNot('id', auth()->user()->id)->get();
        $this->selectedUser = $this->users->first();
        $this->loadMessages();
    }
    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function selectUser($id) {
        $this->selectedUser = User::find($id);
        $this->loadMessages();
    }

    public function sendMessage() {
        if ($this->message === '') {
            return;
        }

        ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->message,
        ]);

        $this->message = '';
        $this->loadMessages();
    }

    private function loadMessages() {
        if (!$this->selectedUser) {
            $this->messages = [];
            return;
        }

        $senderId = auth()->id();
        $receiverId = $this->selectedUser->id;

        $this->messages = ChatMessage::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->oldest()->get();
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
