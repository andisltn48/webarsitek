<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renov extends Model
{
    use HasFactory;
    public $table = 'renov';
    protected $fillable = [
        'nama_item',
        'harga_item',
        'gambar_item',
        'deskripsi_item'
    ];

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
    public function getHargaItemAttribute($value)
    {
        return strrev(implode('.', str_split(strrev(strval($value)), 3)));
    }
}
