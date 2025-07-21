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
    Schema::create('maintenance_projectors', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('admin_id'); // dari session login
      $table->date('tanggal'); // tanggal penerimaan
      $table->string('deskripsi'); // deskripsi singkat
      $table->string('jenis_perangkat'); // projector, sound system, dll
      $table->string('type'); // type/merk
      $table->string('studio'); // lokasi studio
      $table->string('komponen_diganti'); // barang/komponen yang diganti
      $table->text('keterangan')->nullable(); // detail teknis
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('maintenance_projectors');
  }
};
