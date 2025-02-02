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
        Schema::table('referral', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'customer_id_fk_re')->references(['id'])->on('customer_list')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referral', function (Blueprint $table) {
            $table->dropForeign('customer_id_fk_re');
        });
    }
};
