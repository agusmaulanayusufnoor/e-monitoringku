<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kantor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kunjungannasabah extends Model
{

    protected $table = 'kunjungannasabah';
    protected $primaryKey = "id";
    protected $fillable = [
        'tgl_kunjungan',
        'no_rekening',
        'nama_nasabah',
        'kolektibilitas',
        'no_tlp_nasabah',
        'lokasi',
        'hasil',
        'poto',
        'jml_setor',
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
    // Event listener untuk menghapus file gambar ketika record dihapus
    protected static function booted()
    {
        static::deleting(function ($kunjungannasabah) {
            if ($kunjungannasabah->poto) {
                // Verifikasi nama file yang akan dihapus
                \Log::info('Menghapus file gambar: ' . $kunjungannasabah->poto);

                $filePath = $kunjungannasabah->poto;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                    \Log::info('File gambar berhasil dihapus: ' . $filePath);
                } else {
                    \Log::warning('File gambar tidak ditemukan: ' . $filePath);
                }
            }
        });
    }
}
