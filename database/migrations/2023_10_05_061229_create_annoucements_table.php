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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title',191);
            $table->longText('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('share_with_public',191);
            $table->string('image',191);
            $table->string('show_landing_page_announcebar',191);
            $table->string('status',191)->default('1');
            $table->string('slug',191);
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
        Schema::dropIfExists('announcements');
    }
};
