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
    Schema::create('assets', function (Blueprint $table) {
      $table->id();
      $table->string('grouping_asset');
      $table->string('nama_asset');
      $table->string('brand');
      $table->string('model_type');
      $table->string('serial_number')->nullable();
      $table->string('label_fungsi')->nullable();
      $table->string('penempatan')->nullable();
      $table->text('spesifikasi_detail')->nullable();
      $table->string('foto')->nullable(); // kalau kamu ingin menyimpan path file fotonya
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('assets');
  }
};
