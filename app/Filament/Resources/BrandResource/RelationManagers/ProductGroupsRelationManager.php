<?php

namespace App\Filament\Resources\BrandResource\RelationManagers;

use App\Models\ProductGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductGroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'productGroups';

    protected static ?string $title = 'Group Produk';

    protected static ?string $modelLabel = 'Group Produk';

    protected static ?string $pluralModelLabel = 'Group Produk';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Group')
                    ->placeholder('Contoh: iPhone, Classic, Accessories')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->placeholder('Contoh: iphone, classic, accessories')
                    ->required()
                    ->unique(ProductGroup::class, 'slug', ignoreRecord: true)
                    ->helperText('Tautan URL unik untuk filter.'),

                Forms\Components\TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0)
                    ->helperText('Urutan tampil (angka kecil di awal).'),

                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Aktifkan untuk memunculkan group ini.'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Group')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->color('gray'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
            ->reorderable('sort_order');
    }
}
