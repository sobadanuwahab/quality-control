<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('admin', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('email')->unique();
      $table->string('password');
      $table->boolean('is_superuser')->default(false);
      $table->enum('role', ['admin', 'user'])->default('user');
      $table->rememberToken();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('admin');
  }
};
