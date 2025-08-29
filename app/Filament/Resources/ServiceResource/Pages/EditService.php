<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Models\Image;
use Filament\Actions;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ServiceResource;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
             ->before(function ($record) {
                    if ($record->cover && Storage::disk('public')->exists($record->cover)) {
                        Storage::disk('public')->delete($record->cover);
                    }

                    foreach ($record->images as $image) {
                        if ($image->path && Storage::disk('public')->exists($image->path)) {
                            Storage::disk('public')->delete($image->path);
                        }
                    }

                }),
        ];
    }
        protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['images'] = $this->record->images->pluck('path')->toArray();

        return $data;
    }

      protected function afterSave(): void
    {
        $serviceId = $this->record->id;

        $oldImages = $this->record->images->pluck('path')->toArray();

        $this->record->images()->delete();

        if (!empty($this->data['images'])) {
            foreach ($this->data['images'] as $imagePath) {
                Image::create([
                    'service_id' => $serviceId,
                    'path' => $imagePath
                ]);
            }
        }

        $newImages = $this->data['images'] ?? [];

        foreach ($oldImages as $oldImage) {
            if (!in_array($oldImage, $newImages)) {
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        }

        // Tampilkan notifikasi sukses
        Notification::make()
            ->title('Berhasil!')
            ->body('Berita berhasil diperbarui dengan ' . count($this->data['images'] ?? []) . ' gambar.')
            ->success()
            ->send();
    }
}
