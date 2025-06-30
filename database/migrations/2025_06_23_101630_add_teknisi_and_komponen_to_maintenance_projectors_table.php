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
        Schema::table('maintenance_projectors', function (Blueprint $table) {
            $table->string('teknisi')->after('tanggal');
            $table->string('komponen_diganti')->nullable()->after('studio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_projectors', function (Blueprint $table) {
            $table->dropColumn(['teknisi', 'komponen_diganti']);
        });
    }
};
