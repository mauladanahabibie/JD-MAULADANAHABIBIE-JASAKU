<?php

namespace App\Livewire;

use Livewire\Component;

class FloatingChatButton extends Component
{

        public function toggleModal()
    {
        // Mengirim event "toggle-chat-modal" ke seluruh aplikasi Livewire.
        $this->dispatch('toggle-chat-modal');
    }
    public function render()
    {
        return view('livewire.floating-chat-button');
    }
}
