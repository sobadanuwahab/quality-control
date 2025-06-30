<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('onesheets', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->after('id');

            // Foreign key ke tabel admin
            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('onesheets', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }
};
