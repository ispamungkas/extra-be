<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nisn',
        'kelas',
        'no_telp'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Jika dia siswa: ikut banyak eskul
    public function eskuls()
    {
        return $this->belongsToMany(Eskul::class, 'eskul_siswa', 'siswa_id', 'eskul_id');
    }

    // Jika dia pembina: membina banyak eskul
    public function eskulDibina()
    {
        return $this->hasOne(Eskul::class, 'pembina_id');
    }

    // Absensi siswa
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }
}
