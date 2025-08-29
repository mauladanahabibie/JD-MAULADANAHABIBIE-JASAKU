<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Service;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use App\Models\ServiceCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\ServiceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ServiceResource\RelationManagers;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->schema([
                    FileUpload::make('cover')
                        ->label('Cover Layanan')
                        ->disk('public')
                        ->directory('service/cover')
                        ->image()
                        ->imageEditor()
                        ->imagePreviewHeight('200')
                        ->required()
                        ->maxSize(10240) // 10MB
                        ->helperText('Upload gambar cover untuk Layanan (max 10MB)')
                        ->deleteUploadedFileUsing(function ($file) {
                            if (Storage::disk('public')->exists($file)) {
                                Storage::disk('public')->delete($file);
                            }
                        }),
                    FileUpload::make('images')
                        ->label('Upload Gambar Tambahan')
                        ->multiple()
                        ->reorderable()
                        ->disk('public')
                        ->directory('service/images')
                        ->image()
                        ->required()
                        ->imagePreviewHeight('150')
                        ->maxSize(10240) // 10MB
                        ->maxFiles(10) // Maksimal 10 gambar
                        ->imageEditor()
                        ->helperText('Upload gambar tambahan untuk berita (max 10 gambar, 10MB per gambar)')
                        ->deleteUploadedFileUsing(function ($file) {
                            if (Storage::disk('public')->exists($file)) {
                                Storage::disk('public')->delete($file);
                            }
                        }),
                    TextInput::make('name')
                        ->label('Nama Produk')
                        ->required(),
                    TextInput::make('price')
                        ->numeric()
                        ->label('Harga Produk')
                        ->required(),
                    Select::make('category_id')
                        ->label('Kategori')
                        ->relationship('service_category', 'name')
                        ->options(ServiceCategory::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->preload()
                        ->when(
                            Filament::auth()->user()?->status === 'admin',
                            fn ($field) => $field->createOptionUsing(function (array $data) {
                                $category = ServiceCategory::create([
                                    'name' => $data['name'],
                                ]);
                                return $category->id;
                            })
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Kategori')
                                    ->placeholder('Contoh: Olahraga, Teknologi, dll')
                            ])
                            ),
                    RichEditor::make('description')
                        ->label('Deskripsi Produk')
                        ->required()
                        ->placeholder('Isi deskripsi produk disini')
                        ->columnSpan('full')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('product/attachments')
                        ->fileAttachmentsVisibility('public')
                        ->toolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ]),
                    Select::make('status')
                        ->label('Status Produk')
                        ->options([
                            'Tersedia' => 'Tersedia',
                            'Tidak Tersedia' => 'Tidak Tersedia',
                            'Tutup' => 'Tutup',
                        ])
                        ->required(),
                    Hidden::make('mitra_id')
                        ->default(fn() => Filament::auth()->user()?->id)
                        ->dehydrated()
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Cover Layanan')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga Produk')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status Produk')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        static::deleteNewsFiles($record);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function (Collection $records) {
                            // Hapus file untuk setiap record sebelum bulk delete
                            foreach ($records as $record) {
                                static::deleteNewsFiles($record);
                            }
                        }),
                ]),
            ]);
    }
    protected static function deleteNewsFiles(Service $service): void
    {
        // Hapus cover
        if ($service->cover && Storage::disk('public')->exists($service->cover)) {
            Storage::disk('public')->delete($service->cover);
        }

        // Hapus semua gambar
        foreach ($service->images as $image) {
            if ($image->path && Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
        }
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
