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
        Schema::create('dcp_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('admin_id');
            $table->date('tanggal_penerimaan');
            $table->string('nama_penerima');
            $table->string('pengirim');
            $table->json('film_details');
            $table->timestamps();

    $table->foreign('admin_id')->references('id')->on('admin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dcp_reports');
    }
};
