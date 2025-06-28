<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eskul extends Model
{
    protected $fillable = [
        'nama',
        'jadwal',
        'pembina_id',
        'tempat',
        'img',
    ];

    public function siswa()
    {
        return $this->belongsToMany(User::class, 'eskul_siswa', 'eskul_id', 'siswa_id');
    }

    public function pembina()
    {
        return $this->belongsTo(User::class, 'pembina_id');
    }
}
