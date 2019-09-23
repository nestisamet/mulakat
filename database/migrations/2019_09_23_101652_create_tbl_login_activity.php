<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLoginActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblLoginActivity', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->string('user_email', 100);
            $table->string('user_agent', 500);
            $table->string('ip_address', 20);
            $table->string('token', 500)->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblLoginActivity');
    }
}
