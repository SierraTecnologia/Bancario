<?php

Route::resource('/moneys', 'MoneyController')->parameters([
    'moneys' => 'id'
]);