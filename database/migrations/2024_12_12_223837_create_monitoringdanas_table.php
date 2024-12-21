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
        Schema::create('monitoringdana', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_kunjungan');
            $table->unsignedInteger('jml_noa')->nullable();
            $table->unsignedBigInteger('jml_setoran')->nullable();
            $table->unsignedInteger('jml_noa_baru')->nullable();
            $table->unsignedBigInteger('jml_setoran_baru')->nullable();
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
        Schema::dropIfExists('monitoringdanas');
    }
};
