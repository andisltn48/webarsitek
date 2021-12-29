<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KartRenov extends Model
{
    use HasFactory;
    public $table = 'data_kart_renov';
    protected $fillable = [
        'nama_item',
        'harga_item',
        'luas_bangunan',
        'id_item',
        'id_pemesan'
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
