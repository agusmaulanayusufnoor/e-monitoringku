<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kantor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kunjungannasabah extends Model
{
    protected $table='kunjungannasabah';
    protected $primarykey = "id";
    protected $fillable = [
        'tgl_kunjungan',
        'no_rekening',
        'nama_nasabah',
        'kolektibilitas',
        'no_tlp_nasabah',
        'lokasi',
        'hasil',
        'poto',
        'kantor_id',
        'user_id',
    ];

    public function kantor(): BelongsTo
    {
        return $this->belongsTo(Kantor::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
