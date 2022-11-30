<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_file', function (Blueprint $table) {
            $table->id();
            $table->text("description")->nullable()
                ->comment("Project File Description");
            $table->longText("file_path")
                ->comment("Project File Path");
            $table->unsignedBigInteger("project_id")
                ->comment("Project ID");
            $table->unsignedBigInteger("user_id")
                ->comment("Uploader ID");



            //Relations with other tables
            $table->foreign('project_id')
                ->references('id')
                ->on('project')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('project_file');
    }
}
