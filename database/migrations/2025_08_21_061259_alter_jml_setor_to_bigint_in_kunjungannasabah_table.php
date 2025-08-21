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
        Schema::table('kunjungannasabah', function (Blueprint $table) {
            // ubah kolom jml_setor menjadi bigInteger
            $table->bigInteger('jml_setor')
                ->default(0)
                ->nullable()
                ->comment('Jumlah Setoran')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungannasabah', function (Blueprint $table) {
            // rollback ke integer lagi
            $table->integer('jml_setor')
                ->default(0)
                ->nullable()
                ->comment('Jumlah Setoran')
                ->change();
        });
    }
};
