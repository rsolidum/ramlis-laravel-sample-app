<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelationshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('relationships', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('followed_id');
			$table->integer('user_id');
			$table->index('followed_id');
			$table->index('user_id');
			$table->index(array('followed_id', 'user_id'));
			$table->unique( array('followed_id','user_id') );
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
		Schema::drop('relationships');
	}

}
