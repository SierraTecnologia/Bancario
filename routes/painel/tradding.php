<?php

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


    Route::get('traders', 'TraderController@index')->name('traders.index');





//     }
// );