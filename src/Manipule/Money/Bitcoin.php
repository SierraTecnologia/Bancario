<?php 

namespace Bancario\Manipule\Money;

use Bancario\Traits\EllipticCurve\Secp256k1;

use BitWasp\BitcoinLib\BitcoinLib;
use BitWasp\BitcoinLib\Electrum;
use Illuminate\Support\Facades\Request;
use Bancario\Manipule\MoneyAbstract;

class Bitcoin extends MoneyAbstract
{
    use Secp256k1;

    protected $magicByte = '00';
    protected $compressPublicKey = false;
}
