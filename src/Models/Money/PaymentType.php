<?php
/**
 * Armazena os tipos de pagamentos para moedas fiat
 */

namespace Bancario\Models\Money;

use Illuminate\Support\Facades\Hash;
use Muleta\Traits\Models\EloquentGetTableNameTrait;
use Population\Models\Actions\Event\PaymentType as PaymentTypeBase;

class PaymentType extends PaymentTypeBase
{
    use EloquentGetTableNameTrait;

    protected static $organizationPerspective = false;

    /**
     * Obs: Nao veio da Popups, eu que inventei esse
     *
     * @var array
     */
    public static $BOLETO_ID = 1;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public static $CREDIT_CARD_ID = 2;


    /**
     * Dinheiro Vivo
     * Obs: Nao veio da Popups, eu que inventei esse
     *
     * @var array
     */
    public static $ESPECIE_ID = 3;

    /**
     * Transferencias entre contas
     *
     * @var array
     */
    public static $SIMPLE_TRANSFER_ID = 4;

    /**
     * Transferencia entre contas com conversão
     * Ex: Pagando em Bitcoin para o cliente receber em real!
     *
     * @var array
     */
    public static $CONVERSION_TRANSFER_ID = 5;

    protected $fillable = [
        'id',
        'name',
        'status'
    ];
}