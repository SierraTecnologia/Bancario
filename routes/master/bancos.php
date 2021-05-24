<?php


if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'bancario',
    ]
)){
    Route::resource('/bankAccounts', 'BankAccountController')->parameters([
        'bankAccounts' => 'id'
    ]);
}