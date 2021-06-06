<?php

namespace Bancario\Traits\BotTrader;

/**
 *
 */
trait PrintTrait
{
    /**
     * Tabela de Impressao
     */
    protected $tempHeaders = [
        'N da Operacao',
        'Variou no saldo em BTC',
        'Variou no saldo em USDT',
        // 'Porc',
        'Porc Compra',
        'Porc Venda',
        // 'MediaMovel',
        'Preço Now',
        'Preco Now Prox',
        'Total em USDT',
        'Var. Total em USDT',
        // 'Taxa Total BTC',
        // 'Taxa Total USDT',
    ];
    public function addTabelaOperacoes($operacaoTexto)
    {
        $this->tableOperacoes[] = [
                $operacaoTexto,
                $this->printBTC($this->saldoBTC-$this->saldoBTCInicial),
                $this->printUSDT($this->saldoUSDT-$this->saldoUSDTInicial),

                /**
                 * Porcs
                 */
                // $this->printPorc($this->porc),
                $this->printUSDT($this->getPorcToBuy()),
                $this->printUSDT($this->getPorcToSell()),


                // $this->printUSDT($this->mv),
                $this->printUSDT($this->getPrecoNow()),
                false, //
                $this->printUSDT($this->getTotalEmDolarHoje()),
                $this->printUSDT($this->getTotalEmDolarHoje()-$this->getTotalEmDolarInicialHoje()),
                // $this->gastoTaxaBTC,
                // $this->gastoTaxaUSDT,
        ];
    }

    protected $tempQntOperacaoVenda;
    protected $tempPrecoUltimaOperacao;
    protected $tempQntOperacaoCompra = 0;

    public function printUSDT($number)
    {
        return '$ '.number_format($number, 2, ',', '.');
    }
    public function printBTC($number)
    {
        return number_format($number, 8, ',', ''). 'BTC';
    }
    public function printPorc($number)
    {
        return number_format($number, 5, '.', '').'%';
    }

    public function imprimirTabela($tempPrecoUltimaOperacao)
    {
        $this->line("=====================================");
        $this->line("\n\n\n\n\n\n\n\n\n\n");
        $this->line("\n\n\n\n\n\n\n\n\n\n");
        $this->line("\n\n\n\n\n\n\n\n\n\n");
        $this->line("\n\n\n\n\n\n\n\n\n\n");
        $this->line("\n\n\n\n\n\n\n\n\n\n");
        $this->line("\n\n\n\n\n\n\n\n\n\n");
        $this->printCaixa();
        $this->line(
            "MV ".$this->printUSDT($this->mv)."    ".
            "Ultima operacao: ".$this->printUSDT($tempPrecoUltimaOperacao)."    ".
            "Preço: ".$this->printUSDT($this->precoNow)."     ".
            "Comprar no Preço: ".$this->printUSDT($this->getPorcToBuy())."     ".
            "Vender no Preço: ".$this->printUSDT($this->getPorcToSell())."\n"
        );
        $this->updatePrecoNowProx();
        $this->table($this->tempHeaders, $this->tableOperacoes);
        $this->line("\n\n");
    }

    private function updatePrecoNowProx()
    {
        if (!$this->tempAcabouDeOperar) {
            return ;
        }
        $this->tableOperacoes[count($this->tableOperacoes)-1][6] = $this->printUSDT($this->precoNow);
        $this->tempAcabouDeOperar = false;
    }
}
