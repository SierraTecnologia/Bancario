<?php

use Illuminate\Database\Seeder;

use App\Models\Video;
use App\Models\Playlist;

class PlanosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            
        $qnt = rand(3, 8);
        factory(Playlist::class, $qnt)->create();
        $operadoras = Operadora::all();
        $planoTypes = PlanoType::all();
        foreach ($operadoras as $operadora) {
            foreach ($planoTypes as $planoType) {
                $plano = new Plano();
                $plano->plano_type_id = $planoType->id;
                $plano->operadora_id = $operadora->id;
                $plano->valor = rand(10, 1000);
                $plano->save();
            }
        }
    }
}