<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /*
    public function up(): void
    {
        Schema::create('maintenance_hvac', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->date('tanggal');
            $table->string('teknisi');
            $table->string('unit_komponen');
            $table->string('merk_type');
            $table->string('lokasi_area');
            $table->string('tindakan');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_hvac');
    }
        */
};
