<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Brands';

    protected static ?string $navigationGroup = 'Katalog';

    protected static ?string $modelLabel = 'Brand';

    protected static ?string $pluralModelLabel = 'Brands';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Brand')
                    ->description('Kelola data brand untuk katalog produk Anda.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Brand')
                            ->placeholder('Contoh: HOROLOGIST')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->placeholder('Contoh: horologist')
                            ->required()
                            ->unique(Brand::class, 'slug', ignoreRecord: true)
                            ->helperText('Tautan URL unik untuk memfilter brand di halaman utama.'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true)
                                    ->helperText('Aktifkan untuk memunculkan brand ini sebagai filter di halaman utama.'),

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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Brand')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('URL Slug')
                    ->color('gray'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),

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
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
            ])
            ->actions([
                Tables\Actions\Action::make('qr_code')
                    ->label('QR Code')
                    ->icon('heroicon-o-qr-code')
                    ->color('success')
                    ->modalHeading(fn (Brand $record) => "QR Code - " . $record->name)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn (Brand $record) => view('filament.components.brand-qr', [
                        'record' => $record,
                        'url' => "http://192.168.0.243:8099/?brand={$record->slug}"
                    ])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order')
            ->emptyStateHeading('Belum ada brand')
            ->emptyStateDescription('Mulai tambahkan brand ke katalog Anda.')
            ->emptyStateIcon('heroicon-o-tag');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductGroupsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
