<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Properti extends Model
{
    protected $table = 'properti';
    protected $primaryKey = 'properti_id';

    protected $fillable = [
        'user_id',
        'nama_properti',
        'harga',
        'lokasi',
        'deskripsi',
        'fasilitas',
        'kontak_whatsapp',
        'foto_properti',
        'status',
        'status_pembayaran',
        'is_unggulan',
        'bukti_pembayaran',
        'alasan_penolakan',
        'tipe_properti',
        'luas_tanah',
        'jumlah_kamar',
        'alasan_penolakan_pembayaran'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSiapTampil($query)
    {
        return $query->where('status', 'disetujui')
                     ->where('status_pembayaran', 'valid');
    }

    public function fotos()
    {
        return $this->hasMany(PropertiFoto::class, 'properti_id');
    }
}
