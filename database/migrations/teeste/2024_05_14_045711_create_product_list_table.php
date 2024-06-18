<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->text('ranking_1')->nullable();
            $table->text('ranking_2')->nullable();
            $table->text('ranking_3')->nullable();
            $table->text('ranking_4')->nullable();
            $table->text('ranking_5')->nullable();
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
            $table->text('cotas_premiadas_premios')->nullable();
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
            $table->integer('valor_base_auto')->default(50);
            $table->integer('quantidade_numeros')->default(2);
            $table->string('tipo_auto_cota', 100)->nullable()->default('porcentagem');
            $table->boolean('up')->default(false);
            $table->integer('quantidade_auto_cota')->default(50);
        });
        
        
             DB::table('product_list')->insert(
                 
                 [
["id"=>"38","name"=>"Golf GTI 2.0 TSI GTI","description"=>"rferrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr","price"=>"0.00","image_path"=>"uploads\/campanhas\/1_images.jpeg?v=1714680703","status"=>"3","delete_flag"=>"0","date_created"=>"2024-05-02 20=>11=>43","date_updated"=>"2024-05-08 11=>02=>58","type_of_draw"=>"1","qty_numbers"=>"100","min_purchase"=>"1","max_purchase"=>"500","slug"=>"golf-gti-2-0-tsi-gti-2","pending_numbers"=>"0","paid_numbers"=>"100","ranking_qty"=>"1","enable_ranking"=>"1","image_gallery"=>"[\"uploads\\\/campanhas\\\/baixados (1).jpeg\"]","enable_progress_bar"=>"1","draw_number"=>"[\"02\"]","status_display"=>"2","subtitle"=>"erfeeeeeeeeeeeeeeeeeeee","date_of_draw"=>null,"limit_order_remove"=>"","discount_qty"=>"[\"12\",\"\"]","discount_amount"=>"[\"10.00\",\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"1","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"1","draw_winner"=>"[\"87988553793\"]","private_draw"=>"0","featured_draw"=>"1","cotas_premiadas"=>"01,40,50","cotas_premiadas_descricao"=>"","limit_orders"=>"0","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"0","valor_base_auto"=>"0","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"50","name"=>"fazendinha  teste 2","description"=>"","price"=>"0.50","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-08 15=>04=>29","date_updated"=>"2024-05-09 02=>54=>02","type_of_draw"=>"3","qty_numbers"=>"25","min_purchase"=>"1","max_purchase"=>"500","slug"=>"fazendinha-teste-2","pending_numbers"=>"0","paid_numbers"=>"0","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"teste","date_of_draw"=>null,"limit_order_remove"=>"15","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"","cotas_premiadas_descricao"=>"","limit_orders"=>"0","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"0","valor_base_auto"=>"50","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"0","quantidade_auto_cota"=>"50"],
["id"=>"51","name"=>"fazendinha meio","description"=>"","price"=>"0.50","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-08 15=>53=>41","date_updated"=>"2024-05-09 02=>53=>01","type_of_draw"=>"4","qty_numbers"=>"50","min_purchase"=>"1","max_purchase"=>"500","slug"=>"fazendinha-meio","pending_numbers"=>"0","paid_numbers"=>"0","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"","date_of_draw"=>null,"limit_order_remove"=>"15","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"","cotas_premiadas_descricao"=>"","limit_orders"=>"0","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"0","valor_base_auto"=>"50","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"0","quantidade_auto_cota"=>"50"],
["id"=>"52","name"=>"Test","description"=>"dfg","price"=>"0.02","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-08 17=>21=>10","date_updated"=>"2024-05-11 18=>24=>01","type_of_draw"=>"1","qty_numbers"=>"100","min_purchase"=>"1","max_purchase"=>"500","slug"=>"test-2","pending_numbers"=>"0","paid_numbers"=>"0","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"dfg","date_of_draw"=>null,"limit_order_remove"=>"","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"01,05,10,22,33,44,55,66,77,52","cotas_premiadas_descricao"=>"","limit_orders"=>"0","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"0","valor_base_auto"=>"0","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"53","name"=>"Testdd","description"=>"","price"=>"0.02","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-08 20=>13=>06","date_updated"=>"2024-05-08 20=>13=>48","type_of_draw"=>"1","qty_numbers"=>"100","min_purchase"=>"1","max_purchase"=>"500","slug"=>"testdd-2","pending_numbers"=>"0","paid_numbers"=>"51","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"dfg","date_of_draw"=>null,"limit_order_remove"=>"","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"01,05,10,22,33,44,55,66,77,52","cotas_premiadas_descricao"=>"","limit_orders"=>"0","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"0","valor_base_auto"=>"0","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"56","name"=>"sdfsdfsd","description"=>"sdfsdfsdf","price"=>"0.03","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-08 20=>19=>15","date_updated"=>"2024-05-13 18=>59=>01","type_of_draw"=>"1","qty_numbers"=>"100000","min_purchase"=>"1","max_purchase"=>"10000","slug"=>"sdfsdfsd","pending_numbers"=>"0","paid_numbers"=>"0","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"sfsfsdf","date_of_draw"=>null,"limit_order_remove"=>"15","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"111111,22222,33333,55555,88888,99999","cotas_premiadas_descricao"=>"","limit_orders"=>"0","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"1","valor_base_auto"=>"30000","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"57","name"=>"Carro zero","description"=>"dqwcfrw","price"=>"0.10","image_path"=>null,"status"=>"3","delete_flag"=>"0","date_created"=>"2024-05-08 20=>29=>22","date_updated"=>"2024-05-11 18=>08=>17","type_of_draw"=>"1","qty_numbers"=>"1000","min_purchase"=>"11","max_purchase"=>"20","slug"=>"carro-zero","pending_numbers"=>"0","paid_numbers"=>"2","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"4","subtitle"=>"avre","date_of_draw"=>"2024-05-09 17=>28=>00","limit_order_remove"=>"15","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"","cotas_premiadas_descricao"=>"","limit_orders"=>"50","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"1","valor_base_auto"=>"250","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"58","name"=>"onix novo 10000000","description"=>"rv","price"=>"10.00","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-08 20=>32=>17","date_updated"=>"2024-05-08 22=>33=>25","type_of_draw"=>"1","qty_numbers"=>"100","min_purchase"=>"1","max_purchase"=>"20","slug"=>"onix-novo-10000000","pending_numbers"=>"0","paid_numbers"=>"1","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"teste","date_of_draw"=>"2024-05-09 17=>31=>00","limit_order_remove"=>"30","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"1","cotas_premiadas"=>"","cotas_premiadas_descricao"=>"","limit_orders"=>"50","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"1","valor_base_auto"=>"0","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"59","name"=>"ec","description"=>"wrfv","price"=>"0.10","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-08 20=>40=>31","date_updated"=>"2024-05-08 20=>40=>36","type_of_draw"=>"1","qty_numbers"=>"100","min_purchase"=>"2","max_purchase"=>"10","slug"=>"ec","pending_numbers"=>"0","paid_numbers"=>"1","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"wfrv","date_of_draw"=>null,"limit_order_remove"=>"15","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"","cotas_premiadas_descricao"=>"","limit_orders"=>"10","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"1","valor_base_auto"=>"25","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"60","name"=>"BRENDO SOUZA","description"=>"wWEF ","price"=>"0.00","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-08 20=>41=>46","date_updated"=>"2024-05-13 23=>38=>05","type_of_draw"=>"1","qty_numbers"=>"100","min_purchase"=>"1","max_purchase"=>"50","slug"=>"brendo-souza","pending_numbers"=>"0","paid_numbers"=>"12","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"teste","date_of_draw"=>"2024-05-17 17=>41=>00","limit_order_remove"=>"60","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"","cotas_premiadas_descricao"=>"","limit_orders"=>"50","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"1","valor_base_auto"=>"75","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"61","name"=>"testando","description"=>"sdfsdf","price"=>"0.01","image_path"=>null,"status"=>"3","delete_flag"=>"0","date_created"=>"2024-05-08 20=>44=>15","date_updated"=>"2024-05-08 20=>52=>24","type_of_draw"=>"1","qty_numbers"=>"100000","min_purchase"=>"1","max_purchase"=>"10000","slug"=>"testando-2","pending_numbers"=>"0","paid_numbers"=>"100000","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"6","subtitle"=>"dssdfds","date_of_draw"=>null,"limit_order_remove"=>"","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"11111,22222,33333,44444,55555,66666,78888,99999","cotas_premiadas_descricao"=>"","limit_orders"=>"0","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"1000","status_auto_cota"=>"0","valor_base_auto"=>"25000","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"62","name"=>"pagger","description"=>"","price"=>"1.00","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-11 01=>30=>05","date_updated"=>"2024-05-12 19=>39=>01","type_of_draw"=>"1","qty_numbers"=>"100","min_purchase"=>"1","max_purchase"=>"500","slug"=>"pagger","pending_numbers"=>"0","paid_numbers"=>"0","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"","date_of_draw"=>null,"limit_order_remove"=>"15","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"","cotas_premiadas_descricao"=>"","limit_orders"=>"0","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"0","valor_base_auto"=>"0","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"63","name"=>"novorifa33","description"=>"","price"=>"0.00","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-11 18=>54=>29","date_updated"=>"2024-05-11 18=>54=>31","type_of_draw"=>"1","qty_numbers"=>"100","min_purchase"=>"1","max_purchase"=>"500","slug"=>"novorifa33","pending_numbers"=>"0","paid_numbers"=>"3","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"","date_of_draw"=>null,"limit_order_remove"=>"","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"01,40,50","cotas_premiadas_descricao"=>"","limit_orders"=>"0","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"0","valor_base_auto"=>"0","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"],
["id"=>"64","name"=>"novorifa2","description"=>"","price"=>"0.00","image_path"=>null,"status"=>"1","delete_flag"=>"0","date_created"=>"2024-05-11 18=>56=>01","date_updated"=>"2024-05-11 18=>56=>25","type_of_draw"=>"1","qty_numbers"=>"100","min_purchase"=>"1","max_purchase"=>"500","slug"=>"novorifa2","pending_numbers"=>"0","paid_numbers"=>"3","ranking_qty"=>"0","enable_ranking"=>"0","image_gallery"=>"[]","enable_progress_bar"=>"0","draw_number"=>"","status_display"=>"1","subtitle"=>"","date_of_draw"=>null,"limit_order_remove"=>"","discount_qty"=>"[\"\"]","discount_amount"=>"[\"0.00\"]","enable_discount"=>"0","enable_cumulative_discount"=>"0","enable_sale"=>"0","sale_qty"=>"0","sale_price"=>"0.00","ranking_message"=>"Quem comprar mais cotas, 1º lugar ganha=> R$","enable_ranking_show"=>"0","draw_winner"=>"[\"\"]","private_draw"=>"0","featured_draw"=>"0","cotas_premiadas"=>"01,40,50","cotas_premiadas_descricao"=>"","limit_orders"=>"0","ranking_type"=>"1","qty_select_1"=>"10","qty_select_2"=>"20","qty_select_3"=>"50","qty_select_4"=>"100","qty_select_5"=>"200","qty_select_6"=>"300","status_auto_cota"=>"1","valor_base_auto"=>"25","quantidade_numeros"=>"2","tipo_auto_cota"=>"porcentagem","up"=>"1","quantidade_auto_cota"=>"50"]
]
                 
                 );
        
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
