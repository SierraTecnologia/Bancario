<?php

namespace Bancario;

use App;
use Bancario\Facades\Bancario as BancarioFacade;
use Bancario\Services\BancarioService;
use Config;
use Illuminate\Contracts\Events\Dispatcher;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use Log;

use Muleta\Traits\Providers\ConsoleTools;
use Route;

class BancarioProvider extends ServiceProvider
{
    use ConsoleTools;
    const pathVendor = 'sierratecnologia/bancario';

    /**
     * @var Facades\Bancario::class[]
     *
     * @psalm-var array{Bancario: Facades\Bancario::class}
     */
    public static array $aliasProviders = [
        'Bancario' => \Bancario\Facades\Bancario::class,
    ];

    /**
     * @var \Support\SupportProviderService::class[]
     *
     * @psalm-var array{0: \Support\SupportProviderService::class}
     */
    public static array $providers = [

        \Support\SupportProviderService::class,

        
    ];

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
     * @return string[]
     *
     * @psalm-return array{0: string}
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

    private function loadViews(): void
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
    
    private function loadTranslations(): void
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
     * @return void
     */
    private function loadLogger(): void
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
