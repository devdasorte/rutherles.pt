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
        Schema::create('order_items', function (Blueprint $table) {
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('quantity')->default(0);
            $table->float('price', 12, 2);

            // Adiciona índices
            $table->index('order_id');
            $table->index('product_id');
            $table->index(['order_id', 'product_id', 'quantity', 'price'], 'order_id_2');

            // Adiciona chaves estrangeiras
            $table->foreign('order_id', 'order_id_fk_oi')
                ->references('id')
                ->on('order_list')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('product_id', 'product_id_fk_oi')
                ->references('id')
                ->on('product_list')
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
        Schema::table('order_items', function (Blueprint $table) {
            // Remover as chaves estrangeiras
            $table->dropForeign('order_id_fk_oi');
            $table->dropForeign('product_id_fk_oi');
            
            // Remover os índices
            $table->dropIndex(['order_id']);
            $table->dropIndex(['product_id']);
            $table->dropIndex('order_id_2');
        });

        Schema::dropIfExists('order_items');
    }
};
