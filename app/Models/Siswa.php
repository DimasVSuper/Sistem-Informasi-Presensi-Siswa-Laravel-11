<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = ['nama', 'nis', 'qr_code', 'orang_tua_id'];

    protected static function booted(): void
    {
        static::creating(function (Siswa $siswa) {
            if (empty($siswa->qr_code)) {
                do {
                    $qrCode = 'QR-'.Str::upper(Str::random(8));
                } while (static::where('qr_code', $qrCode)->exists());
                
                $siswa->qr_code = $qrCode;
            }
        });
    }

    public function orangTua(): BelongsTo
    {
        return $this->belongsTo(OrangTua::class, 'orang_tua_id');
    }

    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class, 'siswa_id');
    }

    /**
     * Scope a query to find a student by their QR code.
     */
    public function scopeWithQrCode($query, string $qrCode)
    {
        return $query->where('qr_code', $qrCode);
    }
}

