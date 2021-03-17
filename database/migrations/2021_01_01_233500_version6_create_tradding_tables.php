<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Version6CreateTraddingTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tradding_histories', function(Blueprint $table)
		{
			$table->id();
			$table->integer('exchange_id')->unsigned();
			$table->string('symbol', 10);
			$table->float('price', 10, 0);
			$table->integer('time')->unsigned();
			// $table->timestamp('time')->unsigned()->default(\DB::raw('CURRENT_TIMESTAMP'));

			$table->unique(['exchange_id','symbol','time'], 'tradding_price_history');

		// 	$table->increments('id');
		// 	$table->boolean('public_api')->nullable()->default(0);
		// 	$table->boolean('coinigy')->nullable()->default(0);
		// 	$table->boolean('ccxt')->nullable()->default(0);
		// 	$table->string('link')->nullable();
		// 	$table->text('about', 65535)->nullable();
		// 	$table->timestamps();
		// 	$table->softDeletes();
		});


        
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tradding_histories');
	}

}
