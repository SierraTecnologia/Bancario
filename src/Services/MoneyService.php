<?php

namespace Bancario\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Bancario\Repositories\MoneyRepository;
use Bancario\Models\Money;
use Muleta\Utils\Modificators\StringModificator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MoneyService
{
    public function __construct(
        MoneyRepository $moneyRepository
    ) {
        $this->repo = $moneyRepository;
    }

    /**
     * @todo Terminar de Fazer
     */
    public static function import($data)
    {   
        $registerData = $data;
        // if (isset($data['Nome Completo'])) {
        //     $registerData['name'] = $data["Nome Completo"];
        // }
        // if (isset($data['CPF'])) {
        //     $registerData['cpf'] = $data["CPF"];
        // }
        // if (isset($data['Nascimento'])) {
        //     $registerData['birthday'] = $data["Nascimento"];
        // }
        $code = $registerData['code'] = StringModificator::cleanCodeSlug($registerData['name']);

        if (Money::find($code)) {
            return true;
        }
        $money = Money::createIfNotExistAndReturn($registerData);
        return true;
    }
}
