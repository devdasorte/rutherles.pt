<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->comment('2');
            $table->integer('id', true);
            $table->string('firstname', 250);
            $table->text('middlename')->nullable();
            $table->string('lastname', 250);
            $table->text('username');
            $table->text('password');
            $table->text('avatar')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->boolean('type')->default(false);
            $table->dateTime('date_added')->useCurrent();
            $table->dateTime('date_updated')->nullable()->useCurrent();
            $table->text('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
