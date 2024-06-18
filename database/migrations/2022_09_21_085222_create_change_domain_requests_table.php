<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeDomainRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_domain_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->string('email',191);
            $table->string('domain_name',191);
            $table->text('reason')->nullable();
            $table->integer('tenant_id');
            $table->integer('status');
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
        Schema::dropIfExists('change_domain_requests');
    }
}
