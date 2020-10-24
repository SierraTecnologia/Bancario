<?php

use App\Models\Identitys\Collaborator;
use App\Models\User;
use App\Models\Plano;
use Carbon\Carbon;
use App\Models\Banks\Customer;
use App\Models\Banks\Administradora;
use App\Models\Banks\Operadora;
use Fabrica\Models\Code\Stage;

$factory->define(
    App\Models\Proposta::class, function () {
        
        // $collaboratorContact = factory(\App\Models\Identitys\CollaboratorContact::class)->create();

        $rand = rand(1, 100);
        $customer = false;
        if ($rand>95) {
            $customer = Customer::first();
        }
        if (!$customer) {
            $customer = factory('App\Models\Banks\Customer')->create();
        }
        $rand = rand(1, 100);
        $plano = false;
        if ($rand>95) {
            $plano = Plano::first();
        }
        if (!$plano) {
            $plano = factory('App\Models\Plano')->create();
        }
        $administradora = Administradora::first();
        $stage = Stage::first();

        return [
            'customer_id' => $customer->id,
            'user_id' => $user->id,
            'plano_id' => $plano->id,
            'stage_id' => $stage->id,
            'administradora_id' => $administradora->id,
            'valor' => rand(10, 10000), // Se o cliente salvou ou nao o cartão para usar dps!
        ];
    }
);
