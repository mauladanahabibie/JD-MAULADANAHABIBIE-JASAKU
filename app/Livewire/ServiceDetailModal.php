<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;

class ServiceDetailModal extends Component
{

    public ?Service $service = null;
    public bool $showModal = false;

    // Listener ini akan "mendengar" event dari komponen lain
    protected $listeners = ['showServiceDetail'];

    public function showServiceDetail($serviceId)
    {
        // Cari service di database berdasarkan ID yang dikirim
        $this->service = Service::find($serviceId);

        // Jika service ditemukan, tampilkan modal
        if ($this->service) {
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        // Method untuk menutup modal
        $this->showModal = false;
        $this->service = null; // Kosongkan data service
    }

    public function render()
    {
        return view('livewire.service-detail-modal');
    }
}
