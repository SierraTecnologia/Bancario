<?php


if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'tradding',
        'trader',
        'crypto',
        'bancario',
    ]
)){
    Route::resource('/moneys', 'MoneyController')->parameters([
        'moneys' => 'id'
    ]);
}