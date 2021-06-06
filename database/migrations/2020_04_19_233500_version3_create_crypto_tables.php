<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Version3CreateCryptoTables extends Migration
{
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
         * Banks and Cryptos
         */
        Schema::create('wallets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pubkey');
            $table->string('privatekey');
            $table->string('algoritm');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('money_code');
            $table->foreign('money_code')->references('code')->on('moneys');
            $table->timestamps();
        });
        Schema::create('wallet_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->integer('wallet_id')->unsigned();
            $table->foreign('wallet_id')->references('id')->on('wallets');
            $table->timestamps();
        });
        Schema::create('wallet_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->float('value'); // Total com as Taxas
            $table->float('taxes');
            $table->integer('transferable_id')->nullable();                                                                                                 
            $table->string('transferable_type', 255)->nullable();
            $table->integer('wallet_id')->unsigned();
            $table->foreign('wallet_id')->references('id')->on('wallets');
            $table->timestamps();
        });

        /**
         * Convert Moneys
         */
        // @todo Ja existia, mudar para outra
        // Schema::create('payment_types', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('name');
        //     $table->timestamps();
        // });
        Schema::create('payment_crypto_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('money_conversion_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });


        /**
         * Traddings
         */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
