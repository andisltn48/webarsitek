<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    use HasFactory;
    public $table = 'revisi';
    protected $fillable = [
        "id_pemesan",
        "id_pesanan",
        "revisi",
        "revisi_tahap",
        "status_revisi",
    ];
}
