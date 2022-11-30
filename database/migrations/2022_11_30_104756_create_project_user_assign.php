<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectUserAssign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_user_assign', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("project_id")
                ->comment("Project ID");
            $table->unsignedBigInteger("user_id")
                ->comment("Uploader ID");
            $table->timestamps();

            //Relations with other tables
            $table->foreign('project_id')
                ->references('id')
                ->on('project')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_user_assign');
    }
}
