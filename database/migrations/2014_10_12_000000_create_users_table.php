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
            $table->string('name')
                  ->comment("User name");
            $table->string('email')
                  ->unique()
                  ->comment("User email");
            $table->string('phone')
                  ->nullable()
                  ->comment("User phone");
            $table->string('image')
                  ->nullable()
                  ->comment("User image");
            $table->string('position')
                  ->comment("User position");
            $table->string('role')
                  ->comment("User role");
            $table->integer('email_verified')
                  ->default(0)
                  ->comment("( 0 - Not Verified | 1 - Verified");
            $table->string('verification_code')
                  ->nullable()
                  ->comment("User verification code");
            $table->integer('stage')
                  ->comment("( 0 - locked | 1 - unlocked");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')
                  ->comment("User password");
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
