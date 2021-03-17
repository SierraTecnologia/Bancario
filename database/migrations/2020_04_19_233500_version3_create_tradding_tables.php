<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Version3CreateTraddingTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exchanges', function(Blueprint $table)
		{
			$table->increments('id');
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
			$table->increments('id');
			$table->integer('exchange_id')->unsigned();
			$table->boolean('public_api')->nullable()->default(0);
			$table->boolean('coinigy')->nullable()->default(0);
			$table->boolean('ccxt')->nullable()->default(0);
			$table->string('link')->nullable();
			$table->text('about', 65535)->nullable();


            $table->foreign('exchange_id')->references('id')->on('exchanges');
			$table->timestamps();
			$table->softDeletes();
		});


		Schema::create('configs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('item', 80)->nullable()->index('item');
			$table->string('value', 1500)->nullable();
			$table->integer('exchange_id')->unsigned();
            $table->foreign('exchange_id')->references('id')->on('exchanges');
			$table->timestamps();
			$table->softDeletes();
        });
        
		Schema::create('exchange_accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('auth_id')->nullable()->index('auth_id');
			$table->integer('exchange_id')->unsigned();
			$table->string('auth_key')->unique();
			$table->string('auth_secret')->nullable();
			$table->string('auth_optional1')->nullable();
			$table->string('auth_nickname')->nullable();
			$table->string('auth_updated')->nullable();
			$table->boolean('auth_active')->nullable();
			$table->boolean('auth_trade')->nullable();
			$table->boolean('exch_trade_enabled')->nullable();


            $table->foreign('exchange_id')->references('id')->on('exchanges');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('exchange_addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('exchange_id')->unsigned();
            $table->string('money_code');
            $table->foreign('money_code')->references('code')->on('moneys');
			$table->string('address');
            $table->foreign('exchange_id')->references('id')->on('exchanges');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('exchange_balances', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('auth_id')->nullable()->index('auth_id1');
			$table->integer('exchange_id')->unsigned();
            $table->string('money_code');
            $table->foreign('money_code')->references('code')->on('moneys');
			$table->float('balance_amount_avail', 10, 0)->nullable();
			$table->float('balance_amount_held', 10, 0)->nullable();
			$table->float('balance', 10, 0)->nullable();
			$table->float('btc_balance', 10, 0)->nullable();
			$table->float('last_price', 10, 0)->nullable();

            $table->foreign('exchange_id')->references('id')->on('exchanges');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('exchange_pairs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('exchange_id')->unsigned();
			$table->integer('market_id')->nullable()->default(0);
			$table->string('exchange_pair', 90)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->index(['exchange_id','market_id','exchange_pair'], 'exchange_id2');

            $table->foreign('exchange_id')->references('id')->on('exchanges');
		});
		Schema::create('ohlcvs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('exchange_id')->unsigned();
			$table->string('symbol', 90)->nullable();
			$table->bigInteger('timestamp')->nullable();
			$table->dateTime('datetime')->nullable()->index('datetime_ohlcvs');
			$table->float('open', 10, 0)->nullable();
			$table->float('high', 10, 0)->nullable();
			$table->float('low', 10, 0)->nullable();
			$table->float('close', 10, 0)->nullable();
			$table->float('volume', 10, 0)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->unique(['exchange_id','symbol','timestamp'], 'exchange_id_ohlcvs');

            $table->foreign('exchange_id')->references('id')->on('exchanges');
		});

		Schema::create('tickers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('exchange_id')->unsigned();
			$table->string('symbol', 90)->nullable()->index('symbol');
			$table->string('period', 90)->nullable()->index('period');
			$table->bigInteger('open_time')->nullable()->index('open_time');
			$table->bigInteger('close_time')->nullable()->index('close_time');
			$table->dateTime('datetime')->nullable()->index('datetime1');

			$table->float('open', 10, 0)->nullable();
			$table->float('high', 10, 0)->nullable();
			$table->float('low', 10, 0)->nullable();
			$table->float('bid', 10, 0)->nullable();
			$table->float('close', 10, 0)->nullable();
			$table->float('volume', 10, 0)->nullable();
			$table->float('asset_volume', 10, 0)->nullable();
			$table->float('base_volume', 10, 0)->nullable();
			$table->float('asset_buy_volume', 10, 0)->nullable();
			$table->float('taker_buy_volume', 10, 0)->nullable();
			$table->float('quotevolume', 10, 0)->nullable();

			$table->float('trades', 10, 0)->nullable();
			$table->float('ask', 10, 0)->nullable();
			$table->float('vwap', 10, 0)->nullable();
			$table->float('first', 10, 0)->nullable();
			$table->float('last', 10, 0)->nullable();
			$table->float('change', 10, 0)->nullable();
			$table->float('percentage', 10, 0)->nullable();
			$table->float('average', 10, 0)->nullable();
			$table->boolean('ignored')->nullable()->default(0);
			$table->timestamps();
			$table->softDeletes();


            $table->foreign('exchange_id')->references('id')->on('exchanges');
			$table->unique(['exchange_id', 'symbol', 'period' , 'close_time'], 'exchange_id_23');
        });
        
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('popular_exchanges');
		Schema::drop('tickers');
		Schema::drop('ohlcvs');
		Schema::drop('exchange_pairs');
        Schema::drop('exchange_balances');
		Schema::drop('exchange_addresses');
		Schema::drop('exchange_accounts');
		Schema::drop('configs');
		Schema::drop('exchanges');
	}

}
