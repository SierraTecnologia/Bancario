<?php


if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'bancario',
    ]
)){
    Route::resource('/banks', 'BankController')->parameters([
        'banks' => 'id'
    ]);
}