<div>
    @if ($showModal)
        <div id="chatModal" x-data="{ isImageModalOpen: false, imageModalUrl: '', imageModalFilename: '' }"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 md:bg-transparent md:items-end md:justify-end md:p-4">
            <div
                class="bg-white rounded-lg w-full h-full flex flex-col shadow-lg md:w-full md:max-w-4xl md:h-auto md:max-h-[85vh]">

                <div class="flex-1 flex flex-col md:flex-row min-h-0">
                    {{-- Daftar Kontak --}}
                    <div
                        class="w-full md:w-64 border-b md:border-b-0 md:border-r border-gray-200 p-4 overflow-y-auto flex-shrink-0">
                        <h3 class="font-bold text-lg mb-4">Kontak</h3>
                        <div class="mb-4">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Cari Berdasarkan Nama atau Username..."
                                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-tertiary">
                        </div>
                        <ul class="space-y-2">
                            @if ($this->users && $this->users->isNotEmpty())
                                @foreach ($this->users as $user)
                                    <li wire:click="selectUser({{ $user->id }})"
                                        class="p-2 flex items-center rounded cursor-pointer {{ optional($selectedUser)->id === $user->id ? 'bg-tertiary/10' : '' }} relative"
                                        @click.stop>
                                        <img class="w-8 h-8 rounded-full object-cover mr-2"
                                            src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://i.pinimg.com/736x/01/b8/45/01b845d2aad2d8bdb28554f7ecb999da.jpg' }}"
                                            alt="">

                                        <div>
                                            <div class="flex gap-3 items-center">
                                                <span class="truncate">{{ $user->name }} </span>
                                                <span
                                                    class="border border-gray-300 text-xs rounded-full px-2 py-1 flex-shrink-0">
                                                    {{ $user->status }}
                                                </span>
                                                @if ($user->unread_messages_count > 0)
                                                    <span
                                                        class="bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1 flex-shrink-0 absolute left-0 top-0">
                                                        {{ $user->unread_messages_count }}
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-gray-500">{{ '@' . $user->username }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-sm text-gray-500">
                                    {{ $search ? 'Tidak ada hasil pencarian.' : 'Belum ada riwayat percakapan.' }}
                                </li>
                            @endif
                        </ul>

                    </div>

                    {{-- Konten Chat --}}
                    <div class="flex-1 flex flex-col min-h-0 relative">
                        {{-- HEADER (Selalu Terlihat) --}}
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

                        {{-- KONTEN UTAMA (Kondisional) --}}
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
                                                    <a href="#"
                                                        @click.prevent="
        imageModalUrl = '{{ $message['content']['url'] }}'; 
        imageModalFilename = '{{ $message['message'] }}'; 
        isImageModalOpen = true;"
                                                        rel="noopener noreferrer">
                                                        <img src="{{ $message['content']['url'] }}"
                                                            alt="Lampiran gambar"
                                                            class="rounded-lg max-w-full h-60 mb-2">
                                                    </a>
                                                    <p class="text-sm">{{ $message['message'] }}</p>
                                                @elseif ($message['type'] === 'file')
                                                    <div class="flex items-center"> <i
                                                            class="fas fa-file-alt text-2xl mr-3"></i>
                                                        <div>
                                                            <a href="{{ $message['content']['url'] }}" target="_blank"
                                                                rel="noopener noreferrer"
                                                                class="underline font-semibold">{{ $message['message'] }}</a>
                                                            <p class="text-xs">File</p>
                                                        </div>
                                                    </div>
                                                @elseif ($message['type'] === 'location')
                                                    <p class="text-sm mb-2">{{ $message['message'] }}</p>
                                                    <a href="https://www.openstreetmap.org/?mlat={{ $message['content']['latitude'] }}&mlon={{ $message['content']['longitude'] }}#map=16/{{ $message['content']['latitude'] }}/{{ $message['content']['longitude'] }}"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="block bg-gray-200 text-gray-800 text-center p-2 rounded-lg hover:bg-gray-300">
                                                        <i class="fas fa-map-marker-alt mr-2"></i> Lihat Peta
                                                    </a>
                                                @elseif ($message['type'] === 'order_offer')
                                                    <div
                                                        class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 w-full text-black">
                                                        <div class="flex items-center mb-2">
                                                            <i
                                                                class="fas fa-file-invoice-dollar text-indigo-500 mr-3 text-xl"></i>
                                                            <h4 class="font-bold text-indigo-800">Tawaran Order</h4>
                                                        </div>
                                                        @if (!empty($message['service']))
                                                            <div
                                                                class="mb-3 mt-1 p-2 bg-white/50 rounded-md border border-indigo-100">
                                                                <p class="text-xs text-gray-500 mb-1">Tawaran untuk
                                                                    jasa:</p>
                                                                <div class="flex items-center">
                                                                    <img src="{{ Storage::url($message['service']['cover']) }}"
                                                                        class="w-8 h-8 rounded object-cover mr-2">
                                                                    <span
                                                                        class="text-sm font-semibold text-indigo-900 truncate">{{ $message['service']['name'] }}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <p class="text-sm text-gray-600 mb-2">
                                                            {{ $message['content']['description'] }}</p>
                                                        <p class="text-lg font-bold text-indigo-600">Rp
                                                            {{ number_format($message['content']['price'], 0, ',', '.') }}
                                                        </p>

                                                        @if ($message['content']['status'] === 'menunggu_konfirmasi')
                                                            @if ($message['receiver_id'] === auth()->id())
                                                                {{-- Aksi untuk Penerima (Customer) --}}
                                                                <div class="flex gap-2 mt-3">
                                                                    <button
                                                                        wire:click="acceptOrder({{ $message['id'] }})"
                                                                        class="flex-1 bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 text-sm">
                                                                        <i class="fas fa-check"></i> Terima
                                                                    </button>
                                                                    {{-- Fungsikan tombol Tolak --}}
                                                                    <button
                                                                        wire:click="rejectOrder({{ $message['id'] }})"
                                                                        class="flex-1 bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 text-sm">
                                                                        <i class="fas fa-times"></i> Tolak
                                                                    </button>
                                                                </div>
                                                            @else
                                                                {{-- Info untuk Pengirim (Mitra) --}}
                                                                <p class="text-xs text-center text-gray-500 mt-3">
                                                                    Menunggu konfirmasi customer.</p>
                                                                <button wire:click="cancelOffer({{ $message['id'] }})"
                                                                    class="w-full bg-gray-200 text-gray-700 p-2 rounded-lg hover:bg-gray-300 text-sm mt-2">
                                                                    <i class="fas fa-trash-alt"></i> Batalkan Tawaran
                                                                </button>
                                                            @endif
                                                        @elseif ($message['content']['status'] === 'dikonfirmasi')
                                                            {{-- Status setelah diterima --}}
                                                            <p
                                                                class="text-sm text-center font-semibold text-green-600 bg-green-100 p-2 rounded-lg mt-3">
                                                                <i class="fas fa-check-circle"></i> Tawaran Diterima
                                                            </p>
                                                        @elseif ($message['content']['status'] === 'ditolak')
                                                            {{-- Status setelah ditolak --}}
                                                            <p
                                                                class="text-sm text-center font-semibold text-red-600 bg-red-100 p-2 rounded-lg mt-3">
                                                                <i class="fas fa-times-circle"></i> Tawaran Ditolak
                                                            </p>
                                                        @elseif ($message['content']['status'] === 'dibatalkan')
                                                            <p
                                                                class="text-sm text-center font-semibold text-gray-500 bg-gray-100 p-2 rounded-lg mt-3">
                                                                <i class="fas fa-history"></i> Tawaran Kedaluwarsa
                                                            </p>
                                                        @endif
                                                    </div>
                                                @endif
                                                @if (!empty($message['service_id']) && $message['service'])
                                                    <div
                                                        class="mt-2 pt-2 border-t {{ $isSender ? 'border-white/20' : 'border-gray-200' }}">
                                                        <button
                                                            wire:click="showServicePreview({{ $message['service_id'] }})"
                                                            class="text-xs font-semibold flex items-center w-full {{ $isSender ? 'hover:bg-white/10' : 'hover:bg-gray-100' }} p-1 rounded-md text-left">
                                                            <img src="{{ Storage::url($message['service']['cover']) }}"
                                                                class="w-6 h-6 rounded object-cover mr-2">
                                                            <div class="flex flex-col">
                                                                <span class="truncate">Lihat Jasa:
                                                                    {{ $message['service']['name'] }}</span>
                                                                <span class="truncate">Harga: Rp
                                                                    {{ $message['service']['price'] }}</span>

                                                            </div>
                                                        </button>
                                                    </div>
                                                @endif
                                                <span class="{{ $timeClasses }}">
                                                    {{ date('H:i', strtotime($message['created_at'])) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div x-show="isImageModalOpen" x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                x-on:keydown.escape.window="isImageModalOpen = false"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
                                style="display: none;">

                                {{-- Tombol Close di Pojok Kanan Atas --}}
                                <button @click="isImageModalOpen = false"
                                    class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300 cursor-pointer">&times;</button>

                                {{-- Kontainer Gambar --}}
                                <div class="relative" @click.away="isImageModalOpen = false">
                                    <img :src="imageModalUrl" alt="Tampilan Penuh"
                                        class="max-w-full max-h-[90vh] rounded-lg">
                                    <a :href="imageModalUrl" :download="imageModalFilename"
                                        class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-white/20 text-white backdrop-blur-sm px-4 py-2 rounded-lg hover:bg-white/30 transition no-underline">
                                        <i class="fas fa-download mr-2"></i>Download
                                    </a>
                                </div>
                            </div>
                            @if ($this->activeService)
                                <div class="p-2 border-t border-gray-200 bg-gray-100">
                                    <div class="flex items-center justify-between bg-white p-2 rounded-lg shadow-sm">
                                        <div class="flex items-center overflow-hidden">
                                            <img src="{{ Storage::url($this->activeService->cover) }}"
                                                alt="{{ $this->activeService->name }}"
                                                class="w-12 h-12 object-cover rounded-md mr-3">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-800 truncate">
                                                    {{ $this->activeService->name }}</p>
                                                <p class="text-sm font-bold text-secondary">Rp
                                                    {{ number_format($this->activeService->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        <button wire:click="$set('activeServiceId', null)"
                                            class="text-gray-400 hover:text-gray-600 ml-2 px-2" title="Sembunyikan">
                                            &times;
                                        </button>
                                    </div>
                                </div>
                            @endif
                            {{-- Area Input Pesan --}}
                            <div class="p-4 border-t border-gray-200 flex-shrink-0" x-data="{ isUploading: false, progress: 0 }">
                                <div x-show="isUploading" class="mb-2">
                                    <progress max="100" x-bind:value="progress" class="w-full"></progress>
                                </div>
                                <div class="flex items-center">
                                    @if (optional(auth()->user())->status === 'mitra' && $selectedUser)
                                        <button type="button" wire:click="openOrderForm"
                                            class="text-gray-500 hover:text-tertiary p-3" title="Buat Tawaran Order">
                                            <i class="fas fa-file-invoice-dollar text-xl"></i>
                                        </button>
                                    @endif
                                    <button type="button" wire:loading.attr="disabled"
                                        @click="
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    // Berhasil mendapatkan lokasi
                    $wire.sendLocation({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    });
                },
                (error) => {
                    // Menangani kesalahan
                    let errorMessage = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Anda menolak permintaan untuk berbagi lokasi.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Informasi lokasi tidak tersedia saat ini.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Waktu habis saat mencoba mendapatkan lokasi.';
                            break;
                        case error.UNKNOWN_ERROR:
                            errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                            break;
                    }
                    alert('Gagal mendapatkan lokasi: ' + errorMessage);
                }
            );
        } else {
            alert('Browser Anda tidak mendukung Geolocation.');
        }
    "
                                        class="text-gray-500 hover:text-tertiary p-3">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </button>
                                    <input type="file" accept="image/*" id="attachment-input"
                                        wire:model.live="attachment" class="hidden"
                                        x-on:livewire-upload-start="isUploading = true"
                                        x-on:livewire-upload-finish="isUploading = false"
                                        x-on:livewire-upload-error="isUploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <label for="attachment-input"
                                        class="text-gray-500 mr-3 hover:text-tertiary  cursor-pointer">
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

                        {{-- Form Pembuatan Order (Overlay) --}}
                        @if ($showOrderForm)
                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center p-4 z-10">
                                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md"
                                    @click.outside="$wire.set('showOrderForm', false)">
                                    <h3 class="text-lg font-bold mb-4">Buat Tawaran Order</h3>
                                    @error('activeServiceId')
                                        <div
                                            class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded-lg mb-4">
                                            <p class="font-bold mb-1">Tidak Bisa Membuat Penawaran</p>
                                            <p>{{ $message }}</p>
                                        </div>
                                    @enderror
                                    <div class="space-y-4">
                                        <div>
                                            <label for="orderDescription"
                                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                            <textarea wire:model="orderDescription" id="orderDescription" rows="4"
                                                class="w-full border border-gray-300 rounded-lg p-2 mt-1 @error('orderDescription') border-red-500 @enderror"></textarea>
                                            @error('orderDescription')
                                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="orderPrice"
                                                class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                                            <input type="number" wire:model="orderPrice" id="orderPrice"
                                                class="w-full border border-gray-300 rounded-lg p-2 mt-1 @error('orderPrice') border-red-500 @enderror">
                                            @error('orderPrice')
                                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="flex justify-end space-x-3 mt-6">
                                        <button type="button" wire:click="$set('showOrderForm', false)"
                                            class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                                        <button type="button" wire:click="sendOrderOffer"
                                            class="px-4 py-2 bg-tertiary text-white rounded-lg">Kirim Tawaran</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
