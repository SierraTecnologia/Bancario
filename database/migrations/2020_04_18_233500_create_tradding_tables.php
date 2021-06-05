<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Bancario\Models\Trader\Asset;

class CreateTraddingTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (!\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
            [
                'tradding',
                'trader',
                'crypto',
            ]
        )){
            \Log::debug('Migration Ignorada por causa de Feature');
            return ;
        }

        /**
         * CriptoAtivos
         */
        Schema::create(
            'assets', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->string('code')->unique();
                $table->primary('code');
                $table->string('name', 255)->nullable();
                $table->string('description', 255)->nullable();
                $table->string('symbol', 255)->nullable();
                $table->integer('status')->default(1);
                $table->string('circulating_supply')->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
        Schema::create(
            'assetables', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->string('assetable_id')->nullable();
                $table->string('assetable_type', 255)->nullable();
                $table->string('asset_code');
                $table->foreign('asset_code')->references('code')->on('assets');
                $table->float('value', 8, 2)->default(0);
                $table->timestamps();
                $table->softDeletes();
            }
        );
		$this->assets();

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
            $table->uuid('id')->primary();
			$table->string('name')->nullable();
			$table->string('exchange_code');
			$table->boolean('is_backtest')->default(true);
			$table->timestamp('processing_time');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('trader_histories', function(Blueprint $table)
		{
			$table->increments('id');
			
            $table->enum('type', \Bancario\Models\Trader\TraderHistory::TYPES); //->default(\Bancario\Models\Trader\TraderHistory::MISCELLANEOUS);			

			$table->string('asset_code');

			$table->float('value', 10, 0); // Em valor Absoluto

			$table->uuid('trader_id')->unsigned();
            $table->foreign('trader_id')->references('id')->on('traders');
			
			$table->timestamp('processing_time');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('trader_orders', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->string('asset_seller_code');
			$table->string('asset_buyer_code');

			$table->float('value', 10, 0); // Em valor Absoluto
			$table->float('price', 10, 0); // Em valor Absoluto
			$table->float('taxa', 10, 0); // Em valor Absoluto

			$table->uuid('trader_id')->unsigned();
            $table->foreign('trader_id')->references('id')->on('traders');
			
			$table->timestamp('processing_time');

			$table->json('vars')->nullable();

			$table->timestamps();
			$table->softDeletes();
		});


		/**
		 * @todo Decidir se vai usar
		 */
		Schema::create('trader_timelines', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('type');
			$table->string('message', 65535)->nullable();
			$table->timestampTz('processing_time', $precision = 0)->nullable();
			$table->text('data', 65535)->nullable();

			$table->uuid('trader_id')->unsigned();
            $table->foreign('trader_id')->references('id')->on('traders');
			$table->timestamps();
			$table->softDeletes();
		});
        
		// Schema::create('trade_histories', function(Blueprint $table)
		// {
		// 	$table->increments('id');
		// 	$table->text('about', 65535)->nullable();

		// 	$table->bigInteger('timestamp')->nullable();

		// 	$table->uuid('trader_id')->unsigned();
        //     $table->foreign('trader_id')->references('id')->on('traders');
		// 	$table->timestamps();
		// 	$table->softDeletes();
		// });








		
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trader_histories');
		Schema::drop('trader_timelines');
		Schema::drop('trader_balances');
		Schema::drop('traders');
		Schema::drop('popular_exchanges');
		Schema::drop('exchanges');
		Schema::drop('assetables');
		Schema::drop('assets');
	}

    public function assets()
    {
        // Add Assets
        Asset::firstOrCreate(
            [
                'code' => 'BTC',
                'name' => 'Bitcoin',
                'symbol' => 'BTC',
                'status' => 1
            ]
        );
        Asset::firstOrCreate(
            [
                'code' => 'USDT',
                'name' => 'Dolar Tether',
                'symbol' => 'USDT',
                'status' => 1
            ]
        );
        Asset::firstOrCreate(
            [
                'code' => 'SOL',
                'name' => 'Solana',
                'symbol' => 'SOL',
                'status' => 1
            ]
        );
        Asset::firstOrCreate(
            [
                'code' => 'BNB',
                'name' => 'Binance Coin',
                'symbol' => 'BNB',
                'status' => 1
            ]
        );
        Asset::firstOrCreate(
            [
                'code' => 'UNI',
                'name' => 'Uniswap',
                'symbol' => 'UNI',
                'status' => 1
            ]
        );
        Asset::firstOrCreate(
            [
                'code' => 'LTC',
                'name' => 'Litecoin',
                'symbol' => 'LTC',
                'status' => 1
            ]
        );
        Asset::firstOrCreate(
            [
                'code' => 'XMR',
                'name' => 'Monero',
                'symbol' => 'XMR',
                'status' => 1
            ]
        );
        Asset::firstOrCreate(
            [
                'code' => 'WAVES',
                'name' => 'Waves',
                'symbol' => 'WAVES',
                'status' => 1
            ]
        );
    }
}
