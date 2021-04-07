<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTraddingJesseTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('candle', function(Blueprint $table)
		{
			$table->uuid('id');
			$table->bigInteger('timestamp');
			$table->double('open', 8, 2);
			$table->double('close', 8, 2);
			$table->double('high', 8, 2);
			$table->double('low', 8, 2);
			$table->double('volume', 8, 2);
			$table->string('symbol');
			$table->string('exchange');

			$table->primary('id');
			$table->unique(['timestamp','exchange','symbol']);
		});

		Schema::create('completedtrade', function(Blueprint $table)
		{
			$table->uuid('id');
			$table->string('strategy_name');
			$table->string('symbol');
			$table->string('exchange');

			$table->string('type');
			$table->string('timeframe');


			$table->double('entry_price', 8, 2);
			$table->double('exit_price', 8, 2);
			$table->double('take_profit_at', 8, 2);
			$table->double('stop_loss_at', 8, 2);
			$table->double('qty', 8, 2);
			$table->bigInteger('opened_at');
			$table->bigInteger('closed_at');
			$table->bigInteger('entry_candle_timestamp');
			$table->bigInteger('exit_candle_timestamp');
			$table->integer('leverage');

			$table->primary('id');
			$table->index(['strategy_name','exchange','symbol']);
		});


		Schema::create('dailybalance', function(Blueprint $table)
		{
			$table->uuid('id');
			$table->bigInteger('timestamp');
			$table->string('identifier');
			$table->string('exchange');
			$table->string('asset');
			$table->double('balance', 8, 2);
			$table->primary('id');
			$table->unique(['identifier','exchange','timestamp', 'asset']);
			$table->index(['identifier','exchange']);
		});



		Schema::create('order', function(Blueprint $table)
		{
			$table->uuid('id');
			$table->uuid('trade_id');
			$table->string('exchange_id');
			$table->json('vars');
			$table->string('symbol');
			$table->string('exchange');
			$table->string('side');
			$table->string('type');
			$table->string('flag');
			$table->double('qty', 8, 2);
			$table->double('price', 8, 2);
			$table->string('status');
			$table->bigInteger('created_at');
			$table->bigInteger('executed_at')->nullable();
			$table->bigInteger('canceled_at')->nullable();
			$table->string('role')->nullable();

			$table->primary('id');
			$table->index(['trade_id']);
			$table->index(['exchange','symbol']);
		});



		Schema::create('orderbook', function(Blueprint $table)
		{
			$table->uuid('id');
			$table->bigInteger('timestamp');
			$table->string('symbol');
			$table->string('exchange');
			$table->string('data'); // @todo tipo bytea databinario

			$table->primary('id');
			$table->unique(['timestamp', 'exchange','symbol']);
		});



		Schema::create('ticker', function(Blueprint $table)
		{
			$table->uuid('id');
			$table->bigInteger('timestamp');
			$table->double('last_price', 8, 2);
			$table->double('volume', 8, 2);
			$table->double('high_price', 8, 2);
			$table->double('low_price', 8, 2);
			$table->string('symbol');
			$table->string('exchange');
			
			$table->primary('id');
			$table->unique(['timestamp', 'exchange','symbol']);
		});



		Schema::create('trade', function(Blueprint $table)
		{
			$table->uuid('id');
			$table->bigInteger('timestamp');
			$table->double('price', 8, 2);
			$table->double('buy_qty', 8, 2);
			$table->double('sell_qty', 8, 2);
			$table->integer('buy_count');
			$table->integer('sell_count');
			$table->string('symbol');
			$table->string('exchange');
			
			$table->primary('id');
			$table->unique(['timestamp', 'exchange','symbol']);
		});


        
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trade');
		Schema::drop('ticker');
		Schema::drop('orderbook');
		Schema::drop('order');
		Schema::drop('dailybalance');
		Schema::drop('completedtrade');
		Schema::drop('candle');
	}

}
