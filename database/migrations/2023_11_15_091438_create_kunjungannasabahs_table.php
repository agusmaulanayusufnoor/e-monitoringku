<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungannasabah', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_kunjungan');
            $table->string('no_rekening');
            $table->string('nama_nasabah');
            $table->string('kolektibilitas');
            $table->string('no_tlp_nasabah');
            $table->string('lokasi');
            $table->string('hasil');
            $table->string('poto');
            $table->string('kantor_id');
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungannasabah');
    }
};
