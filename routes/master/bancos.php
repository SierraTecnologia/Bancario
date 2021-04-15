<?php


if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'banks',
    ]
)){
    Route::resource('/bankAccounts', 'BankAccountController')->parameters([
        'bankAccounts' => 'id'
    ]);
}