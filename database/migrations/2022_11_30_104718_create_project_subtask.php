<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSubtask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_subtask', function (Blueprint $table) {
            $table->id();
            $table->text("title")
                ->comment("Project Subtask Name");
            $table->longText("description")
                ->nullable()
                ->comment("Project Subtask Description");
            $table->text("priority")
                ->default("low")
                ->comment("Project Subtask Priority");
            $table->timestamp("due_date")
                ->nullable()
                ->comment("Project Subtask Due Date");
            $table->text("status")
                ->default("todo")
                ->comment("Project Subtask Status");
            $table->boolean("complete")
                ->default(false)
                ->comment("Project Subtask Complete");
            $table->unsignedBigInteger("project_id")
                ->nullable()
                ->comment("Project ID");


            $table->foreign('project_id')
                ->references('id')
                ->on('project')
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
        Schema::dropIfExists('project_subtask');
    }
}
