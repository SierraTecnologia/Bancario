<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bancario\Models\Money\Money;

class CreateMoneysTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        
        /**
         * Moneys
         */
        Schema::create(
            'moneys', function (Blueprint $table) {
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
            'moneyables', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->string('valor', 255)->nullable();
                $table->string('moneyable_id')->nullable();
                $table->string('moneyable_type', 255)->nullable();
                $table->string('money_code');
                $table->foreign('money_code')->references('code')->on('moneys');
                $table->timestamps();
                $table->softDeletes();
            }
        );
        $this->moneys();
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moneyables');
        Schema::dropIfExists('moneys');
    }


    public function moneys()
    {
        // Add Moneys
        Money::firstOrCreate(
            [
                'code' => 'BRL',
                'name' => 'Real',
                'symbol' => 'R$',
                'status' => 1
            ]
        );
        Money::firstOrCreate(
            [
                'code' => 'USD',
                'name' => 'Dolar',
                'symbol' => '$',
                'status' => 1
            ]
        );
        Money::firstOrCreate(
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '&',
                'status' => 1
            ]
        );
        Money::firstOrCreate(
            [
                'code' => 'BTC',
                'name' => 'Bitcoin',
                'symbol' => 'BTC',
                'status' => 1
            ]
        );
        Money::firstOrCreate(
            [
                'code' => 'USDT',
                'name' => 'Dolar Tether',
                'symbol' => 'USDT',
                'status' => 1
            ]
        );
    }

}
