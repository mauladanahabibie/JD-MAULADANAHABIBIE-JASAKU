<div class="bg-white p-8 rounded-2xl shadow-lg">
    <h3 class="text-xl font-bold text-gray-800 mb-6">Kirim Pesan</h3>

    @if ($success)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Terima kasih!</strong>
            <span class="block sm:inline">Pesan Anda telah berhasil dikirim.</span>
        </div>
    @endif
        @error('form')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ $message }}</span>
        </div>
    @enderror

    <form wire:submit.prevent="submit" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" id="name" wire:model="name"
                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary">
            @error('name')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="email" wire:model="email"
                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary">
            @error('email')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
            <input type="text" id="subject" wire:model="subject"
                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary">
            @error('subject')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
            <textarea id="message" wire:model="message" rows="5"
                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary"></textarea>
            @error('message')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit"
            class="w-full bg-tertiary text-white py-3 rounded-lg font-semibold hover:bg-tertiary/80 transition flex items-center justify-center"
            wire:loading.attr="disabled" wire:target="submit">

            <span wire:loading.class="hidden" wire:target="submit">
                Kirim Pesan
            </span>

            <span wire:loading.class.remove="hidden" wire:target="submit" class="hidden">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Mengirim...
            </span>
        </button>
    </form>
</div>
