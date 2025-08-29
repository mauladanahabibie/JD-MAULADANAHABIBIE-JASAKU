<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\CustomerPanel\Resources\OrderResource;
use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Support\Enums\FontWeight;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Berita')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('service.name')
                                    ->label('Layanan')
                                    ->badge()
                                    ->color('info'),
                                TextEntry::make('customer.name')
                                    ->label('Pelanggan')
                                    ->badge()
                                    ->color('success'),
                                TextEntry::make('mitra.name')
                                    ->label('Mitra')
                                    ->badge()
                                    ->color('info'),
                                TextEntry::make('price')
                                    ->label('Harga')
                                    ->icon('heroicon-o-currency-dollar'),

                                TextEntry::make('description')
                                    ->label('Deskripsi')
                                    ->icon('heroicon-o-document-text'),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->icon('heroicon-o-check-circle'),

                                TextEntry::make('created_at')
                                    ->label('Dibuat')
                                    ->dateTime('d M Y, H:i')
                                    ->icon('heroicon-o-calendar'),
                                ImageEntry::make('bukti')
                                    ->label('Bukti Selesai')
                                    ->disk('public')
                                    ->height(250)
                                    ->width('100%'),
                            ])
                    ]),
            ]);
    }
}
