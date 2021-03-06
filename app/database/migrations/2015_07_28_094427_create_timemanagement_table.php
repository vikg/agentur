<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimemanagementTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timemanagement', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('project_id');
			$table->integer('work_group');
			$table->integer('work_task');
			$table->string('work_description');
			$table->dateTime('date');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('timemanagement');
	}

}
