<?php

Route::resource('/candles', 'CandleController')->parameters([
    'candles' => 'id'
]);

Route::resource('/completedTraders', 'CompletedTradeController')->parameters([
    'completedTraders' => 'id'
]);

Route::resource('/dailyBalances', 'DailyBalanceController')->parameters([
    'dailyBalances' => 'id'
]);

Route::resource('/orderBooks', 'OrderBookController')->parameters([
    'orderBooks' => 'id'
]);

Route::resource('/orders', 'OrderController')->parameters([
    'orders' => 'id'
]);

Route::resource('/tickers', 'TickerController')->parameters([
    'tickers' => 'id'
]);

Route::resource('/trades', 'TradeController')->parameters([
    'trades' => 'id'
]);