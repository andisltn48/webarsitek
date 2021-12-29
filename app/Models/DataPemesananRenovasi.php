<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPemesananRenovasi extends Model
{
    use HasFactory;
    public $table = "data_pemesanan_renovasi";
    protected $fillable = [
        'nama_pemesan',
        'id_pemesan',
        'alamat_pemesan',
        'kontak_pemesan',
        'deskripsi_item',
        'total_harga',
        'pembayaran_via',
        'bukti_pembayaran',
        'status_pengerjaan',
        'no_pemesanan',
    ];

    protected $casts = [
        'deskripsi_item' => 'array'
    ];

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
    public function getTotalHargaAttribute($value)
    {
        return strrev(implode('.', str_split(strrev(strval($value)), 3)));
    }
}
