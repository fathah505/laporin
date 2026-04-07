<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'nis_nip',
        'level',
        'kelas',
        'telp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ── Relasi ──
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'user_id');
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class, 'admin_id');
    }

    // ── Helper: apakah user ini admin? ──
    public function isAdmin(): bool
    {
        return $this->level === 'admin';
    }

    // ── Helper: apakah user ini siswa? ──
    public function isSiswa(): bool
    {
        return $this->level === 'siswa';
    }
}