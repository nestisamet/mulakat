<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTblStudent extends Migration
{
    /**
     * tblStudent a fazladan eklenen alani dropluyoruz
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblStudent', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblStudent', function (Blueprint $table) {
            $table->rememberToken();
        });
    }
}
