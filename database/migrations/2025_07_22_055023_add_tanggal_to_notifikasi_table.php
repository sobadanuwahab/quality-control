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
      $table->date('tanggal_awal')->nullable()->after('id');
      $table->date('tanggal_berakhir')->nullable()->after('tanggal_awal');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('notifikasi', function (Blueprint $table) {
      //
    });
  }
};
