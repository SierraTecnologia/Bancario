<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTraderTables extends Migration {

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
		
		Schema::create('trader_positions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->uuid('trader_id')->unsigned();
			
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
