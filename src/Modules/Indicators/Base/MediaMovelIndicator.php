<?php
/**
 * Média móvel simples
 * https://pt.wikipedia.org/wiki/M%C3%A9dia_m%C3%B3vel
 */

namespace Bancario\Modules\Indicators\Base;

use Bancario\Modules\Indicators\Contracts\IndicatorAbstract;

class MediaMovelIndicator extends IndicatorAbstract
{
    protected $code = 'MV';

    // /**
    //  * Parametros Obrigatórios
    //  */
    // protected $requeriments = [
    //     'pair_code',
    //     'exchange_code',
    //     'period' // Padrao de 1 Minuto,
    // ];

    // /**
    //  * Parametros Obrigatórios
    //  */
    // protected $params = [
    //     'only_last_days',
    // ];

    protected $dataOcorrences = 0;
    protected $dataValue = 0;

    /**
     * Recebe via pluck cada resultado
     */
    public function runForEach($value)
    {
        $this->dataValue = $this->dataValue+$value;
        $this->dataOcorrences += 1;
        return $this->calcule();
    }

    public function calcule()
    {
        return $this->dataValue/$this->dataOcorrences;
    }

}
