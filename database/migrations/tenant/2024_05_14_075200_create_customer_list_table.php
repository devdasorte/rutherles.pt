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
        Schema::create('customer_list', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('firstname');
            $table->text('lastname');
            $table->text('phone');
            $table->text('email')->nullable();
            $table->text('password')->nullable();
            $table->text('avatar')->nullable();
            $table->dateTime('date_created')->useCurrent();
            $table->dateTime('date_updated')->useCurrent();
            $table->text('cpf')->nullable();
            $table->text('zipcode')->nullable();
            $table->text('address')->nullable();
            $table->text('number')->nullable();
            $table->text('neighborhood')->nullable();
            $table->text('complement')->nullable();
            $table->text('state')->nullable();
            $table->text('city')->nullable();
            $table->text('reference_point')->nullable();
            $table->boolean('is_affiliate')->nullable()->default(false);
            $table->date('birth')->nullable();
            $table->text('instagram')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_list');
    }
};
