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
        Schema::create('document_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title',191)->nullable();
            $table->string('slug',191)->nullable();
            $table->text('json')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->integer('position')->default(0)->nullable();
            $table->longtext('html')->nullable();
            $table->string('tenant_id',191);
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
        Schema::dropIfExists('document_menus');
    }
};
