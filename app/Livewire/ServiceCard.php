<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;

class ServiceCard extends Component
{

      public Service $service;

    public function startChat()
    {
        // Cek jika service memiliki user_id sebelum dispatch
        if ($this->service->user_id) {
            $this->dispatch('start-chat', ['userId' => $this->service->user_id]);
        }
    }
}
