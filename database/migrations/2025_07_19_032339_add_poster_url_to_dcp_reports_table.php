<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPosterUrlToDcpReportsTable extends Migration
{
  public function up()
  {
    Schema::table('dcp_reports', function (Blueprint $table) {
      $table->string('poster_url')->nullable()->after('film_details');
    });
  }

  public function down()
  {
    Schema::table('dcp_reports', function (Blueprint $table) {
      $table->dropColumn('poster_url');
    });
  }
}
