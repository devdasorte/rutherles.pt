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
        Schema::create('order_list', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 100)->nullable();
            $table->integer('customer_id')->nullable()->index('customer_id');
            $table->text('quantity')->nullable();
            $table->float('total_amount', 12)->default(0);
            $table->boolean('status')->default(false)->comment('1=pending2=paid3=cancelled');
            $table->dateTime('date_created')->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->text('product_name')->nullable();
            $table->string('order_token', 100)->nullable();
            $table->longText('order_numbers',9000000)->nullable();
            $table->integer('product_id')->nullable();
            $table->text('payment_method')->nullable();
            $table->text('order_expiration')->nullable();
            $table->text('pix_code')->nullable();
            $table->text('pix_qrcode')->nullable();
            $table->text('txid')->nullable();
            $table->text('discount_amount')->nullable();
            $table->text('whatsapp_status')->nullable();
            $table->text('dwapi_status')->nullable();
            $table->string('id_mp', 100)->nullable();
            $table->integer('referral_id')->nullable();

            $table->index(['product_id', 'order_numbers', 'code'], 'order_list_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_list');
    }
};
