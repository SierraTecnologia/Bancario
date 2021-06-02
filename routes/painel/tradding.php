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

    Route::resource('/traders', 'TraderController')->parameters([
        'traders' => 'id'
    ]);





//     }
// );
}