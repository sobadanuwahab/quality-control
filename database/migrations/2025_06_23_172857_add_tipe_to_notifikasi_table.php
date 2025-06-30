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
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->string('tipe')->default('umum')->after('isi'); // Menambahkan kolom `tipe` setelah kolom `isi`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropColumn('tipe'); // Menghapus kolom `tipe` saat rollback
        });
    }
};
