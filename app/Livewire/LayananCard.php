<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\ServiceCategory;
use Livewire\Component;

class LayananCard extends Component
{
    public $services;
    public $search = '';
    public $category = '';
    public $perPage = 8;
    public $showModal = false;
    public $selectedService;
    public $categories;

    public function mount()
    {
        $this->loadServices();
        $this->categories = ServiceCategory::all();
    }

    public function loadServices()
    {
        $query = Service::query()
            ->with('service_category', 'user');

        if ($this->category) {
            $query->whereHas('service_category', function ($q) {
                $q->where('name', $this->category);
            });
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $this->services = $query->take($this->perPage)->get();
    }

    public function openModal($serviceId)
    {
        $this->selectedService = Service::with('service_category', 'images', 'user')->find($serviceId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedService = null;
    }

    public function loadMore()
    {
        $this->perPage += 8;
        $this->loadServices();
    }

    public function updatedSearch()
    {
        $this->loadServices();
    }

    public function updatedCategory()
    {
        $this->loadServices();
    }

    public function render()
    {
        return view('livewire.layanan-card', [
            'services' => $this->services,
            'categories' => $this->categories,
        ]);
    }
}