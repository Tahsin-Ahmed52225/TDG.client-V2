<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("role_id")
                ->comment("Role ID");
            $table->text('route_name')
                ->comment("Route Name");
            $table->foreign('role_id')
                ->references('id')
                ->on('role')
                ->onDelete('cascade');
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
        Schema::dropIfExists('permissons');
    }
}
