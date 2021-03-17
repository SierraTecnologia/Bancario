<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatsTraddingTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('traders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('item', 80)->nullable()->index('item');
			$table->string('value', 1500)->nullable();
			$table->integer('exchange_id')->unsigned()->index('exchange_id');
			$table->timestamps();
			$table->softDeletes();
        });
        
		Schema::create('trade_histories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('exchange_id')->unsigned()->index('exchange_id1');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trade_histories');
		Schema::drop('traders');
	}

}
