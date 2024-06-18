<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('email', 191)->unique();
            $table->string('password', 191);
            $table->string('senha', 191)->nullable();
            $table->string('tenant_id', 191)->nullable();
            $table->string('type', 191);
            $table->string('created_by', 191)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('date_added')->useCurrent = true;
            $table->string('firstname', 250)->nullable();
            $table->text('middlename')->nullable();
            $table->string('lastname', 250)->nullable();
            $table->string('username', 250)->nullable();
            $table->text('avatar')->nullable();
            $table->dateTime('last_login')->nullable();

            $table->timestamps(); // This will create 'created_at' and 'updated_at' columns automatically.
            
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
