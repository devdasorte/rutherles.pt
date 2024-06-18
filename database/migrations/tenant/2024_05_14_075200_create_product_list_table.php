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
        Schema::create('product_list', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->text('description');
            $table->float('price', 12)->default(0);
            $table->text('image_path')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('delete_flag')->default(false);
            $table->dateTime('date_created')->useCurrent();
            $table->dateTime('date_updated')->useCurrent();
            $table->boolean('type_of_draw')->default(true);
            $table->text('qty_numbers');
            $table->text('min_purchase');
            $table->text('max_purchase');
            $table->text('slug');
            $table->text('pending_numbers');
            $table->text('paid_numbers');
            $table->text('ranking_qty');
            $table->text('enable_ranking');
            $table->text('image_gallery')->nullable();
            $table->text('enable_progress_bar');
            $table->text('draw_number')->nullable();
            $table->text('status_display');
            $table->text('subtitle')->nullable();
            $table->dateTime('date_of_draw')->nullable();
            $table->text('limit_order_remove')->nullable();
            $table->text('discount_qty')->nullable();
            $table->text('discount_amount')->nullable();
            $table->text('enable_discount')->nullable();
            $table->text('enable_cumulative_discount')->nullable();
            $table->text('enable_sale')->nullable();
            $table->text('sale_qty')->nullable();
            $table->float('sale_price', 12)->nullable()->default(0);
            $table->text('ranking_message')->nullable();
            $table->text('enable_ranking_show')->nullable();
            $table->text('draw_winner')->nullable();
            $table->text('private_draw');
            $table->text('featured_draw')->nullable();
            $table->text('cotas_premiadas')->nullable();
            $table->text('cotas_premiadas_descricao')->nullable();
            $table->integer('limit_orders')->nullable()->default(0);
            $table->integer('ranking_type')->default(1);
            $table->integer('qty_select_1')->default(10);
            $table->integer('qty_select_2')->default(20);
            $table->integer('qty_select_3')->default(50);
            $table->integer('qty_select_4')->default(100);
            $table->integer('qty_select_5')->default(200);
            $table->integer('qty_select_6')->default(300);
            $table->boolean('status_auto_cota')->default(false);
            $table->unsignedInteger('valor_base_auto')->default(50);
            $table->unsignedInteger('quantidade_numeros')->default(2);
            $table->string('tipo_auto_cota')->default('porcentagem');
            $table->boolean('up')->default(false);
            $table->unsignedInteger('quantidade_auto_cota')->default(50);
            $table->timestamps();

        });
        
          DB::table('product_list')->insert(
[




    ["id"=>"80","name"=>"Onix Joy 1.0 2019","description"=>"O motor 1.0 Flex, de 4 cilindros em linha e duas válvulas por cilindro, entrega uma potência de 80 CV com etanol e 78 CV com gasolina, chegando a uma velocidade de 167 KM\/h e aceleração de 0 a 100 km em 13,4 segundos.","price"=>"0.10","image_path"=>"uploads\/campanhas\/2_images.jpeg?v=1718222443","status"=>"1","delete_flag"=>"0","date_created"=>"2024-06-12 20=>00=>43","date_updated"=>"2024-06-12 20=>00=>43","type_of_draw"=>"1","qty_numbers"=>"1000","min_purchase"=>"1","max_purchase"=>"500","slug"=>"onix-joy-1-0-2019","pending_numbers"=>"0","paid_numbers"=>"0","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"1","draw_number"=>"","status_display"=>"1","subtitle"=>"Onix Joy 1.0 2019","date_of_draw"=>null,"limit_order_remove"=>"15","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"1","cotas_premiadas"=>"","cotas_premiadas_descricao"=>"","limit_orders"=>"500","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"0","valor_base_auto"=>"5","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"0","quantidade_auto_cota"=>"50","created_at"=>null,"updated_at"=>null],
    ["id"=>"81","name"=>"Fazendinha","description"=>"","price"=>"0.10","image_path"=>"uploads/campanhas/imagen-top-farm-1ori.jpg?v=1718222521","status"=>"1","delete_flag"=>"0","date_created"=>"2024-06-12 20=>02=>01","date_updated"=>"2024-06-12 20=>02=>01","type_of_draw"=>"3","qty_numbers"=>"25","min_purchase"=>"1","max_purchase"=>"500","slug"=>"fazendinha","pending_numbers"=>"0","paid_numbers"=>"0","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"Fazendinha Completa","date_of_draw"=>null,"limit_order_remove"=>"15","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"","cotas_premiadas_descricao"=>"","limit_orders"=>"500","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"0","valor_base_auto"=>"5","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"0","quantidade_auto_cota"=>"50","created_at"=>null,"updated_at"=>null],
    ["id"=>"82","name"=>"Meia Fazendinha","description"=>"Meia fazendinha ","price"=>"0.10","image_path"=>"uploads/campanhas/meiafazendinha.jpg?v=1718223307","status"=>"1","delete_flag"=>"0","date_created"=>"2024-06-12 20=>15=>07","date_updated"=>"2024-06-12 20=>15=>07","type_of_draw"=>"4","qty_numbers"=>"50","min_purchase"=>"1","max_purchase"=>"500","slug"=>"meia-fazendinha","pending_numbers"=>"0","paid_numbers"=>"0","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"Meia fazendinha","date_of_draw"=>null,"limit_order_remove"=>"15","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"","cotas_premiadas_descricao"=>"","limit_orders"=>"500","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"0","valor_base_auto"=>"5","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"0","quantidade_auto_cota"=>"50","created_at"=>null,"updated_at"=>null]
    
    





]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_list');
    }
};
