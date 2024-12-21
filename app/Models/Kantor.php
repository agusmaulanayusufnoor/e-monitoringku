<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kunjungannasabah;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kantor extends Model
{
    protected $table='kantor';
    protected $primarykey = "id";
    protected $fillable = [
        'kode_kantor',
        'nama_kantor',
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);

    }

    public function kunjungannasabah(): HasMany
    {
        return $this->hasMany(Kunjungannasabah::class);

    }
}
