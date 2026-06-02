<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;

class SiteSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Situs';
    protected static ?string $title = 'Pengaturan Situs';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 100;
    protected static string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $logoPath = Setting::get('site_logo', '');
        $heroSubtitle = Setting::get('hero_subtitle', 'Curated selection of premium products');
        
        $this->form->fill([
            'site_logo' => $logoPath ? [$logoPath] : [],
            'hero_subtitle' => $heroSubtitle,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Logo Situs')
                    ->description('Upload logo perusahaan yang akan ditampilkan di header katalog produk.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Forms\Components\FileUpload::make('site_logo')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('logo')
                            ->imageResizeMode('contain')
                            ->imageCropAspectRatio(null)
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                            ->helperText('Format: PNG, JPG, WebP, SVG. Maksimal 2MB. Rekomendasi: latar belakang transparan (PNG/SVG).')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Katalog Hero')
                    ->description('Pengaturan teks pada bagian hero katalog produk.')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        Forms\Components\TextInput::make('hero_subtitle')
                            ->label('Subjudul Hero')
                            ->default('Curated selection of premium products')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Subjudul yang ditampilkan di bawah judul utama "Our Product".')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        $logoFiles = $data['site_logo'] ?? [];
        
        // Get the old logo path before updating
        $oldLogoPath = Setting::get('site_logo', '');
        
        if (!empty($logoFiles)) {
            $newLogoPath = is_array($logoFiles) ? end($logoFiles) : $logoFiles;
            
            // Delete old logo if it's different from the new one
            if ($oldLogoPath && $oldLogoPath !== $newLogoPath && Storage::disk('public')->exists($oldLogoPath)) {
                Storage::disk('public')->delete($oldLogoPath);
            }
            
            Setting::set('site_logo', $newLogoPath);
        } else {
            // Logo was removed
            if ($oldLogoPath && Storage::disk('public')->exists($oldLogoPath)) {
                Storage::disk('public')->delete($oldLogoPath);
            }
            Setting::set('site_logo', '');
        }

        // Save hero subtitle
        Setting::set('hero_subtitle', $data['hero_subtitle'] ?? 'Curated selection of premium products');

        Notification::make()
            ->success()
            ->title('Pengaturan Disimpan')
            ->body('Pengaturan situs berhasil diperbarui.')
            ->send();
    }
}
