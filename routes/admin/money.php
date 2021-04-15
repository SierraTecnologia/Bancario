<?php


if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'tradding',
        'trader',
        'crypto',
        'banks',
        'bancario',
    ]
)){
    Route::resource('/moneys', 'MoneyController')->parameters([
        'moneys' => 'id'
    ]);
}