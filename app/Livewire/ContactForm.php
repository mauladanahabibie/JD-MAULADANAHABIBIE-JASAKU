<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Component;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ContactForm extends Component
{

    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';

    public bool $success = false;


    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'subject' => 'required|min:5',
        'message' => 'required|min:10',
    ];

public function submit()
{
    $key = 'contact-form.' . request()->ip();

    $this->success = false;

    $executed = RateLimiter::attempt(
        $key,
        5, 
        function () {
            $validatedData = $this->validate();
            Contact::create($validatedData);
            $this->success = true;

            $this->reset(['name', 'email', 'subject', 'message']);
        },
        60 
    );

    if (! $executed) {
        $seconds = RateLimiter::availableIn($key);
        throw ValidationException::withMessages([
            'form' => "Anda telah mengirimkan terlalu banyak pesan. Silakan coba lagi dalam {$seconds} detik.",
        ]);
    }

}

    public function render()
    {
        return view('livewire.contact-form');
    }
}
