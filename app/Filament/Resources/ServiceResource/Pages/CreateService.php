<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Models\Image;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ServiceResource;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

     protected function afterCreate(): void
    {
        $newsId = $this->record->id;
        
        // Simpan gambar ke database
        if (!empty($this->data['images'])) {
            foreach ($this->data['images'] as $imagePath) {
                Image::create([
                    'service_id' => $newsId,
                    'path' => $imagePath    
                ]);
            }
        }

        // Tampilkan notifikasi sukses
        Notification::make()
            ->title('Berhasil!')
            ->body('Berita berhasil dibuat dengan ' . count($this->data['images'] ?? []) . ' gambar.')
            ->success()
            ->send();
    }
}
