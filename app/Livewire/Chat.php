<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Chat extends Component
{
    use WithFileUploads;

    public $users;
    public ?User $selectedUser = null;
    public string $message = '';
    public array $messages = [];
    public bool $showModal = false;
    public $attachment;
    public string $search = '';

    protected $rules = [
        'attachment' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,zip|max:10240', // Maks 10MB
    ];

    public function getListeners()
    {
        $authId = Auth::id();
        if (!$authId) return [];

        return [
            'toggle-chat-modal' => 'toggleModal',
            'start-chat' => 'startChat',
            "echo-private:chat.{$authId},MessageSent" => 'newChatMessageNotification',
        ];
    }

    public function mount()
    {
        if (auth()->check()) {
            $this->users = collect();
        } else {
            $this->users = collect();
        }
        $this->messages = [];
    }

    public function startChat($payload)
    {
        $userId = $payload['userId'];
        if ($userId == auth()->id()) return;

        $user = User::find($userId);
        if ($user) {
            $this->selectedUser = $user;
            $this->loadMessages();

            // Memastikan user yang dipilih ada di daftar pengguna
            if (!$this->users->contains('id', $user->id)) {
                $this->users->prepend($user);
            }

            $this->showModal = true;
            $this->dispatch('chat-updated');
        }
    }

    private function getChattedUserIds()
    {
        $myId = auth()->id();
        return ChatMessage::where('sender_id', $myId)
            ->orWhere('receiver_id', $myId)
            ->get(['sender_id', 'receiver_id'])
            ->flatMap(fn($message) => [$message->sender_id, $message->receiver_id])
            ->unique()
            ->reject(fn($id) => $id == $myId);
    }

    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function selectUser($id)
    {
        $this->selectedUser = User::find($id);

        ChatMessage::where('sender_id', $id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->loadMessages();
    }

    public function sendMessage()
    {
        if (trim($this->message) === '' || !$this->selectedUser) return;

        $newMessage = ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->message,
            'type' => 'text',
        ]);

        $this->messages[] = $newMessage->toArray();
        $this->reset('message');
        broadcast(new MessageSent($newMessage))->toOthers();
        $this->dispatch('chat-updated');
    }

    public function sendLocation($coordinates)
    {
        if (!$this->selectedUser) return;

        $newMessage = ChatMessage::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $this->selectedUser->id,
            'message'     => "Lokasi dibagikan",
            'type'        => 'location',
            'content'     => $coordinates,
        ]);

        $this->messages[] = $newMessage->toArray();
        broadcast(new MessageSent($newMessage))->toOthers();
        $this->dispatch('chat-updated');
    }

    public function updatedAttachment($attachment)
    {
        if (!$this->selectedUser) return;
        $this->validateOnly('attachment');

        $path = $attachment->store('chat', 'public');
        $type = str_starts_with($attachment->getMimeType(), 'image/') ? 'image' : 'file';

        $newMessage = ChatMessage::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $this->selectedUser->id,
            'message'     => $attachment->getClientOriginalName(),
            'type'        => $type,
            'content'     => ['url' => asset('storage/' . $path)],
        ]);

        $this->messages[] = $newMessage->toArray();
        broadcast(new MessageSent($newMessage))->toOthers();
        $this->dispatch('chat-updated');
    }

    public function newChatMessageNotification($event)
    {
        $messageData = $event['message'];
        $senderId = $messageData['sender_id'];

        if ($this->selectedUser && $senderId == $this->selectedUser->id) {
            $this->messages[] = $messageData;
            $this->dispatch('chat-updated');
            ChatMessage::where('id', $messageData['id'])->update(['is_read' => true]);
        }
        
        // Memuat ulang daftar pengguna jika ada pesan baru dari pengguna yang belum ada di daftar
        $chattedWithUserIds = $this->getChattedUserIds();
        $this->users = User::whereIn('id', $chattedWithUserIds)
            ->withCount('unreadMessages')
            ->orderBy('name')->get();
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
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })
            ->oldest()->get()->toArray();

        $this->dispatch('chat-updated');
    }

    public function render()
    {
        if (auth()->check()) {
            $myId = auth()->id();
            
            // Mengambil daftar pengguna yang sudah pernah di chat
            $chattedWithUserIds = $this->getChattedUserIds();

            // Mengambil semua user yang sesuai dengan search query, kecuali diri sendiri
            $allUsersQuery = User::where('id', '!=', $myId)
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->withCount(['unreadMessages' => function ($query) use ($myId) {
                    $query->where('receiver_id', $myId)
                        ->where('is_read', false);
                }]);
            
            $this->users = $allUsersQuery->orderBy('name')->get();
        }

        return view('livewire.chat');
    }
}