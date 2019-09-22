<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblStudent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parent_account_code', 10)->comment('otorize olacak aile bireyi (ebeveyn) ile ogrenciyi eslestiren kod');
            $table->string('email', 100)->unique();
            $table->string('name', 20);
            $table->string('surname', 50);
            $table->string('idendity_no', 20)->unique()->comment('kimlik numarasi');
            $table->char('status', 20)->default('1');
            $table->rememberToken();
            $table->timestamps();
            /**
             * indeksler
             */
            $table->index('parent_account_code');
            $table->index('idendity_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblStudent');
    }
}
