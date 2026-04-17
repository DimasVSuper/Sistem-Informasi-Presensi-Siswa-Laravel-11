<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $table = 'orang_tua';
    protected $fillable = ['nama', 'email'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'orang_tua_id');
    }
}
