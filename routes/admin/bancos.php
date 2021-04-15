<?php


if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'banks',
    ]
)){
    Route::resource('/banks', 'BankController')->parameters([
        'banks' => 'id'
    ]);
}