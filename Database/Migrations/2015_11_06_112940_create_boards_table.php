<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_boards', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('flow_id')->unsigned();
            $table->integer('user_id')->unsigned();
			$table->string('name');
            $table->string('uuid')->index();
			$table->text('description');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('app_users');
            $table->foreign('flow_id')->references('id')->on('fl_flows');
        });
        Schema::create('tasks_boards_users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('board_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('can_assign')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('app_users');
            $table->foreign('board_id')->references('id')->on('tasks_boards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks_boards_users');
        Schema::drop('tasks_boards');
    }

}
