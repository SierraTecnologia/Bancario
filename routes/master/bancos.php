<?php

Route::resource('/banks', 'BankController')->parameters([
    'banks' => 'id'
]);