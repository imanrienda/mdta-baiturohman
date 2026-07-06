<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSemesterIdToPendaftaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::table('pendaftarans', function (Blueprint $table) {
        $table->unsignedBigInteger('semester_id')->nullable()->after('kelas_tujuan');
        $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('pendaftarans', function (Blueprint $table) {
        $table->dropForeign(['semester_id']);
        $table->dropColumn('semester_id');
    });
}
}
