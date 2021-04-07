<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTraddingTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('exchanges', function(Blueprint $table)
		{
			$table->string('code')->unique();
			$table->primary('code');
			$table->string('name', 50)->nullable()->unique('name');
			$table->boolean('ccxt')->nullable()->default(0);
			$table->boolean('coinigy')->nullable()->default(0)->index('coinigy');
			$table->integer('coinigy_id')->nullable();
			$table->string('coinigy_exch_code', 10)->nullable()->index('coinigy_exch_code');
			$table->float('coinigy_exch_fee', 10, 0)->nullable();
			$table->boolean('coinigy_trade_enabled')->nullable()->default(0)->index('trade_enabled');
			$table->boolean('coinigy_balance_enabled')->nullable()->default(0)->index('balance_enabled');
			$table->boolean('hasFetchTickers')->nullable()->default(0);
			$table->boolean('hasFetchOHLCV')->nullable()->default(0);
			$table->integer('use')->nullable()->default(0);
			$table->text('data', 65535)->nullable();
			$table->string('url', 200)->nullable();
			$table->string('url_api', 200)->nullable();
			$table->string('url_doc', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('popular_exchanges', function(Blueprint $table)
		{
			$table->string('code')->unique();
			$table->primary('code');
			$table->boolean('public_api')->nullable()->default(0);
			$table->boolean('coinigy')->nullable()->default(0);
			$table->boolean('ccxt')->nullable()->default(0);
			$table->string('link')->nullable();
			$table->text('about', 65535)->nullable();


            $table->foreign('code')->references('code')->on('exchanges');
			$table->timestamps();
			$table->softDeletes();
		});





		Schema::create('traders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('trader_timelines', function(Blueprint $table)
		{
			$table->increments('id');

			$table->text('data', 65535)->nullable();
			$table->string('exchange_code');
			$table->integer('money_id')->unsigned();
			$table->bigInteger('timestamp')->nullable();

			$table->integer('trader_id')->unsigned();
            $table->foreign('trader_id')->references('id')->on('traders');
			$table->timestamps();
			$table->softDeletes();
		});
        
		Schema::create('trade_histories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('about', 65535)->nullable();

			$table->bigInteger('timestamp')->nullable();

			$table->integer('trader_id')->unsigned();
            $table->foreign('trader_id')->references('id')->on('traders');
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
		Schema::drop('trader_timelines');
		Schema::drop('traders');
		Schema::drop('popular_exchanges');
		Schema::drop('exchanges');
	}

}
