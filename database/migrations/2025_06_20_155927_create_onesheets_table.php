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
        Schema::create('onesheets', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('penerima');
            $table->string('pengirim');
            $table->string('judul_film');
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onesheets');
    }
};
