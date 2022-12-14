<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createproject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->string("title")
                  ->comment("Project Title");
            $table->unsignedBigInteger("created_by")
                  ->comment("Project Added By")
                  ->nullable();
            $table->unsignedBigInteger("client_id")
                  ->nullable()
                  ->comment("Project Client ID");
            $table->integer("manager_id")
                  ->nullable()
                  ->comment("Project Manager ID");
            $table->dateTime("due_date")
                  ->nullable()
                  ->comment("Project Due Date");
            $table->string("status")
                  ->nullable()
                  ->comment("Project Added By");
            $table->string("priority")
                  ->nullable()
                  ->comment("Project Priority");
            $table->text("description")
                  ->nullable()
                  ->comment("Project Description");
            $table->text("type")
                  ->nullable()
                  ->comment("Project Type");
            $table->integer("budget")
                  ->nullable()
                  ->comment("Project Budget");
            $table->softDeletes();
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
        //
    }
}
