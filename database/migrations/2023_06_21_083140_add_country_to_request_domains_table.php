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
        Schema::table('request_domains', function (Blueprint $table) {
            $table->string('country',191)->default('India')->after('password');
            $table->string('country_code',191)->nullable()->after('country');
            $table->string('dial_code',191)->nullable()->after('country_code');
            $table->text('phone')->nullable()->after('dial_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_domains', function (Blueprint $table) {
            //
        });
    }
};
