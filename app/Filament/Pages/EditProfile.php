<?php

namespace App\Filament\Pages\Auth;

use Dom\Text;
use App\Models\Group;
use Filament\Forms\Form;
use Illuminate\Support\Arr;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

use Illuminate\Validation\Rules\Password;
use Afsakar\LeafletMapPicker\LeafletMapPicker;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    /**
     * Get the maximum width of the page content.
     */

    public function form(Form $form): Form
    {
                $panelId = Filament::getCurrentPanel()->getId();
        return $form
            ->schema([
                Section::make('Informasi Profil')
                    ->schema([
                        Grid::make(1)
                            ->columns(2)
                            ->schema([
                                FileUpload::make('avatar')
                                    ->label('Foto Profil')
                                    ->disk('public')
                                    ->directory('avatar')
                                    ->image()
                                    ->imageEditor()
                                    ->deleteUploadedFileUsing(function ($file) {
                                        Storage::disk('public')->delete($file);
                                    })
                                    ->dehydrated()
                                    ->default(fn() => auth()->user()->avatar)
                                    ->avatar()
                                    ->alignCenter()
                                    ->columnSpanFull(),
                                TextInput::make('username')
                                    ->label('Username')
                                    ->required()
                                    ->default(fn() => auth()->user()->username),
                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255)
                                    ->default(fn() => auth()->user()->name),

                                TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->default(fn() => auth()->user()->email),
                                TextInput::make('phone')
                                    ->label('Nomor Telepon')
                                    ->tel()
                                    ->required()
                                    ->default(fn() => auth()->user()->phone),
                                TextInput::make('about')
                                    ->label('Tentang Saya')
                                    ->default(fn() => auth()->user()->about)
                                    ->columnSpanFull()
                            ]),
                    ]),
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
                            ->tileProvider('openstreetmap')
                            ->required(),
                        TextInput::make('address')
                            ->label('Alamat Lengkap')
                            ->required()
                    ])->visible(fn() => $panelId === 'mitra'),
                Section::make('Ganti Password')
                    ->schema([
                        Grid::make()
                            ->columns(2)
                            ->schema([
                                TextInput::make('current_password')
                                    ->label('Password Saat Ini')
                                    ->password()
                                    ->currentPassword()
                                    ->visible(fn() => filled(auth()->user()->password))
                                    ->revealable(),

                                TextInput::make('password')
                                    ->label('Password Baru')
                                    ->password()
                                    ->rule(Password::defaults())
                                    ->autocomplete('new-password')
                                    ->dehydrated(fn($state): bool => filled($state))
                                    ->dehydrateStateUsing(fn($state): string => bcrypt($state))
                                    ->confirmed()
                                    ->revealable(),

                                TextInput::make('password_confirmation')
                                    ->label('Konfirmasi Password')
                                    ->password()
                                    ->same('password')
                                    ->dehydrated(fn($state): bool => filled($state))
                                    ->revealable()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('updateProfile')
                ->keyBindings(['mod+s']),

            Action::make('reset')
                ->label('Reset')
                ->color('warning')
                ->action(fn() => $this->fillForm())
                ->icon('heroicon-m-arrow-path'),

            Action::make('back')
                ->label('Dashboard')
                ->color('gray')
                ->url(fn() => Filament::getUrl())
                ->icon('heroicon-m-arrow-uturn-left'),
        ];
    }

    protected function fillForm(): void
    {
        $user = $this->getUser();
        $data = $user->toArray();

        $data['avatar'] = $user->avatar;
        $data['username'] = $user->username;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['phone'] = $user->phone;

        $this->form->fill($data);
    }

    public function updateProfile(): void
    {
        try {
            $data = $this->form->getState();
            $user = $this->getUser();

            $oldAvatar = $user->avatar;

            if (isset($data['avatar']) && $data['avatar'] !== $oldAvatar) {
                if ($oldAvatar) {
                    Storage::disk('public')->delete($oldAvatar);
                }
                $user->avatar = $data['avatar'];
            }

            $profileData = Arr::except($data, [
                'current_password',
                'password',
                'password_confirmation',
                'avatar' 
            ]);

            $user->fill($profileData);
            $user->save();

            if (filled(data_get($data, 'password'))) {
                if (!filled(data_get($data, 'current_password'))) {
                    $this->notification()
                        ->title('Password saat ini diperlukan')
                        ->danger()
                        ->send();
                    return;
                }

                $user->password = bcrypt(data_get($data, 'password'));
                $user->save();

                $this->form->fill(array_merge(
                    $this->form->getState(),
                    [
                        'current_password' => '',
                        'password' => '',
                        'password_confirmation' => '',
                    ]
                ));

                $this->notification()
                    ->title('Password berhasil diubah')
                    ->success()
                    ->send();
            } else {
                $this->notification()
                    ->title('Profil berhasil diperbarui')
                    ->success()
                    ->send();
            }
        } catch (\Exception $e) {
            $this->notification()
                ->title('Gagal memperbarui profil')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
