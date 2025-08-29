<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
        public function mutateFormDataBeforeSave(array $data): array
    {
        if (filled($data['new_password'] ?? null)) { 
            $this->record->password = Hash::make($data['new_password']);
        } else {
            unset($data['new_password']);
            unset($data['new_password_confirmation']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        if (auth()->id() === $this->record->id) {
            auth()->login($this->record);
        }
    }
}
