<?php
/**
 * https://gourl.io/bitcoin-payment-gateway-api.html
 * https://gourl.io/lib/examples/pay-per-download-multi.php?gourlcryptocoin=bitcoin#a
 * https://coins.gourl.io/lib/cryptoapi_php.rar
 */

namespace Bancario\Modules\Logic\Moneys;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use Bancario\Modules\Logic\Moneys;

// require_once( "cryptobox.class.php" );


class Real extends Moneys
{
    static function accountNumberToDatabase($array)
    {
        return parent::accountNumberToDatabase($array['agencia'].'|'.$array['conta']);
    }

    /**
     * Recupera a string do banco de dados e extra em um array para ser usado
     * nas operações de transferências!
     */
    static function accountNumberToOperation(string $string)
    {
        $string = explode('|', $string);
        return parent::accountNumberToOperation(
            [
            'agencia' => $string[0],
            'conta' => $string[1],
            ]
        );
    }
}
