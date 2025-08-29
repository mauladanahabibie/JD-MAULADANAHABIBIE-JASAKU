<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Arr;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Afsakar\LeafletMapPicker\LeafletMapPicker;
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
                        TextInput::make('about')
                            ->label('Tentang Saya'),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        Section::make('Informasi Mitra & Lokasi')
                            ->description('Detail alamat, deskripsi, dan titik lokasi usaha Anda di peta.')
                            ->collapsible()
                            ->schema([
                                LeafletMapPicker::make('location')
                                    ->label('Property Location')
                                    ->height('500px')
                                    ->defaultLocation([-8.2165, 114.3662])
                                    ->defaultZoom(12)
                                    ->myLocationButtonLabel('Go to My Location')
                                    ->hideTileControl()
                                    ->tileProvider('openstreetmap'),
                                TextInput::make('address')
                                    ->label('Alamat Lengkap')
                            ]),
                    ])
                    ->statePath('data')
            ),
        ];
    }
    protected function handleRegistration(array $data): User
    {
        $data['status'] = 'mitra'; 
        $userData = Arr::except($data, [
            'location',
        ]);

        $user = parent::handleRegistration($userData);

        if ($user) {
            $user->location = json_encode($data['location']);
            $user->save();
        }

        return $user;
    }
    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();

        $user = $this->handleRegistration($data);


        Notification::make()
            ->title('Registrasi berhasil')
            ->body('Akun Anda telah dibuat. Tunggu verifikasi admin sebelum login.')
            ->success()
            ->send();

        return app(RegistrationResponse::class);
    }
}
