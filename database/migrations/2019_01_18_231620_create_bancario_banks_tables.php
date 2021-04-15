<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBancarioBanksTables extends Migration
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
                'banks',
            ]
        )){
            return ;
        }

        /**
         * Financeiro
         */
        Schema::create(
            'banks', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('name', 255);
                $table->string('descriptions', 255)->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
        
        Schema::create(
            'bankables', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('bankable_id');
                $table->string('bankable_type', 255);

                $table->unsignedInteger('bank_id')->nullable();
                $table->foreign('bank_id')->references('id')->on('banks');
                $table->timestamps();
                $table->softDeletes();
            }
        );

        Schema::create(
            'bank_accounts', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('name', 255)->nullable();
                $table->string('agencia', 255)->nullable();
                $table->string('conta', 255)->nullable();
                $table->string('proprietário', 255)->nullable();
                $table->string('type', 255)->default('pf');
                $table->string('accountable_id')->nullable();
                $table->string('accountable_type', 255)->nullable();

                $table->unsignedInteger('bank_id')->nullable();
                $table->foreign('bank_id')->references('id')->on('banks');
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
        Schema::dropIfExists('bankables');
        Schema::dropIfExists('banks');
    }

}
