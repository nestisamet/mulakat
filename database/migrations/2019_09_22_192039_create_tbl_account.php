<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblAccount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role', 20)->default('ebeveyn');
            $table->string('account_code', 10)->comment('otorize olacak aile bireyi (ebeveyn) ile ogrenciyi eslestiren kod');
            $table->string('email', 100)->unique();
            $table->string('name', 20);
            $table->string('surname', 50);
            $table->string('password', 255);
            $table->char('status', 20)->default('1');
            $table->string('mobile', 20)->nullable();
            $table->char('is_confirmed', 20)->default('0');
            $table->string('confirmation_code', 100)->nullable();
            $table->rememberToken();
            $table->timestamps();
            /**
             * indeksler
             */
            $table->index('account_code');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblAccount');
    }
}
