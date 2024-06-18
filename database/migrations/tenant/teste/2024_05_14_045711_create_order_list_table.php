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
            $table->increments('id');
            $table->string('code', 100)->nullable();
            $table->unsignedInteger('customer_id')->nullable()->index();
            $table->text('quantity')->nullable();
            $table->float('total_amount', 12, 2)->default(0.00);
            $table->tinyInteger('status')->default(0)->comment('1=pending 2=paid 3=cancelled');
            $table->dateTime('date_created')->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->text('product_name')->nullable();
            $table->string('order_token', 100)->nullable();
            $table->longText('order_numbers')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->text('payment_method')->nullable();
            $table->text('order_expiration')->nullable();
            $table->text('pix_code')->nullable();
            $table->text('pix_qrcode')->nullable();
            $table->text('txid')->nullable();
            $table->text('discount_amount')->nullable();
            $table->text('whatsapp_status')->nullable();
            $table->text('dwapi_status')->nullable();
            $table->string('id_mp', 100)->nullable();
            $table->unsignedInteger('referral_id')->nullable();

            // Adiciona índices
            $table->index('customer_id');
            $table->index(['product_id', 'order_numbers', 'code'], 'order_list_index')->fulltext();

            // Adiciona chave estrangeira
            $table->foreign('customer_id', 'customer_id_fk_ol')
                ->references('id')
                ->on('customer_list')
                ->onDelete('cascade')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_list', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign('customer_id_fk_ol');

            // Remove os índices
            $table->dropIndex(['customer_id']);
            $table->dropIndex('order_list_index');
        });

        Schema::dropIfExists('order_list');
    }
};
