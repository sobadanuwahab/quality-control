<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_projectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('admin_id');
            $table->date('tanggal');
            $table->string('jenis_perangkat');
            $table->string('type_merk');
            $table->string('studio');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Foreign key ke tabel admin
            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_projectors');
    }
};
