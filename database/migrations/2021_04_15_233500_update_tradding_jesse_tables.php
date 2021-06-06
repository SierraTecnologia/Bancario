<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTraddingJesseTables extends Migration {

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

        Schema::table('candle', function (Blueprint $table) {
			$table->timestampTz('open_at', $precision = 0)->nullable();
        });

        Schema::table('ticker', function (Blueprint $table) {
			$table->timestampTz('open_at', $precision = 0)->nullable();
        });
        
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

}
