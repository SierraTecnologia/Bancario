<?php
/**
 * Determinisc Function
 * Algoritmo Sha256 secp256k1 para o bitcoin
 *
 * https://medium.com/coinmonks/how-to-generate-a-bitcoin-address-step-by-step-9d7fcbf1ad0b
 */

namespace Bancario\Traits\EllipticCurve;

use BitWasp\BitcoinLib\BitcoinLib;

use BitWasp\BitcoinLib\Electrum;
use Illuminate\Support\Facades\Request;

trait Secp256k1
{
    public function keygen()
    {
        $keypair = BitcoinLib::get_new_key_set($this->magicByte);
        echo "Key pair: \n";
        print_r($keypair);
        echo "\n";

        $this->compressPublicKey = BitcoinLib::compress_public_key($keypair['pubKey']);
        echo "Compressed public key: $this->compressPublicKey \n";
        $decompress = BitcoinLib::decompress_public_key($this->compressPublicKey);
        echo "Decompressed key info: \n";
        print_r($decompress);
    }

    /**
     * Gera um Endereço em cima de uma Chave Publica
     *
     * @return void
     */
    public function generateAddress($compressPublicKey)
    {
        echo "\n";
        $address = BitcoinLib::public_key_to_address($compressPublicKey, $this->magicByte);

        echo "decoding $address\n";
        echo BitcoinLib::base58_decode($address);
        echo "\n\n";

        $sc = '5357';
        $ad = BitcoinLib::public_key_to_address($sc, '05');
        echo $ad."\n";
    }
}
