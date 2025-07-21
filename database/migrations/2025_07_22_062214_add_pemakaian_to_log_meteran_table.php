<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('log_meteran', function (Blueprint $table) {
      $table->decimal('pemakaian', 10, 2)->nullable()->after('akhir');
    });
  }

  public function down(): void
  {
    Schema::table('log_meteran', function (Blueprint $table) {
      $table->dropColumn('pemakaian');
    });
  }
};
