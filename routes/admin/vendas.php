<?php

if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
        [
        'casa',
        ]
)){
        Route::resource('propostas', 'PropostaController');
}