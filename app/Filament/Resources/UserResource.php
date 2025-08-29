<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Image;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Afsakar\LeafletMapPicker\LeafletMapPicker;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        // Mendapatkan user yang sedang login
        $user = auth()->user();

        return $user && $user->status === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Forms\Components\FileUpload::make('avatar')
                        ->label('Avatar')
                        ->disk('public')
                        ->columnSpanFull()
                        ->directory('avatars'),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('username')
                        ->label('Username')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->required()
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->visible(fn($livewire) => $livewire instanceof CreateUser)
                        ->rule('min:8'),
                    Forms\Components\TextInput::make('phone')
                        ->label('Telepon')
                        ->tel()
                        ->required()
                        ->maxLength(20)
                        ->unique(ignoreRecord: true),
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'admin' => 'Admin',
                            'cs' => 'Customer Service',
                            'customer' => 'Customer',
                            'mitra' => 'Mitra',
                        ])
                        ->default('customer')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                            if ($state === 'mitra' || $state === 'cs') {
                                $set('admin_verified', null);
                            }
                        }),
                    LeafletMapPicker::make('location')
                        ->label('Property Location')
                        ->height('500px')
                        ->defaultLocation([-8.2165, 114.3662])
                        ->defaultZoom(12)
                        ->columnSpanFull()
                        ->myLocationButtonLabel('Go to My Location')
                        ->hideTileControl()
                        ->tileProvider('openstreetmap')
                        ->required(),
                    Forms\Components\TextInput::make('address')
                        ->label('Alamat')
                        ->maxLength(500)
                        ->required()
                        ->helperText('Alamat lengkap pengguna, akan digunakan untuk pengiriman atau verifikasi lokasi.')
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('about')
                        ->label('Tentang')
                        ->maxLength(1000)
                        ->columnSpanFull(),
                    Forms\Components\DateTimePicker::make('admin_verified')
                        ->label('Admin Verified')
                        ->required(fn(Forms\Get $get) => $get('status') === 'mitra' || $get('status') === 'cs')
                        ->default(null)
                        ->columnSpanFull()
                        ->helperText('Tanggal verifikasi admin untuk mitra. Kosongkan jika belum diverifikasi.')
                        ->visible(fn(Forms\Get $get) => $get('status') === 'mitra' || $get('status') === 'cs')
                        ->default(fn() => now()),
                    Section::make('User New Password')->schema([
                        TextInput::make('new_password')
                            ->nullable()
                            ->password()
                            ->rule('confirmed')
                            ->rule('min:8'),
                        TextInput::make('new_password_confirmation')
                            ->password()
                            ->same('new_password')
                            ->requiredWith('new_password'),
                    ])->visible(fn($livewire) => $livewire instanceof EditUser)->reactive()
                ])
            ])->columns([
                'sm' => 1,
                'md' => 2,
                'lg' => 3,
                'xl' => 4,
                '2xl' => 5
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Verify')
                    ->label('Verify')
                    ->color('success')
                    ->icon('heroicon-s-check-circle')
                    ->visible(fn(User $user): bool => is_null($user->admin_verified))
                    ->action(function (User $user) {
                        $user->touch('admin_verified');
                        Notification::make()
                            ->success()
                            ->title("User {$user->name} verified")
                            ->send();
                    }),
                Tables\Actions\Action::make('Unverify')
                    ->label('Unverify')
                    ->color('danger')
                    ->icon('heroicon-s-x-circle')
                    ->visible(fn(User $user): bool => auth()->id() !== $user->id && !is_null($user->admin_verified))
                    ->action(function (User $user) {
                        $user->admin_verified = null;
                        $user->save();

                        Notification::make()
                            ->success()
                            ->title("User {$user->name} unverified")
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn(User $user): bool => auth()->id() !== $user->id),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
