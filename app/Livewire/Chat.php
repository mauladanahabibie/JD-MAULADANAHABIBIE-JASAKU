<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Events\MessageSent;
use App\Models\ChatMessage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $users;
    public $selectedUser;
    public $message = ''; // Properti untuk input pesan
    public array $messages = [];
    public $showModal = false;
    public $loginID;

    protected $listeners = [
        'toggle-chat-modal' => 'toggleModal',
        "echo-private:chat.{loginID},MessageSent" => 'newChatMessageNotification',
    ];

    public function getListeners()
    {
        $authId = Auth::id();
        return [
            'toggle-chat-modal' => 'toggleModal',
            "echo-private:chat.{$authId},MessageSent" => 'newChatMessageNotification',
        ];
    }

    public function mount()
    {
        if (auth()->check()) {
            // Jalankan semua logika ini HANYA jika pengguna sudah login
            $this->users = User::whereNot('id', auth()->user()->id)->get();
            $this->messages = [];

            if ($this->users->isNotEmpty()) {
                $this->selectUser($this->users->first()->id);
            }
        }
    }
    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function selectUser($id)
    {
        $this->selectedUser = User::find($id);
        $this->loadMessages();
    }

    public function sendMessage()
    {
        if (trim($this->message) === '') {
            return;
        }

        $newMessage = ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->message,
        ]);

        $this->messages[] = $newMessage->toArray();

        $this->reset('message');

        broadcast(new MessageSent($newMessage))->toOthers();

        $this->dispatch('chat-updated');
    }

    public function newChatMessageNotification($event)
    {
        // Cek apakah chat yang sedang dibuka adalah pengirim pesan
        if ($this->selectedUser && $event['message']['sender_id'] == $this->selectedUser->id) {

            // Langsung tambahkan ke collection messages di sisi penerima
            $this->messages[] = $event['message'];

            $this->dispatch('chat-updated');
        }
    }

    private function loadMessages()
    {
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
        })->oldest()->get()->toArray();

        $this->dispatch('chat-updated');
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
