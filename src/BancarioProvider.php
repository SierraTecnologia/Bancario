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

    public $packageName = 'bancario';
    const pathVendor = 'sierratecnologia/bancario';

    public static $aliasProviders = [
        'Bancario' => \Bancario\Facades\Bancario::class,
    ];

    public static $providers = [

        \Telefonica\TelefonicaProvider::class,
        \Bancario\Providers\BancarioEventProvider::class,

        
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
            'order' => 1550,
            'section' => "master",
            'feature' => 'bancos',
            'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
            'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        ],
        [
            'text' => 'Jesse',
            'icon' => 'fas fa-fw fa-search',
            'icon_color' => "blue",
            'label_color' => "success",
            'order' => 1450,
            'section' => "master",
            'feature' => 'tradding',
            'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
            'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        ],
        [
            'text' => 'Tradding',
            'icon' => 'fas fa-fw fa-search',
            'icon_color' => "blue",
            'label_color' => "success",
            'order' => 650,
            'section' => "painel",
            'feature' => 'tradding',
            'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
            'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        ],
        'Universo' => [
            [
                'text' => 'Bancario',
                'icon' => 'fas fa-fw fa-search',
                'icon_color' => "blue",
                'label_color' => "success",
                'order' => 1550,
                'section' => "admin",
                'feature' => 'bancos',
                'order' => 2840,
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            'Bancario' => [
                [
                    'text'        => 'Bancos',
                    'route'       => 'admin.bancario.banks.index',
                    'icon'        => 'fas fa-fw fa-ship',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    'section' => "admin",
                    'feature' => 'bancos',
                    'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                    'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                    // 'access' => \Porteiro\Models\Role::$ADMIN
                ],
                [
                    'text'        => 'Moedas',
                    'route'       => 'admin.bancario.moneys.index',
                    'icon'        => 'fas fa-fw fa-coins',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    'section' => "admin",
                    'feature' => 'bancos',
                    'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                    'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                    // 'access' => \Porteiro\Models\Role::$ADMIN
                ],
            ],
        ],
        'Bancario' => [
            [
                'text'        => 'Contas Bancarias',
                'route'       => 'master.bancario.bankAccounts.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "master",
                'feature' => 'bancos',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'Propostas',
                'route'       => 'admin.bancario.propostas.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "master",
                'feature' => 'bancos',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
        ],
        'Jesse' => [
            [
                'text'        => 'candles',
                'route'       => 'master.bancario.candles.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "master",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'completedTraders',
                'route'       => 'master.bancario.completedTraders.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "master",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'dailyBalances',
                'route'       => 'master.bancario.dailyBalances.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "master",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'orderBooks',
                'route'       => 'master.bancario.orderBooks.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "master",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'orders',
                'route'       => 'master.bancario.orders.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "master",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'tickers',
                'route'       => 'master.bancario.tickers.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "master",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'trades',
                'route'       => 'master.bancario.trades.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "master",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
        ],
        'Tradding' => [
            [
                'text'        => 'Configs',
                'route'       => 'painel.bancario.configs.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "painel",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            [
                'text'        => 'Hist. de Preço',
                'route'       => 'painel.bancario.histories.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "painel",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            [
                'text'        => 'Tickers',
                'route'       => 'painel.bancario.tickers.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "painel",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            [
                'text'        => 'Ohlcvs',
                'route'       => 'painel.bancario.ohlcvs.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "painel",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            [
                'text'        => 'exchange Accounts',
                'route'       => 'painel.bancario.exchangeAccounts.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "painel",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            [
                'text'        => 'exchange Balances',
                'route'       => 'painel.bancario.exchangeBalances.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "painel",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            [
                'text'        => 'exchange Addresses',
                'route'       => 'painel.bancario.exchangeAddresses.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "painel",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            [
                'text'        => 'Exchanges',
                'route'       => 'painel.bancario.exchanges.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "painel",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            [
                'text'        => 'PopularExchanges',
                'route'       => 'painel.bancario.popularExchanges.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "painel",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            [
                'text'        => 'exchange Pares',
                'route'       => 'painel.bancario.exchangePairs.index',
                'icon'        => 'fas fa-fw fa-ship',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "painel",
                'feature' => 'bancario',
                'dev_status'  => 2, // 0 (Desabilitado), 1 (Ativo), 2 (Em Dev)
                'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
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
        $this->app->booted(
            function () {
                $this->routes();
            }
        );

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
        $this->loadRoutesForRiCa(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'routes');
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'sitec'.DIRECTORY_SEPARATOR.'bancario.php'), 'sitec.bancario');
        

        $this->setProviders();
        // $this->routes();



        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations');

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
            $this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'sitec') => config_path('sitec'),
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
            $viewsPath => base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'bancario'),
            ], ['views',  'sitec', 'sitec-views']
        );
    }
    
    private function loadTranslations()
    {
        // Publish lanaguage files
        $this->publishes(
            [
            $this->getResourcesPath('lang') => resource_path('lang'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'bancario')
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
            'path' => storage_path('logs'.DIRECTORY_SEPARATOR.'sitec-bancario.log'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
            ]
        );
    }
}
