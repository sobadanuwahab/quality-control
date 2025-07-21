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
    Schema::create('log_meteran', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('admin_id');
      $table->string('nama_meteran');
      $table->date('tanggal');
      $table->integer('angka_meter');
      $table->text('keterangan')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('log_meteran');
  }
};
