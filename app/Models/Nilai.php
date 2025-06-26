<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
        'siswa_id', 'eskul_id', 'tahun_ajaran', 'nilai'
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