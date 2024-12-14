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
        Schema::table('monitoringdana', function (Blueprint $table) {
            $table->string('keterangan')->after('jml_setoran_baru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitoringdana', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
};
