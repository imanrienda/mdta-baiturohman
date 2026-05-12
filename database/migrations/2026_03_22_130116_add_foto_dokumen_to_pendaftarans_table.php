<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFotoDokumenToPendaftaransTable extends Migration
{
    public function up()
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftarans', 'foto')) {
                $table->string('foto')->nullable()->after('kelas_tujuan');
            }

            if (!Schema::hasColumn('pendaftarans', 'dokumen')) {
                $table->string('dokumen')->nullable()->after('foto');
            }
        });
    }

    public function down()
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftarans', 'foto')) {
                $table->dropColumn('foto');
            }

            if (Schema::hasColumn('pendaftarans', 'dokumen')) {
                $table->dropColumn('dokumen');
            }
        });
    }
}