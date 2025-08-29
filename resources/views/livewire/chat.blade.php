<div>
    @if ($showModal)
        <div id="chatModal"
            class="fixed bottom-0 right-0 left-0 md:left-auto md:right-1 flex items-center justify-center z-50 p-2 md:p-4">
            <div
                class="bg-white rounded-lg w-full max-w-4xl max-h-[90vh] flex flex-col md:flex-row shadow-lg md:shadow-2xl">
                <button id="closeChatModal"
                    class="md:hidden absolute top-2 right-5 md:right-2 text-gray-500 hover:text-gray-700 text-2xl cursor-pointer z-10">&times;</button>

                <div
                    class="w-full md:w-64 border-b md:border-b-0 md:border-r max-h-[70vh] md:max-h-max border-gray-200 p-4 overflow-y-auto">
                    <h3 class="font-bold text-lg mb-4">Kontak</h3>
                    <ul class="space-y-2">
                        @if ($users)
                            @foreach ($users as $user)
                                <li wire:click="selectUser({{ $user->id }})"
                                    class="p-2 rounded cursor-pointer {{ $selectedUser->id === $user->id ? 'bg-tertiary/10' : '' }}"
                                    @click.stop>
                                    {{ $user->name }}
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div class="flex-1 flex flex-col h-[70vh] md:h-auto">
                    <div class="p-4 md:p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800">{{ $selectedUser->name }}</h2>
                            <button id="closeChatModalDesktop" wire:click="toggleModal"
                                class="hidden md:block text-gray-500 hover:text-gray-700 text-2xl cursor-pointer">&times;</button>
                        </div>
                    </div>

                    <div x-data x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })"
                        x-on:chat-updated.window="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })"
                        class="flex-1 overflow-y-auto p-4 bg-gray-50">
                        <div class="space-y-4">
                            @foreach ($messages as $message)
                                @if ($message['sender_id'] === auth()->id())
                                    <div class="flex justify-end">
                                        <div class="bg-tertiary text-white rounded-lg p-3 max-w-xs md:max-w-md">
                                            <p class="text-sm">{{ $message['message'] }}</p>
                                            <span class="text-xs opacity-80 mt-1 block text-right">
                                                {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex justify-start">
                                        <div
                                            class="bg-white border border-gray-300 rounded-lg p-3 max-w-xs md:max-w-md">
                                            <p class="text-sm">{{ $message['message'] }}</p>
                                            <span class="text-xs text-gray-500 mt-1 block">
                                                {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="p-4 border-t border-gray-200">
                        <form wire:submit.prevent="sendMessage" class="flex">
                            <input type="text" wire:model="message" placeholder="Ketik pesan..."
                                class="flex-1 border border-gray-300 rounded-l-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary">
                            <button type="submit"
                                class="bg-tertiary text-white px-4 md:px-6 py-3 rounded-r-lg hover:bg-tertiary/80 transition">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
