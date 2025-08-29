<div>
    @if ($showModal)
        <div id="chatModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 md:bg-transparent md:items-end md:justify-end md:p-4">
            <div
                class="bg-white rounded-lg w-full h-full flex flex-col shadow-lg md:w-full md:max-w-4xl md:h-auto md:max-h-[85vh]">

                <div class="flex-1 flex flex-col md:flex-row min-h-0">
                    {{-- Daftar Kontak --}}
                    <div
                        class="w-full md:w-64 border-b md:border-b-0 md:border-r border-gray-200 p-4 overflow-y-auto flex-shrink-0">
                        <h3 class="font-bold text-lg mb-4">Kontak</h3>
                        <div class="mb-4">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kontak..."
                                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-tertiary">
                        </div>

                        <ul class="space-y-2">
                            @if ($users->isNotEmpty())
                                @foreach ($users->take(10) as $user)
                                    <li wire:click="selectUser({{ $user->id }})"
                                        class="p-2 flex justify-between items-center rounded cursor-pointer {{ optional($selectedUser)->id === $user->id ? 'bg-tertiary/10' : '' }}"
                                        @click.stop>
                                        <span>{{ $user->name }}</span>
                                        @if ($user->unread_messages_count > 0)
                                            <span
                                                class="bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1">
                                                {{ $user->unread_messages_count }}
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <li class="text-sm text-gray-500">Belum ada riwayat percakapan.</li>
                            @endif
                        </ul>
                    </div>

                    {{-- Konten Chat --}}
                    <div class="flex-1 flex flex-col min-h-0">
                        <div class="p-4 md:p-6 border-b border-gray-200 flex-shrink-0">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                                    @if ($selectedUser)
                                        {{ $selectedUser->name }}
                                    @else
                                        Pesan
                                    @endif
                                </h2>
                                <button wire:click="toggleModal"
                                    class="text-gray-500 hover:text-gray-700 text-2xl cursor-pointer">×</button>
                            </div>
                        </div>

                        @if ($selectedUser)
                            {{-- Area Pesan --}}
                            <div x-data x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })"
                                x-on:chat-updated.window="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })"
                                class="flex-1 overflow-y-auto p-4 bg-gray-50 min-h-0">
                                <div class="space-y-4">
                                    @foreach ($messages as $message)
                                        @php
                                            $isSender = $message['sender_id'] === auth()->id();
                                            $bubbleClasses = $isSender
                                                ? 'bg-tertiary text-white ml-auto'
                                                : 'bg-white border border-gray-300';
                                            $alignClasses = $isSender ? 'flex justify-end' : 'flex justify-start';
                                            $timeClasses = $isSender
                                                ? 'text-xs opacity-80 mt-1 block text-right'
                                                : 'text-xs text-gray-500 mt-1 block';
                                        @endphp
                                        <div class="{{ $alignClasses }}">
                                            <div class="rounded-lg p-3 max-w-xs md:max-w-md {{ $bubbleClasses }}">
                                                @if (($message['type'] ?? 'text') === 'text')
                                                    <p class="text-sm">{{ $message['message'] }}</p>
                                                @elseif ($message['type'] === 'image')
                                                    <a href="{{ $message['content']['url'] }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <img src="{{ $message['content']['url'] }}"
                                                            alt="Lampiran gambar"
                                                            class="rounded-lg max-w-full h-auto mb-2">
                                                    </a>
                                                    <p class="text-sm">{{ $message['message'] }}</p>
                                                @elseif ($message['type'] === 'file')
                                                    <div class="flex items-center">
                                                        <i class="fas fa-file-alt text-2xl mr-3"></i>
                                                        <div>
                                                            <a href="{{ $message['content']['url'] }}" target="_blank"
                                                                rel="noopener noreferrer"
                                                                class="underline font-semibold">{{ $message['message'] }}</a>
                                                            <p class="text-xs">File</p>
                                                        </div>
                                                    </div>
                                                @elseif ($message['type'] === 'location')
                                                    <p class="text-sm mb-2">{{ $message['message'] }}</p>
                                                    <a href="https://www.google.com/maps?q={{ $message['content']['latitude'] }},{{ $message['content']['longitude'] }}"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="block bg-gray-200 text-gray-800 text-center p-2 rounded-lg hover:bg-gray-300">
                                                        <i class="fas fa-map-marker-alt mr-2"></i> Lihat Peta
                                                    </a>
                                                @endif
                                                <span class="{{ $timeClasses }}">
                                                    {{ date('H:i', strtotime($message['created_at'])) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Area Input Pesan --}}
                            <div class="p-4 border-t border-gray-200 flex-shrink-0" x-data="{ isUploading: false, progress: 0 }">
                                <div x-show="isUploading" class="mb-2">
                                    <progress max="100" x-bind:value="progress" class="w-full"></progress>
                                </div>
                                <div class="flex items-center">
                                    <button type="button" wire:loading.attr="disabled"
                                        @click="
                                            if (navigator.geolocation) {
                                                navigator.geolocation.getCurrentPosition((position) => {
                                                    $wire.sendLocation({
                                                        latitude: position.coords.latitude,
                                                        longitude: position.coords.longitude
                                                    })
                                                });
                                            } else {
                                                alert('Browser Anda tidak mendukung Geolocation.');
                                            }
                                        "
                                        class="text-gray-500 hover:text-tertiary p-3">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </button>
                                    <input type="file" id="attachment-input" wire:model.live="attachment"
                                        class="hidden" x-on:livewire-upload-start="isUploading = true"
                                        x-on:livewire-upload-finish="isUploading = false"
                                        x-on:livewire-upload-error="isUploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <label for="attachment-input"
                                        class="text-gray-500 hover:text-tertiary p-3 cursor-pointer">
                                        <i class="fas fa-paperclip"></i>
                                    </label>
                                    <form wire:submit.prevent="sendMessage" class="flex-1 flex">
                                        <input type="text" wire:model="message" placeholder="Ketik pesan..."
                                            class="flex-1 border border-gray-300 rounded-l-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary">
                                        <button type="submit"
                                            class="bg-tertiary text-white px-4 md:px-6 py-3 rounded-r-lg hover:bg-tertiary/80 transition">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="flex-1 flex items-center justify-center text-gray-500 p-4 min-h-0">
                                <div class="text-center">
                                    <i class="fas fa-comments text-4xl mb-2"></i>
                                    <p>Pilih kontak dari samping, atau mulai percakapan baru dari halaman layanan.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
