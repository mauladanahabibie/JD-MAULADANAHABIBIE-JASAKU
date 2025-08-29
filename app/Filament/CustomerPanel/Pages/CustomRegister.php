<?php

namespace App\Filament\CustomerPanel\Pages\CustomerPanel\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Support\Arr;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;

class CustomRegister extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        TextInput::make('username')
                            ->label('Username')
                            ->required(),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->required(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data')
            ),
        ];
    }
    protected function handleRegistration(array $data): User
    {
        $data['status'] = 'customer'; 

        $user = parent::handleRegistration($data);

        $user->password = $data['password'];
        $user->save();
        
        return $user;
    }
    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();

        $user = $this->handleRegistration($data);

        if ($user) {
            $user->password = $data['password'];
            $user->save();
        }

        Notification::make()
            ->title('Registrasi berhasil')
            ->body('Akun Anda telah dibuat. Silahkan login.')
            ->success()
            ->send();

        return app(RegistrationResponse::class);
    }
}


