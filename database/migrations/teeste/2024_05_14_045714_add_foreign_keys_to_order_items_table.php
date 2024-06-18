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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign(['order_id'], 'order_id_fk_oi')->references(['id'])->on('order_list')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['product_id'], 'product_id_fk_oi')->references(['id'])->on('product_list')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign('order_id_fk_oi');
            $table->dropForeign('product_id_fk_oi');
        });
    }
};
