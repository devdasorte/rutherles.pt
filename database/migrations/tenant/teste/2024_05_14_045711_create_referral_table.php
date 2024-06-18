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
        Schema::create('referral', function (Blueprint $table) {
            $table->integer('id', true);
            $table->boolean('status')->nullable()->default(false);
            $table->string('referral_code', 100)->nullable();
            $table->float('percentage', 12)->default(0);
            $table->float('amount_paid', 12)->default(0);
            $table->float('amount_pending', 12)->default(0);
            $table->integer('customer_id')->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral');
    }
};
