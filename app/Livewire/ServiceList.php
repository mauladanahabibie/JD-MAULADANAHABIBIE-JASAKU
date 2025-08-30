<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceList extends Component
{
    use WithPagination;

    public $seed;

    public function mount()
    {
        session(['services_seed' => rand()]);
    }

    public function updatedPage()
    {
        $this->js("document.getElementById('services').scrollIntoView({ behavior: 'smooth' })");
    }

    public function render()
    {
        $seed = session()->get('services_seed');
        
        $services = Service::inRandomOrder($seed)->paginate(8);
        
        return view('livewire.service-list', [
            'services' => $services,
        ]);
    }
}