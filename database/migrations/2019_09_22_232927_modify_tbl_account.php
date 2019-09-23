<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTblAccount extends Migration
{
    /**
     * yeni kullanici hesabini aktiflestirme adina olusturulan alanlar uygulamanin kapsaminda olmadigindan droplandi
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblAccount', function (Blueprint $table) {
            $table->dropColumn(['status','is_confirmed','confirmation_code']);
            $table->string('role', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
