<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['nama', 'nis', 'qr_code', 'orang_tua_id'];

    public function orangTua():BelongsTo
    {
        return $this->belongsTo(OrangTua::class, 'orang_tua_id');
    }
    
    public function presensi():HasMany
    {
        return $this->hasMany(Presensi::class, 'siswa_id');
    }
}
