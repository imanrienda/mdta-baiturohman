<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectIdToGradesTable extends Migration
{
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->integer('subject_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('subject_id');
        });
    }
}