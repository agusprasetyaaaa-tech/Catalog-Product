<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key with optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("setting_{$key}");
    }

    /**
     * Get the full URL for the site logo.
     */
    public static function getLogoUrl(): ?string
    {
        $path = static::get('site_logo');

        if ($path && Storage::disk('public')->exists($path)) {
            $url = Storage::disk('public')->url($path);
            return parse_url($url, PHP_URL_PATH);
        }

        // Fallback to default logo
        return asset('logo/logo.png');
    }
}
