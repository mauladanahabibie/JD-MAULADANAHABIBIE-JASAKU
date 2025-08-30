<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use Livewire\Component;
use App\Events\MessageSent;
use App\Models\ChatMessage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

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

    public bool $showOrderForm = false;
    public string $orderDescription = '';
    public $orderPrice = '';
    public ?int $activeServiceId = null;

    protected $rules = [
        'attachment' => 'required|file|mimes:jpg,jpeg,png,gif|max:10240',
        'orderDescription' => 'required|min:10',
        'orderPrice' => 'required|numeric|min:1',
        'activeServiceId' => 'required|exists:services,id',
    ];


    public function getListeners()
    {
        if (!auth()->check()) {
            return [];
        }

        return [
            // Membuat nama event/channel secara dinamis menggunakan ID user yang sedang login
            "echo-private:chat." . auth()->id() . ",MessageSent" => 'newChatMessageNotification',
        ];
    }

    #[On('toggle-chat-modal')]
    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }

    #[On('start-chat')]
    public function startChat(int $userId, ?int $serviceId = null)
    {
        $this->activeServiceId = $serviceId;

        if ($userId == auth()->id()) return;

        $user = User::find($userId);
        if ($user) {
            $this->selectedUser = $user;
            $this->loadMessages();
            if (!$this->users->contains('id', $user->id)) {
                $this->users->prepend($user);
            }
            $this->showModal = true;
            $this->dispatch('chat-updated');
        }
    }

    public function newChatMessageNotification($event)
    {
        $messageData = $event['message'];
        $senderId = $messageData['sender_id'];

        if (($messageData['type'] ?? null) === 'offer_cancelled') {
            $this->loadMessages();
            return;
        }

        if ($this->selectedUser && $senderId == $this->selectedUser->id) {
            if (isset($messageData['service_id']) && $messageData['service_id']) {
                $this->activeServiceId = $messageData['service_id'];
            }
            $this->messages[] = $messageData;
            $this->dispatch('chat-updated');
            ChatMessage::where('id', $messageData['id'])->update(['is_read' => true]);
        }

        $chattedWithUserIds = $this->getChattedUserIds();
        $this->users = User::whereIn('id', $chattedWithUserIds)
            ->withCount('unreadMessages')
            ->orderBy('name')->get();
    }


    public function mount()
    {
        $this->users = collect();
        $this->messages = [];
    }

    public function selectUser($id)
    {
        $this->selectedUser = User::find($id);
        $this->activeServiceId = null;

        ChatMessage::where('sender_id', $id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->loadMessages();
    }

    public function openOrderForm()
    {
        if ($this->activeServiceId && $service = Service::find($this->activeServiceId)) {
            $this->orderDescription = $this->orderDescription ?: "Penawaran untuk jasa: " . $service->name;
            $this->orderPrice = $this->orderPrice ?: $service->price;
        }
        $this->showOrderForm = true;
    }

    public function sendOrderOffer()
    {
        $this->validateOnly('orderDescription');
        $this->validateOnly('orderPrice');
        $this->validateOnly('activeServiceId');
        // $this->validate();

        $newMessage = ChatMessage::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $this->selectedUser->id,
            'message'     => 'Tawaran Order Baru',
            'type'        => 'order_offer',
            'content'     => [
                'description' => $this->orderDescription,
                'price' => $this->orderPrice,
                'status' => 'menunggu_konfirmasi',
                'service_id' => $this->activeServiceId,
            ]
        ]);

        $newMessage->load('service');
        $this->messages[] = $newMessage->toArray();
        broadcast(new MessageSent($newMessage))->toOthers();
        $this->dispatch('chat-updated');

        $this->reset(['showOrderForm', 'orderDescription', 'orderPrice']);
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
    public function acceptOrder($messageId)
    {
        $message = ChatMessage::find($messageId);
        if (!$message || $message->receiver_id !== auth()->id()) {
            return;
        }

        $content = $message->content;
        if ($content['status'] !== 'menunggu_konfirmasi' || empty($content['service_id'])) return;


        $order = Order::create([
            'service_id'  => $content['service_id'] ?? null,
            'customer_id' => $message->receiver_id,
            'mitra_id'    => $message->sender_id,
            'description' => $content['description'],
            'price'       => $content['price'],
            'status'      => Order::STATUS_BELUM_BAYAR,
        ]);

        $content['status'] = 'dikonfirmasi';
        $content['order_id'] = $order->id;
        $message->content = $content;
        $message->save();

        ChatMessage::where('type', 'order_offer')
            ->where(function ($query) use ($message) {
                $query->where('sender_id', $message->sender_id)
                    ->where('receiver_id', $message->receiver_id);
            })
            ->where('id', '!=', $message->id)
            ->chunkById(100, function ($offers) {
                foreach ($offers as $offer) {
                    $offerContent = $offer->content;
                    if (isset($offerContent['status']) && $offerContent['status'] === 'menunggu_konfirmasi') {
                        $offerContent['status'] = 'dibatalkan';
                        $offer->content = $offerContent;
                        $offer->save();
                    }
                }
            });

        broadcast(new MessageSent($message))->toOthers();
        $this->loadMessages();
    }
    public function rejectOrder($messageId)
    {
        $message = ChatMessage::find($messageId);

        if (!$message || $message->receiver_id !== auth()->id()) {
            return;
        }

        $content = $message->content;

        if ($content['status'] !== 'menunggu_konfirmasi') {
            return;
        }

        $content['status'] = 'ditolak';
        $message->content = $content;
        $message->save();

        broadcast(new MessageSent($message))->toOthers();

        $this->loadMessages();
    }
    public function cancelOffer($messageId)
    {
        $message = ChatMessage::find($messageId);

        if (!$message || $message->sender_id !== auth()->id()) {
            return;
        }

        $content = $message->content;
        if (($content['status'] ?? '') !== 'menunggu_konfirmasi') {
            return;
        }

        $receiverId = $message->receiver_id;

        $message->delete();

        $cancellationMarker = new ChatMessage([
            'type' => 'offer_cancelled',
            'sender_id' => auth()->id(), 
            'receiver_id' => $receiverId, 
        ]);

        broadcast(new MessageSent($cancellationMarker))->toOthers();

        $this->loadMessages();
    }
    protected function messages()
    {
        return [
            'activeServiceId.required' => 'Gagal membuat penawaran. Silakan mulai chat dari halaman jasa yang ingin ditawarkan, atau klik "Lihat Jasa" pada chat sebelumnya.',
            'activeServiceId.exists' => 'Jasa yang dipilih tidak valid.',
        ];
    }
    public function sendMessage()
    {
        if (trim($this->message) === '' || !$this->selectedUser) return;

        $newMessage = ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->message,
            'type' => 'text',
            'service_id' => $this->activeServiceId,
        ]);
        $newMessage->load('service');

        $this->messages[] = $newMessage->toArray();
        $this->reset('message');
        broadcast(new MessageSent($newMessage))->toOthers();
        $this->dispatch('chat-updated');

        $this->activeServiceId = null;
        $this->loadMessages();
    }

    public function sendLocation($coordinates)
    {
        if (!$this->selectedUser) return;
        $newMessage = ChatMessage::create(['sender_id' => auth()->id(), 'receiver_id' => $this->selectedUser->id, 'message' => "Lokasi dibagikan", 'type' => 'location', 'content' => $coordinates]);
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
        $newMessage = ChatMessage::create(['sender_id' => auth()->id(), 'receiver_id' => $this->selectedUser->id, 'message' => $attachment->getClientOriginalName(), 'type' => $type, 'content' => ['url' => asset('storage/' . $path)],]);
        $this->messages[] = $newMessage->toArray();
        broadcast(new MessageSent($newMessage))->toOthers();
        $this->dispatch('chat-updated');
    }

    private function loadMessages()
    {
        if (!$this->selectedUser) {
            $this->messages = [];
            return;
        }
        $senderId = auth()->id();
        $receiverId = $this->selectedUser->id;

        $this->messages = ChatMessage::with('service')
            ->where(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
            })->orWhere(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
            })->oldest()->get()->toArray();

        $this->dispatch('chat-updated');
    }
    public function showServicePreview(int $serviceId)
    {
        $this->activeServiceId = $serviceId;
    }
    public function getUsersProperty()
    {
        $myId = auth()->id();
        $myRole = auth()->user()->status;

        if (trim($this->search) !== '') {
            $searchQuery = User::where('id', '!=', $myId)
                ->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%');
                });

            if ($myRole === 'customer') {
                $searchQuery->whereIn('status', ['mitra', 'cs']);
            } elseif ($myRole === 'mitra') {
                $searchQuery->whereIn('status', ['customer', 'cs', 'mitra']);
            }

            return $searchQuery->get();
        }

        $chattedUserIds = ChatMessage::where('sender_id', $myId)
            ->orWhere('receiver_id', $myId)
            ->get(['sender_id', 'receiver_id'])
            ->flatMap(fn($msg) => [$msg->sender_id, $msg->receiver_id])
            ->unique()
            ->reject(fn($id) => $id == $myId);

        return User::whereIn('id', $chattedUserIds)
            ->withCount(['unreadMessages' => function ($query) use ($myId) {
                $query->where('receiver_id', $myId)->where('is_read', false);
            }])
            ->with([
                'sentMessages' => fn($q) => $q->latest()->limit(1),
                'receivedMessages' => fn($q) => $q->latest()->limit(1)
            ])
            ->get()
            ->sortByDesc(function ($user) {
                $lastSent = $user->sentMessages->first()?->created_at;
                $lastReceived = $user->receivedMessages->first()?->created_at;
                return max([$lastSent, $lastReceived]);
            });
    }


    #[Computed]
    public function activeService()
    {
        if ($this->activeServiceId) {
            return Service::find($this->activeServiceId);
        }
        return null;
    }

    public function render()
    {
        if (auth()->check()) {
            $myId = auth()->id();
            $myRole = auth()->user()->status;

            $chattedWithUserIds = ChatMessage::where('sender_id', $myId)
                ->orWhere('receiver_id', $myId)
                ->get(['sender_id', 'receiver_id'])
                ->flatMap(fn($message) => [$message->sender_id, $message->receiver_id])
                ->unique()
                ->reject(fn($id) => $id == $myId);

            $chattedUsers = User::whereIn('id', $chattedWithUserIds)
                ->withCount(['unreadMessages' => function ($query) use ($myId) {
                    $query->where('receiver_id', $myId)->where('is_read', false);
                }])->get();

            $searchedUsers = collect();
            if (trim($this->search) !== '') {

                $searchQuery = User::where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%');
                })
                    ->where('id', '!=', $myId);

                if ($myRole === 'mitra') {
                    $searchQuery->where(function ($q) use ($chattedWithUserIds) {
                        $q->whereIn('status', ['mitra', 'cs'])
                            ->orWhere(function ($q2) use ($chattedWithUserIds) {
                                $q2->where('status', 'customer')
                                    ->whereIn('id', $chattedWithUserIds);
                            });
                    });
                } elseif ($myRole === 'customer') {
                    $searchQuery->where(function ($q) use ($chattedWithUserIds) {
                        $q->whereIn('status', ['mitra', 'cs'])
                            ->orWhere(function ($q2) use ($chattedWithUserIds) {
                                $q2->where('status', 'customer')
                                    ->whereIn('id', $chattedWithUserIds);
                            });
                    });
                } else {
                }

                $searchedUsers = $searchQuery->whereNotIn('id', $chattedWithUserIds)->get();
            }

            $this->users = $chattedUsers->merge($searchedUsers)->sortBy('name');
        }

        return view('livewire.chat');
    }
}
