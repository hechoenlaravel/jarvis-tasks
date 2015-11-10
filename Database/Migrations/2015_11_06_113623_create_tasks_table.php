<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_tasks', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('board_id')->unsigned();
			$table->string('name');
			$table->text('description');
			$table->date('due_date');
            $table->integer('priority')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('app_users');
            $table->foreign('board_id')->references('id')->on('tasks_boards');
        });
        Schema::create('tasks_tasks_users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('task_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('app_users');
            $table->foreign('task_id')->references('id')->on('tasks_tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks_tasks_users');
        Schema::drop('tasks_tasks');
    }

}
