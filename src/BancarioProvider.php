<?php

namespace Bancario;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Bancario\Services\BancarioService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

use Log;
use App;
use Config;
use Route;
use Illuminate\Routing\Router;

use Muleta\Traits\Providers\ConsoleTools;

use Bancario\Facades\Bancario as BancarioFacade;
use Illuminate\Contracts\Events\Dispatcher;


class BancarioProvider extends ServiceProvider
{
    use ConsoleTools;

    public $packageName = 'bancario';
    const pathVendor = 'sierratecnologia/bancario';

    public static $aliasProviders = [
        'Bancario' => \Bancario\Facades\Bancario::class,
    ];

    public static $providers = [

        \Support\SupportProviderService::class,

        
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [
        [
            'text' => 'Bancario',
            'icon' => 'fas fa-fw fa-search',
            'icon_color' => "blue",
            'label_color' => "success",
            'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        ],
        'Bancario' => [
            [
                'text'        => 'Procurar',
                'icon'        => 'fas fa-fw fa-search',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \App\Models\Role::$ADMIN
            ],
            'Procurar' => [
                [
                    'text'        => 'Projetos',
                    'route'       => 'rica.bancario.projetos.index',
                    'icon'        => 'fas fa-fw fa-ship',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                    // 'access' => \App\Models\Role::$ADMIN
                ],
            ],
        ],
    ];

    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        
        // Register configs, migrations, etc
        $this->registerDirectories();

        // COloquei no register pq nao tava reconhecendo as rotas para o adminlte
        $this->app->booted(function () {
            $this->routes();
        });

        $this->loadLogger();
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }


        /**
         * Bancario; Routes
         */
        $this->loadRoutesForRiCa(__DIR__.'/../routes');
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getPublishesPath('config/sitec/bancario.php'), 'sitec.bancario');
        

        $this->setProviders();
        // $this->routes();



        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->app->singleton(
            'bancario', function () {
                return new Bancario();
            }
        );
        
        /*
        |--------------------------------------------------------------------------
        | Register the Utilities
        |--------------------------------------------------------------------------
        */
        /**
         * Singleton Bancario;
         */
        $this->app->singleton(
            BancarioService::class, function ($app) {
                Log::channel('sitec-bancario')->info('Singleton Bancario;');
                return new BancarioService(\Illuminate\Support\Facades\Config::get('sitec.bancario'));
            }
        );

        // Register commands
        $this->registerCommandFolders(
            [
            base_path('vendor/sierratecnologia/bancario/src/Console/Commands') => '\Bancario\Console\Commands',
            ]
        );

        // /**
        //  * Helpers
        //  */
        // Aqui noa funciona
        // if (!function_exists('bancario_asset')) {
        //     function bancario_asset($path, $secure = null)
        //     {
        //         return route('rica.bancario.assets').'?path='.urlencode($path);
        //     }
        // }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'bancario',
        ];
    }

    /**
     * Register configs, migrations, etc
     *
     * @return void
     */
    public function registerDirectories()
    {
        // Publish config files
        $this->publishes(
            [
            // Paths
            $this->getPublishesPath('config/sitec') => config_path('sitec'),
            ], ['config',  'sitec', 'sitec-config']
        );

        // // Publish bancario css and js to public directory
        // $this->publishes([
        //     $this->getDistPath('bancario') => public_path('assets/bancario')
        // ], ['public',  'sitec', 'sitec-public']);

        $this->loadViews();
        $this->loadTranslations();

    }

    private function loadViews()
    {
        // View namespace
        $viewsPath = $this->getResourcesPath('views');
        $this->loadViewsFrom($viewsPath, 'bancario');
        $this->publishes(
            [
            $viewsPath => base_path('resources/views/vendor/bancario'),
            ], ['views',  'sitec', 'sitec-views']
        );

    }
    
    private function loadTranslations()
    {
        // Publish lanaguage files
        $this->publishes(
            [
            $this->getResourcesPath('lang') => resource_path('lang/vendor/bancario')
            ], ['lang',  'sitec', 'sitec-lang', 'translations']
        );

        // Load translations
        $this->loadTranslationsFrom($this->getResourcesPath('lang'), 'bancario');
    }


    /**
     * 
     */
    private function loadLogger()
    {
        Config::set(
            'logging.channels.sitec-bancario', [
            'driver' => 'single',
            'path' => storage_path('logs/sitec-bancario.log'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
            ]
        );
    }

}
