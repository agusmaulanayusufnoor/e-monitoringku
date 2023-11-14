<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
    protected $table='kantor';
    protected $primarykey = "id";
    protected $fillable = [
        'kode_kantor',
        'nama_kantor',
    ];
}
