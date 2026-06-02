<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Produk';

    protected static ?string $navigationGroup = 'Katalog';

    protected static ?string $modelLabel = 'Produk';

    protected static ?string $pluralModelLabel = 'Produk';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Produk')
                    ->description('Data produk untuk katalog.')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Produk (Internal)')
                                    ->placeholder('Contoh: Premium Watch Model X')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                Forms\Components\Select::make('brand_id')
                                    ->label('Brand')
                                    ->relationship('brand', 'name')
                                    ->placeholder('Pilih Brand')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(fn (callable $set) => $set('product_group_id', null))
                                    ->helperText('Asosiasikan produk ini dengan brand tertentu.')
                                    ->columnSpan(1),

                                Forms\Components\Select::make('product_group_id')
                                    ->label('Group Produk')
                                    ->placeholder('Pilih Group')
                                    ->options(function (callable $get) {
                                        $brandId = $get('brand_id');
                                        if (!$brandId) {
                                            return [];
                                        }
                                        return \App\Models\ProductGroup::where('brand_id', $brandId)
                                            ->where('is_active', true)
                                            ->pluck('name', 'id');
                                    })
                                    ->disabled(fn (callable $get) => !$get('brand_id'))
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Pilih group kategori untuk brand ini.')
                                    ->columnSpan(1),
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Produk')
                            ->placeholder('Masukkan deskripsi atau spesifikasi produk yang akan ditampilkan di website...')
                            ->rows(3)
                            ->helperText('Deskripsi premium akan ditampilkan secara elegan saat foto produk di-klik.')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('Foto Produk atau File PDF')
                            ->required()
                            ->directory('products')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'application/pdf'])
                            ->maxSize(20480) // 20MB max upload
                            ->helperText('Format yang didukung: JPEG, PNG, WebP, SVG, atau PDF. Gambar biasa akan dioptimasi otomatis, sedangkan PDF dan SVG akan disimpan utuh.')
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Tampilkan di Katalog')
                                    ->default(true)
                                    ->helperText('Aktifkan untuk menampilkan produk di halaman publik.'),

                                Forms\Components\Toggle::make('show_description')
                                    ->label('Tampilkan Deskripsi')
                                    ->default(true)
                                    ->helperText('Tampilkan spesifikasi/deskripsi produk di website.'),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Urutan Tampil')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Angka kecil ditampilkan lebih dulu.'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Foto')
                    ->square()
                    ->size(80)
                    ->state(function (Product $record) {
                        // Accessing the thumbnail_url property triggers JIT generation for PDFs
                        $record->thumbnail_url;

                        $path = $record->isPdf()
                            ? str_replace('.pdf', '_thumbnail.webp', $record->image_path)
                            : $record->image_path;

                        if (!$path) {
                            return null;
                        }

                        // Use current request host/port if available to prevent port mismatch, fallback to config APP_URL
                        $baseUrl = request()->httpHost()
                            ? request()->getSchemeAndHttpHost()
                            : config('app.url');

                        return rtrim($baseUrl, '/') . '/storage/' . $path;
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Brand')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('productGroup.name')
                    ->label('Group')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('file_size_kb')
                    ->label('Ukuran')
                    ->suffix(' KB')
                    ->sortable()
                    ->color('gray'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),

                Tables\Columns\ToggleColumn::make('show_description')
                    ->label('Deskripsi'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->color('gray'),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name')
                    ->placeholder('Semua Brand'),

                Tables\Filters\SelectFilter::make('product_group_id')
                    ->label('Group')
                    ->relationship('productGroup', 'name')
                    ->placeholder('Semua Group'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order')
            ->emptyStateHeading('Belum ada produk')
            ->emptyStateDescription('Mulai tambahkan produk ke katalog Anda.')
            ->emptyStateIcon('heroicon-o-photo');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
