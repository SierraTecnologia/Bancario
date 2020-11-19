<?php

use App\Models\Identitys\Collaborator;

use Porteiro\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Google Suite
         */
        $serviceGoogleSuite = Service::firstOrCreate(
            [
                'name' => 'Google Suite'
            ]
        );
        $serviceGoogleSuiteBasic = ServicePlan::firstOrCreate(
            [
                'money' => 'USD',
                'value' => '5',
                'multiplicador' => User::class, // Por Usuário
                'service_id' -> $serviceGoogleSuite->id,
            ]
        );
        // Diferencial do Plano
        ServicePlanResource::firstOrCreate(
            [
                'type' => 'storage',
                'value' => '30G',
                'service_plan_id' => $serviceGoogleSuiteStandart->id
            ]
        );
        $serviceGoogleSuiteStandart = ServicePlan::firstOrCreate(
            [
                'money' => 'USD',
                'value' => '12',
                'multiplicador' => User::class, // Por Usuário
                'service_id' -> $serviceGoogleSuite->id,
            ]
        );
        // Diferencial do Plano
        ServicePlanResource::firstOrCreate(
            [
                'type' => 'storage',
                'value' => '2T',
                'service_plan_id' => $serviceGoogleSuiteStandart->id
            ]
        );




        /**
         * Zoom
         */
        $service = Service::firstOrCreate(
            [
                'name' => 'Zoom'
            ]
        );





        /**
         * Jira
         */
        $service = Service::firstOrCreate(
            [
                'name' => 'Jira'
            ]
        );


        /**
         * Confluence
         */
        $service = Service::firstOrCreate(
            [
                'name' => 'Confluence'
            ]
        );




        /**
         * Wakatime
         */
        $service = Service::firstOrCreate(
            [
                'name' => 'Wakatime'
            ]
        );





        /**
         * Postman
         */
        $service = Service::firstOrCreate(
            [
                'name' => 'Postman'
            ]
        );








        /**
         * Slack
         */
        $service = Service::firstOrCreate(
            [
                'name' => 'Slack'
            ]
        );












        $fakerBr = \Faker\Factory::create('pt_BR');
        // User::truncate();
        // Role::truncate();

        $root = Role::firstOrCreate(['name' => 'root']);
        // $root = Role::create(['name' => 'root']);
        // $root->givePermissionTo(Permission::all()); // @todo, deu erro aqui

        $admin = Role::firstOrCreate(['name' => 'admin']);
        // $admin = Role::create(['name' => 'admin']);
        // $admin->givePermissionTo(Permission::all()); // @todo, deu erro aqui

        $gerente = Role::firstOrCreate(['name' => 'gerente']);
        // $gerente = Role::create(['name' => 'gerente']);
        // $gerente->givePermissionTo('gerente power'); // @todo, deu erro aqui

        // or may be done by chaining
        $supervisor = Role::firstOrCreate(['name' => 'supervisor']);
        // $supervisor = Role::create(['name' => 'supervisor']);
        // $supervisor->givePermissionTo(['conversation', 'view girl']); // @todo, deu erro aqui

        // or may be done by chaining
        $corretor = Role::firstOrCreate(['name' => 'corretor']);
        // $corretor = Role::create(['name' => 'corretor']);
        // $corretor->givePermissionTo(['conversation', 'view girl']); // @todo, deu erro aqui

        User::firstOrCreate(
            [
            'name'              => 'Ricardo Sierra',
            'cpf'               => '13278201701',
            'email'             => 'ricardo@ricasolucoes.com.br',
            'password'          => 'q1w2e3r4', //bcrypt('q1w2e3r4'),
            'admin'          => 1,
            'role_id'           => Role::$GOOD
            ]
        );
        User::firstOrCreate(
            [
            'name'              => 'Aline do Vale',
            'cpf'               => preg_replace('/[^0-9]/', '', $fakerBr->cpf),
            'email'             => 'aline@ricasolucoes.com.br',
            'password'          => 'q1w2e3r4', //bcrypt('q1w2e3r4'),
            'admin'          => 1,
            'role_id'           => Role::$GOOD
            ]
        );
        User::firstOrCreate(
            [
            'name'              => 'Aline do Vale',
            'cpf'               => preg_replace('/[^0-9]/', '', $fakerBr->cpf),
            'email'             => 'aline@ricasolucoes.com.br',
            'password'          => 'q1w2e3r4', //bcrypt('q1w2e3r4'),
            'admin'          => 1,
            'role_id'           => Role::$GOOD
            ]
        );
        User::firstOrCreate(
            [
            'name'              => 'Teixeira',
            'cpf'               => preg_replace('/[^0-9]/', '', $fakerBr->cpf),
            'email'             => 'teixeira@ricasolucoes.com.br',
            'password'          => 'q1w2e3r4', //bcrypt('q1w2e3r4'),
            'admin'          => 1,
            'role_id'           => Role::$GOOD
            ]
        );
        // Claudinei
        $user = User::firstOrCreate(
            [
            'name'              => 'Claudinei',
            'cpf'               => preg_replace('/[^0-9]/', '', $fakerBr->cpf),
            'email'             => 'claudinei@novacaoseguros.com.br',
            'password'          => 'q1w2e3r4', //bcrypt('q1w2e3r4'),
            'admin'          => 1,
            'role_id'           => Role::$ADMIN
            ]
        );
        // factory(Collaborator::class)->states('admin')->make([
        //     'user_id' => $user->id
        // ]);

        // Gabriel
        $user = User::firstOrCreate(
            [
            'name'              => 'Gabriel',
            'cpf'               => '16617313763',
            'email'             => 'gabriel@novacaoseguros.com.br',
            'password'          => 'q1w2e3r4', //bcrypt('q1w2e3r4'),
            'admin'          => 1,
            'role_id'           => Role::$ADMIN
            ]
        );
        // factory(Collaborator::class)->states('admin')->make([
        //     'user_id' => $user->id
        // ]);

        // Bryan
        $user = User::firstOrCreate(
            [
            'name'              => 'Bryan',
            'cpf'               => preg_replace('/[^0-9]/', '', $fakerBr->cpf),
            'email'             => 'bryan@novacaoseguros.com.br',
            'password'          => 'q1w2e3r4', //bcrypt('q1w2e3r4'),
            'admin'          => 1,
            'role_id'           => Role::$ADMIN
            ]
        );
    }
}
