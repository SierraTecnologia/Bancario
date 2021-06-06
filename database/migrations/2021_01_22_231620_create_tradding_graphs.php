<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraddingGraphs extends Migration
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

        Schema::create(
            'graphs', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('graph_id')->nullable();
                $table->string('graph_type', 255)->nullable();
                $table->string('abrangencia_id')->nullable();
                $table->string('abrangencia_type', 255)->nullable();
                $table->bigInteger('timestamp')->nullable();
                
			    $table->unique(['graph_id','graph_type','abrangencia_id','abrangencia_type'], 'graphs_graph_abrangencia_unique');
            }
        );
        Schema::create(
            'graphables', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->bigInteger('timestamp')->nullable();
			    $table->float('value', 10, 0)->nullable();

                $table->string('graphable_id')->nullable();
                $table->string('graphable_type', 255)->nullable();

                $table->unsignedInteger('graph_id');
                $table->foreign('graph_id')->references('id')->on('graphs');

                
			    $table->unique(['graph_id','graphable_id','graphable_type','timestamp'], 'graphables_graph_abrangencia_unique');

            }
        );

        // /**
        //  * Historic
        //  */

        // Schema::create(
        //     'saldos', function (Blueprint $table) {
        //         $table->engine = 'InnoDB';
        //         $table->increments('id')->unsigned();
        //         $table->string('description', 255)->nullable();
        //         $table->decimal('value');
        //         $table->string('date', 30)->nullable();
        //         $table->string('local_id', 255)->nullable(); // @todo
        //         $table->string('payment_type_id')->nullable();
        //         $table->string('saldoable_id')->nullable();
        //         $table->string('saldoable_type', 255)->nullable();

        //         $table->string('obs', 255)->nullable();
        //         $table->timestamps();
        //         $table->softDeletes();
        //     }
        // );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('graphables');
        Schema::dropIfExists('graphs');
    }

}
