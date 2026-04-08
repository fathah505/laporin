<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Pengaduan extends Model
{
    use HasFactory;
    protected $table = 'pengaduan';
    protected $fillable = [
        'user_id',       
        'kategori_id',   
        'judul_laporan',
        'isi_laporan',
        'tgl_pengaduan',
        'foto',
        'status',       
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class, 'pengaduan_id', 'id');
    }
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return !empty($attributes['foto'])
                    ? asset('storage/' . $attributes['foto'])
                    : asset('images/no-image.png');
            }
        );
    }
}