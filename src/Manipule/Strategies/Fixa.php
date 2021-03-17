<?php
// https://github.com/Bit-Wasp/bitcoin-lib-php/tree/master/examples

namespace Bancario\Manipule\Strategies;

use Illuminate\Support\Facades\Request;

use BitWasp\BitcoinLib\BitcoinLib;
use BitWasp\BitcoinLib\Electrum;

class Fixa
{

    protected $criptoMoney = false;
    protected $publicKeys = false;
    protected $minToMove = false;

    public function __construct(Money $criptoMoney, Array $publicKeys, $minToMove = 2)
    {
        $this->criptoMoney = $criptoMoney;
        $this->publicKeys = $publicKeys;
        $this->minToMove = $minToMove;
    }

    public function generateAddress()
    {
        // It's recommended that you sort the public keys before creating multisig
        // Someday this might be standardized in BIP67; https://github.com/bitcoin/bips/pull/146
        // Many other libraries already do this too!
        RawTransaction::sort_multisig_keys($this->publicKeys);
        // Create redeem script
        $redeemScript = RawTransaction::create_multisig($this->minToMove, $this->publicKeys);
        // Display data
        echo "Public Keys: \n";
        foreach ($this->publicKeys as $i => $publicKey) {
            echo "{$i} : {$publicKey} \n";
        }
        echo "\n";
        echo "Redeem Script: \n";
        echo "{$redeemScript['redeem_script']} \n\n";
        echo "Address: \n";
        echo "{$redeemScript['address']} \n\n";
    }
}
