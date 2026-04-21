<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $fillable = ['siswa_id', 'tanggal', 'waktu', 'status'];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function scopeForSiswaOnDate($query, Siswa $siswa, string $date)
    {
        return $query->where('siswa_id', $siswa->id)->where('tanggal', $date);
    }
}
