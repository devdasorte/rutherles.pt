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
        Schema::create('system_info', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('meta_field');
            $table->text('meta_value');
        });
        
        
        
           DB::table('system_info')->insert([
           
["id"=>"1","meta_field"=>"name","meta_value"=>"Viva De Rifa"],
["id"=>"2","meta_field"=>"short_name","meta_value"=>""],
["id"=>"3","meta_field"=>"logo","meta_value"=>"uploads\/logo.png?v=1711644130"],
["id"=>"4","meta_field"=>"user_avatar","meta_value"=>"uploads\/user_avatar.jpg"],
["id"=>"5","meta_field"=>"cover","meta_value"=>"uploads\/cover.png?v=1675042834"],
["id"=>"6","meta_field"=>"phone","meta_value"=>"41999574716"],
["id"=>"7","meta_field"=>"mobile","meta_value"=>"00000"],
["id"=>"8","meta_field"=>"email","meta_value"=>"admin@vivaderifa.net.br"],
["id"=>"9","meta_field"=>"address","meta_value"=>"Endereço"],
["id"=>"10","meta_field"=>"mercadopago","meta_value"=>"2"],
["id"=>"11","meta_field"=>"mercadopago_access_token","meta_value"=>"APP_USR-1100733831907760-030810-864bc402f5c9d8dbd8bbcf7df4f4a07a-1265932531"],
["id"=>"12","meta_field"=>"gerencianet","meta_value"=>"2"],
["id"=>"13","meta_field"=>"gerencianet_client_id","meta_value"=>""],
["id"=>"14","meta_field"=>"gerencianet_client_secret","meta_value"=>""],
["id"=>"15","meta_field"=>"gerencianet_pix_key","meta_value"=>""],
["id"=>"16","meta_field"=>"gateway","meta_value"=>"1"],
["id"=>"17","meta_field"=>"enable_cpf","meta_value"=>"2"],
["id"=>"18","meta_field"=>"enable_email","meta_value"=>"2"],
["id"=>"19","meta_field"=>"enable_address","meta_value"=>"2"],
["id"=>"20","meta_field"=>"favicon","meta_value"=>"uploads\/favicon.png?v=1711644130"],
["id"=>"21","meta_field"=>"enable_share","meta_value"=>"2"],
["id"=>"22","meta_field"=>"enable_groups","meta_value"=>"2"],
["id"=>"23","meta_field"=>"telegram_group_url","meta_value"=>""],
["id"=>"24","meta_field"=>"whatsapp_group_url","meta_value"=>""],
["id"=>"25","meta_field"=>"enable_footer","meta_value"=>"1"],
["id"=>"26","meta_field"=>"text_footer","meta_value"=>"Viva De Rifa - Todos os direitos reservados."],
["id"=>"27","meta_field"=>"enable_password","meta_value"=>"2"],
["id"=>"28","meta_field"=>"paggue","meta_value"=>"1"],
["id"=>"29","meta_field"=>"paggue_client_key","meta_value"=>"1643437451569936682"],
["id"=>"30","meta_field"=>"paggue_client_secret","meta_value"=>"7646644248834278796"],
["id"=>"31","meta_field"=>"enable_pixel","meta_value"=>"2"],
["id"=>"32","meta_field"=>"facebook_access_token","meta_value"=>"EAAS4OKK4oDQBOzDnvqzzC04ejg798YstrGfGVTe7CUiceJ7ciGO12xeckGqLmCBHzhduSVGTfhtvP2UbZBOKz0b1Iwl0hoO4dtKyxiytBgMWB5uZAkZCht3BFd02zsxWayqlnpb5p71kkKh13e4tkZAeIBTu9QWnfZCqSBXkPr9GR6te0FTwxXHwzq8Bi2tKumAZDZD"],
["id"=>"33","meta_field"=>"facebook_pixel_id","meta_value"=>"669030631869310"],
["id"=>"34","meta_field"=>"enable_hide_numbers","meta_value"=>"1"],
["id"=>"35","meta_field"=>"whatsapp_footer","meta_value"=>""],
["id"=>"36","meta_field"=>"instagram_footer","meta_value"=>""],
["id"=>"37","meta_field"=>"facebook_footer","meta_value"=>""],
["id"=>"38","meta_field"=>"twitter_footer","meta_value"=>"https=>\/\/twitter.com\/"],
["id"=>"39","meta_field"=>"youtube_footer","meta_value"=>"https=>\/\/youtube.com\/"],
["id"=>"40","meta_field"=>"enable_dwapi","meta_value"=>"2"],
["id"=>"41","meta_field"=>"token_dwapi","meta_value"=>""],
["id"=>"42","meta_field"=>"numero_dwapi","meta_value"=>""],
["id"=>"43","meta_field"=>"mensagem_novo_pedido_dwapi","meta_value"=>""],
["id"=>"44","meta_field"=>"mensagem_pedido_pago_dwapi","meta_value"=>""],
["id"=>"45","meta_field"=>"smtp_host","meta_value"=>"smtp.hostinger.com"],
["id"=>"46","meta_field"=>"smtp_port","meta_value"=>" 465"],
["id"=>"47","meta_field"=>"smtp_user","meta_value"=>"barraodadezenapremiada@gmail.com"],
["id"=>"48","meta_field"=>"smtp_pass","meta_value"=>"[a*^jxW5f?RPAc^$"],
["id"=>"49","meta_field"=>"question1","meta_value"=>"Como acessar minhas compras?"],
["id"=>"50","meta_field"=>"answer1","meta_value"=>"Fazendo login no site e abrindo o Menu Principal, você consegue consultar suas últimas compras no menu "],
["id"=>"51","meta_field"=>"question2","meta_value"=>"Como envio o comprovante?"],
["id"=>"52","meta_field"=>"answer2","meta_value"=>"Caso você tenha feito o pagamento via Pix QR Code ou copiando o código, não é necessário enviar o comprovante, aguardando até 5 minutos após o pagamento, o sistema irá dar baixa automaticamente, para mais dúvidas entre em contato conosco clicando aqui."],
["id"=>"53","meta_field"=>"question3","meta_value"=>"Como é o processo do sorteio?"],
["id"=>"54","meta_field"=>"answer3","meta_value"=>"O sorteio será realizado com base na extração da Loteria Federal, conforme Condições de Participação constantes no título"],
["id"=>"55","meta_field"=>"question4","meta_value"=>""],
["id"=>"56","meta_field"=>"answer4","meta_value"=>""],
["id"=>"57","meta_field"=>"terms","meta_value"=>"<b>1)<\/b> Lorem Ipsum is simply dummy text of the printing and typesetting industry. <br><br> <b>2)<\/b> Lorem Ipsum has been the industry&apos;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. <br><br> <b>3)<\/b> It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. <br><br> (i) It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. <br><br> (ii) Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &apos;lorem ipsum&apos; will uncover many web sites still in their infancy."],
["id"=>"58","meta_field"=>"enable_ga4","meta_value"=>"2"],
["id"=>"59","meta_field"=>"google_ga4_id","meta_value"=>"1"],
["id"=>"60","meta_field"=>"license","meta_value"=>"dee"],
["id"=>"61","meta_field"=>"enable_two_phone","meta_value"=>"1"],
["id"=>"62","meta_field"=>"enable_gtm","meta_value"=>"2"],
["id"=>"63","meta_field"=>"google_gtm_id","meta_value"=>""],
["id"=>"64","meta_field"=>"theme","meta_value"=>"2"],
["id"=>"65","meta_field"=>"email_order","meta_value"=>""],
["id"=>"66","meta_field"=>"email_purchase","meta_value"=>""],
["id"=>"67","meta_field"=>"enable_legal_age","meta_value"=>"2"],
["id"=>"68","meta_field"=>"enable_birth","meta_value"=>"2"],
["id"=>"69","meta_field"=>"enable_instagram","meta_value"=>"2"],
["id"=>"70","meta_field"=>"enable_multiple_order","meta_value"=>"2"],
["id"=>"71","meta_field"=>"dealer_active","meta_value"=>"2"],
["id"=>"72","meta_field"=>"dealer_deactive_site","meta_value"=>"2"],
["id"=>"73","meta_field"=>"dealer_split_mercadopago","meta_value"=>"2"],
["id"=>"74","meta_field"=>"mercadopago_tax","meta_value"=>""],
["id"=>"75","meta_field"=>"gerencianet_tax","meta_value"=>""],
["id"=>"76","meta_field"=>"paggue_tax","meta_value"=>"2"],
["id"=>"77","meta_field"=>"openpix_app_id","meta_value"=>""],
["id"=>"78","meta_field"=>"openpix_tax","meta_value"=>""],
["id"=>"79","meta_field"=>"pay2m_client_id","meta_value"=>""],
["id"=>"80","meta_field"=>"pay2m_client_secret","meta_value"=>""],
["id"=>"81","meta_field"=>"pay2m_tax","meta_value"=>"0"],
["id"=>"82","meta_field"=>"openpix","meta_value"=>"2"],
["id"=>"83","meta_field"=>"pay2m","meta_value"=>"2"]

        ]);
    }


    public function down()
    {
        Schema::dropIfExists('system_info');
    }
};
