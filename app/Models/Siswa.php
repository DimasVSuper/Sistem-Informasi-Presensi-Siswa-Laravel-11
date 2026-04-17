<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['nama', 'nis', 'qr_code', 'orang_tua_id'];

    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class, 'orang_tua_id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'siswa_id');
    }
}
