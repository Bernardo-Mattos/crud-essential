<?php

namespace App\Models;

use App\Observers\ClienteObserver;
use Database\Factories\ClienteFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Cliente extends Model {
    /** @use HasFactory<ClienteFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo_path',
    ];

    protected function photoUrl(): Attribute {
        return Attribute::make(
            get: fn() => $this->photo_path
                ? Storage::disk('public')->url($this->photo_path)
                : null,
        );
    }

    /**
     * Grava a foto enviada em disk('public')/clientes e apaga a anterior, se houver.
     */
    public static function storeUploadedPhoto(UploadedFile $file, ?string $previousPath = null): string {
        if ($previousPath) {
            Storage::disk('public')->delete($previousPath);
        }

        return $file->store('clientes', 'public');
    }
}
