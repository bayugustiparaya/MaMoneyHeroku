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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('balance')->default(0);
            $table->integer('point')->default(0);
            $table->integer('saving_balance')->default(0);
            $table->integer('spending_target')->default(0);
            $table->integer('spending')->default(0);
            $table->integer('saving_before_trans')->default(1);
            $table->string('level')->default('user');
            $table->string('password');
            $table->integer('is_active')->default(1);
            $table->string('photo')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
