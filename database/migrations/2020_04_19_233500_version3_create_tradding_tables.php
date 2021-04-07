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

		Schema::create('configs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('trader_id')->nullable()->unsigned();
			$table->string('item', 80)->nullable()->index('item');
			$table->string('value', 1500)->nullable();

            $table->foreign('trader_id')->references('id')->on('traders');


			$table->unique(['trader_id','item'], 'trader_item_config');
			// 
            // $table->string('exchange_code');
            // $table->foreign('exchange_code')->references('code')->on('exchanges');
            // $table->foreign('exchange_code')->references('code')->on('exchanges');
			$table->timestamps();
			$table->softDeletes();
        });
        
		Schema::create('exchange_accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('trader_id')->unsigned();
			
            $table->string('exchange_code');
			$table->string('auth_key')->unique();
			$table->string('auth_secret')->nullable();
			$table->string('auth_optional1')->nullable();
			$table->string('auth_nickname')->nullable();
			$table->string('auth_updated')->nullable();
			$table->boolean('auth_active')->nullable();
			$table->boolean('auth_trade')->nullable();
			$table->boolean('exch_trade_enabled')->nullable();

            $table->foreign('trader_id')->references('id')->on('traders');
            $table->foreign('exchange_code')->references('code')->on('exchanges');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('exchange_addresses', function(Blueprint $table)
		{
			$table->increments('id');
			
            $table->string('exchange_code');
            $table->string('money_code');
            $table->foreign('money_code')->references('code')->on('moneys');
			$table->string('address');
            $table->foreign('exchange_code')->references('code')->on('exchanges');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('exchange_balances', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('trader_id')->unsigned();
			
            $table->string('exchange_code');
            $table->string('money_code');
            $table->foreign('money_code')->references('code')->on('moneys');
			$table->float('balance_amount_avail', 10, 0)->nullable();
			$table->float('balance_amount_held', 10, 0)->nullable();
			$table->float('balance', 10, 0)->nullable();
			$table->float('btc_balance', 10, 0)->nullable();
			$table->float('last_price', 10, 0)->nullable();

            $table->foreign('trader_id')->references('id')->on('traders');
            $table->foreign('exchange_code')->references('code')->on('exchanges');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('exchange_pairs', function(Blueprint $table)
		{
			$table->increments('id');
			
            $table->string('exchange_code');
			$table->integer('market_id')->nullable()->default(0);
			$table->string('exchange_pair', 90)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->index(['exchange_code','market_id','exchange_pair'], 'exchange_code2');

            $table->foreign('exchange_code')->references('code')->on('exchanges');
		});
		Schema::create('ohlcvs', function(Blueprint $table)
		{
			$table->increments('id');
			
            $table->string('exchange_code');
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
			$table->unique(['exchange_code','symbol','timestamp'], 'exchange_code_ohlcvs');

            $table->foreign('exchange_code')->references('code')->on('exchanges');
		});

		Schema::create('tickers', function(Blueprint $table)
		{
			$table->increments('id');
			
            $table->string('exchange_code');
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


            $table->foreign('exchange_code')->references('code')->on('exchanges');
			$table->unique(['exchange_code', 'symbol', 'period' , 'close_time'], 'exchange_code_23');
        });
        
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tickers');
		Schema::drop('ohlcvs');
		Schema::drop('exchange_pairs');
        Schema::drop('exchange_balances');
		Schema::drop('exchange_addresses');
		Schema::drop('exchange_accounts');
		Schema::drop('configs');
	}

}
