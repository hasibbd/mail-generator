<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gen_mails', function (Blueprint $table) {
            $table->id();
            $table->integer('cus_id');
            $table->string('recover_mail');
            $table->string('password');
            $table->integer('target_dot');
            $table->string('target_mail');
            $table->string('target_provider');
            $table->string('gen_mail');
            $table->dateTime('posted_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gen_mails');
    }
}
