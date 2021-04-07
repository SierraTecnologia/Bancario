<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTraddingDebugsTables extends Migration {

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
            $table->string('exchange_code');
			$table->string('symbol', 10);
			$table->float('price', 10, 0);
			$table->integer('time')->unsigned();
			// $table->timestamp('time')->unsigned()->default(\DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('exchange_code')->references('code')->on('exchanges');

			$table->unique(['exchange_code','symbol','time'], 'tradding_price_history');

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
