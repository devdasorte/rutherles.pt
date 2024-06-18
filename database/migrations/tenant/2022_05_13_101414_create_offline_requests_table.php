<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('email',191);
            $table->bigInteger('plan_id');
            $table->bigInteger('order_id');
            $table->boolean('is_approved')->default(0);
            $table->smallInteger('status')->default(0);
            $table->text('disapprove_reason')->nullable();
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
        Schema::dropIfExists('offline_requests');
    }
}
