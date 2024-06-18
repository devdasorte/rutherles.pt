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
        Schema::table('cart_list', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'customer_id_fk_cl')->references(['id'])->on('customer_list')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['product_id'], 'product_id_fk_cl')->references(['id'])->on('product_list')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_list', function (Blueprint $table) {
            $table->dropForeign('customer_id_fk_cl');
            $table->dropForeign('product_id_fk_cl');
        });
    }
};
