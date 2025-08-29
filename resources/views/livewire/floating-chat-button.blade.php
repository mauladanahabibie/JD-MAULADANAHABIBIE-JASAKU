<div>
 @auth
        <button wire:click="toggleModal"
            class="bg-tertiary text-white p-4 rounded-full shadow-lg hover:bg-tertiary/80 transition z-40 cursor-pointer"
            aria-label="Buka obrolan">
            <i class="fas fa-comments text-xl"></i>
        </button>
    @else
        <a href="{{ url('/dashboard') }}"
            class="bg-tertiary text-white p-4 rounded-full shadow-lg hover:bg-tertiary/80 transition z-40 cursor-pointer"
            aria-label="Login untuk memulai obrolan">
            <i class="fas fa-comments text-xl"></i>
        </a>
    @endauth
</div>