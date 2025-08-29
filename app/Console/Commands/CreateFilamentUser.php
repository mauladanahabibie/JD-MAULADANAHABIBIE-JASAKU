<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateFilamentUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filament-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filament user with a username.';

    /**
     * Execute the console command.
     */
     public function handle(): int
    {
        $name = $this->ask('Name');
        $username = $this->ask('Username'); 
        $email = $this->ask('Email address');
        $phone = $this->ask('Phone');
        $password = $this->secret('Password');

        $user = User::create([
            'name' => $name,
            'username' => $username, 
            'email' => $email,
            'phone' => $phone, 
            'password' => Hash::make($password),
        ]);

        $this->info("Filament user {$user->email} created successfully.");

        return Command::SUCCESS;
    }
}
