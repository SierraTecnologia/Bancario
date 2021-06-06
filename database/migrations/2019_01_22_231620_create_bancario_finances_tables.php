<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBancarioFinancesTables extends Migration
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
                'casa',
            ]
        )){
            return ;
        }

        Schema::create(
            'transfers', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('target', 255)->nullable();
                $table->string('money_code')->default('BRL');
                $table->decimal('amount', 8, 2);
                $table->string('date', 30)->nullable();
                $table->string('payment_type_id', 255)->nullable(); // @todo
                $table->string('transferable_id');
                $table->string('transferable_type', 255);
                $table->timestamps();
                $table->softDeletes();
            }
        );
        Schema::create(
            'rendas', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('target', 255)->nullable();
                $table->string('description', 255)->nullable();
                $table->decimal('value');
                $table->string('init', 30)->nullable();
                $table->string('end', 30)->nullable();
                $table->string('date', 30)->nullable();
                $table->string('payment_type_id', 255)->nullable(); // @todo
                $table->string('rendable_id')->nullable();
                $table->string('rendable_type', 255)->nullable();
                $table->string('obs', 255)->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
        Schema::create(
            'gastos', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('target', 255)->nullable();
                $table->string('description', 255)->nullable();

                $table->decimal('value');
                $table->string('init', 30)->nullable();
                $table->string('end', 30)->nullable();
                $table->string('date', 30)->nullable();

                $table->string('payment_type_id', 255)->nullable(); // @todo

                $table->string('gastoable_id')->nullable();
                $table->string('gastoable_type', 255)->nullable();

                $table->string('obs', 255)->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );

        /**
         * Historic
         */

        Schema::create(
            'saldos', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('description', 255)->nullable();
                $table->decimal('value');
                $table->string('date', 30)->nullable();
                $table->string('local_id', 255)->nullable(); // @todo
                $table->string('payment_type_id')->nullable();
                $table->string('saldoable_id')->nullable();
                $table->string('saldoable_type', 255)->nullable();

                $table->string('obs', 255)->nullable();
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
        Schema::dropIfExists('transfers');
        Schema::dropIfExists('rendas');
        Schema::dropIfExists('gastos');
    }

}
