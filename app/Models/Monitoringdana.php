<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kantor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Monitoringdana extends Model
{
    protected $table='monitoringdana';
    protected $primarykey = "id";
    protected $fillable = [
        'tgl_kunjungan',
        'jml_noa',
        'jml_setoran',
        'jml_noa_baru',
        'jml_setoran_baru',
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
