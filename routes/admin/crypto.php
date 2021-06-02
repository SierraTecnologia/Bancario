<?php


if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'tradding',
        'trader',
        'crypto',
    ]
)){
    Route::resource('/assets', 'AssetController')->parameters([
        'assets' => 'id'
    ]);
}