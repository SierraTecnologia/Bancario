<?php

Route::resource('/bankAccounts', 'BankAccountController')->parameters([
    'bankAccounts' => 'id'
]);