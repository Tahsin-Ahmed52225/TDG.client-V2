<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSubtaskUserAssign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_subtask_user_assign', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("project_subtask_id")
                ->comment("Project Subtask ID");
            $table->unsignedBigInteger("user_id")
                ->comment("Uploader ID");
            $table->timestamps();

             //Relations with other tables
             $table->foreign('project_subtask_id')
                ->references('id')
                ->on('project_subtask')
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
        Schema::dropIfExists('project_subtask_user_assign');
    }
}
