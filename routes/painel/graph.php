<?php 


if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'tradding',
        'trader',
        'crypto',
    ]
)){


    Route::get('graphs', 'GraphController@index')->name('graphs.index');

}