<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'eskul_id',
        'siswa_id',
        'tanggal',
        'status'
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function eskul()
    {
        return $this->belongsTo(Eskul::class, 'eskul_id');
    }
}
