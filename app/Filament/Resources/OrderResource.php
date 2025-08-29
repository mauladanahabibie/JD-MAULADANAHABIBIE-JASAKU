<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected function getHeaderActions(): array
    {
        // Kosongin array -> semua tombol header (termasuk Create) hilang
        return [];
    }
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('service_id')
                    ->label('Service Name')
                    ->relationship('service', 'name')
                    ->required()
                    ->disabled()
                    ->searchable()
                    ->preload(),

                Select::make('customer_id')
                    ->label('Customer Name')
                    ->relationship('customer', 'name')
                    ->required()
                    ->disabled()
                    ->searchable()
                    ->preload(),

                Select::make('mitra_id')
                    ->label('Mitra Name')
                    ->disabled()
                    ->relationship('mitra', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->disabled()
                    ->numeric()
                    ->minValue(0),
                Textarea::make('description')
                    ->label('Description')
                    ->disabled()
                    ->required(),
                FileUpload::make('bukti')
                    ->label('Bukti Selesai')
                    ->disk('public')
                    ->directory('order/bukti')
                    ->image()
                    ->imagePreviewHeight('200')
                    ->required()
                    ->maxSize(10240) // 10MB
                    ->helperText('Upload gambar cover untuk produk (max 10MB)')
                    ->deletable(fn($record) => ! ($record && $record->status === Order::STATUS_SUDAH_BAYAR))
                    ->appendFiles(fn($record) => ! ($record && $record->status === Order::STATUS_SUDAH_BAYAR))
                    ->deleteUploadedFileUsing(function (string $file) {
                        if (Storage::disk('public')->exists($file)) {
                            Storage::disk('public')->delete($file);
                        }
                    })
                    ->afterStateUpdated(function ($state, $component) {
                        $record = $component->getRecord();

                        if ($state && $record && $record->status !== Order::STATUS_SUDAH_BAYAR) {
                            $record->status = Order::STATUS_SUDAH_BAYAR;
                            $record->save();
                        }
                    })
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service.name')
                    ->label('Service Name'),
                TextColumn::make('customer.name')
                    ->label('Customer Name'),
                TextColumn::make('mitra.name')
                    ->label('Mitra Name'),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),
                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => match ($state) {
                        Order::STATUS_BELUM_BAYAR => 'Menunggu Pembayaran',
                        Order::STATUS_SUDAH_BAYAR => 'Sudah Dibayar',
                        Order::STATUS_SELESAI => 'Selesai',
                        Order::STATUS_DIBATALKAN => 'Dibatalkan',
                        default => 'Unknown',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListOrders::route('/'),
            // 'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // filter berdasarkan user yang login
        $user = Auth::user();

        if ($user->status === 'admin') {
            return $query;
        }

        return $query->where('mitra_id', $user->id);
    }
}
