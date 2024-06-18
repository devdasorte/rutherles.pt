<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestDomainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_domains', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->string('email',191);
            $table->string('domain_name',191);
            $table->string('password',191);
            $table->string('tenant_id',191)->nullable();
            $table->string('type',191);
            $table->boolean('is_approved')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requestdomain');
    }
}
