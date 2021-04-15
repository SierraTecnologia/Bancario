<?php

if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'tradding',
        'trader',
        'crypto',
    ]
)){

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    // Route::group(
    //     [
    //         // 'middleware' => 'master', //@todo
    //         'prefix' => 'master',
    //         'as' => 'master.',
    //         'namespace' => 'Master'
    //     ], function () {

            Route::resource('/histories', 'TraddingHistoryController')->parameters([
                'histories' => 'id'
            ]);










            Route::resource('/exchanges', 'ExchangeController')->parameters([
                'exchanges' => 'id'
            ]);
            Route::resource('/exchangeAccounts', 'ExchangeAccountController')->parameters([
                'exchangeAccounts' => 'id'
            ]);
            Route::resource('/exchangeBalances', 'ExchangeBalanceController')->parameters([
                'exchangeBalances' => 'id'
            ]);
            Route::resource('/exchangeAddresses', 'ExchangeAddressController')->parameters([
                'exchangeAddresses' => 'id'
            ]);
            Route::resource('/exchangePairs', 'ExchangePairController')->parameters([
                'exchangePairs' => 'id'
            ]);



            Route::resource('/configs', 'ConfigController')->parameters([
                'configs' => 'id'
            ]);


            Route::resource('/ohlcvs', 'OhlcvController')->parameters([
                'ohlcvs' => 'id'
            ]);

            Route::resource('/tickers', 'TickerController')->parameters([
                'tickers' => 'id'
            ]);
            Route::get('charts', 'TickerController@chatdisplay')->name('tickers.charts');
            
            Route::resource('/popularExchanges', 'PopularExchangeController')->parameters([
                'popularExchanges' => 'id'
            ]);
    //     }
    // );
}