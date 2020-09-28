<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCasaWalletsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'wallets',
            function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('target', 255)->nullable();
                $table->string('money_code')->default('BRL');
                $table->decimal('amount', 8, 2);
                $table->string('actorable_id')->nullable();
                $table->string('actorable_type', 255)->nullable();
                $table->string('accountable_id');
                $table->string('accountable_type', 255);
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
