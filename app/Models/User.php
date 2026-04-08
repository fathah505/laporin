<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   
    protected $fillable = [
        'nis_nip',
        'name',
        'kelas',
        'password',
        'telp',
        'level',
        '',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'user_id', 'id');
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class, 'user_id', 'id');
    }
}