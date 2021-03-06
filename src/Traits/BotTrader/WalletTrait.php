<?php

namespace Bancario\Traits\BotTrader;

use Bancario\Modules\OpenBanking\Domain\AssetCode;

/**
 *
 */
trait WalletTrait
{
    protected $precoInicial;
    protected $precoNow;
    protected $saldoBTC;
    protected $saldoBTCInicial;
    protected $saldoBTCInicialTotal;
    protected $saldoUSDT;
    protected $saldoUSDTInicial;
    protected $saldoUSDTInicialTotal;

  
    public function printCaixa()
    {
        $this->info("Caixa em BTC: ".$this->saldoBTC."\n");
        $this->info("Caixa em USDT: ".$this->saldoUSDT."\n");
        $this->info($this->getTotalEmDolarInicial());
    }
    /**
     * Operação de Venda
     *
     * @return void
     */
    public function sellNow()
    {
        $this->line('Vai vender!');
        $this->tempPrecoUltimaOperacao = $this->getPrecoNow();
        ++$this->tempQntOperacaoVenda;
        $this->tempQntOperacaoCompra = 0;

        // Desconta em BTC
        $vo = $this->getQuantidadeAVender();



        // 3.0
        $this->trader->traddingAsset(
            AssetCode::fromString('BTC'),
            AssetCode::fromString('USDT'),
            $vo, // Quantidade Vendida do Primeiro Ativo (BTC)
            $this->getPrecoNow(),
            $this->taxa
        );




        // Remover Saldo da Carteira
        $this->wallets['BTC']->removeFromBalance($vo);
        $this->saldoBTC -= $vo;

        // Recebe em USDT
        $this->gastoTaxaBTC += $vo*($this->taxa/100);
        $vo = $vo*(1-$this->taxa/100);
        $this->wallets['USDT']->addToBalance($vo*$this->getPrecoNow());
        $this->saldoUSDT += $vo*$this->getPrecoNow();
        
        $this->addTabelaOperacoes(
            $this->tempQntOperacaoVenda.
            ' Vendendo: Operando '.$vo.' BTC\'s'
        );

        $this->pv = $this->getPrecoNow();
        $this->pc = $this->pv;
        $this->tempAcabouDeOperar = true;
    }
    /**
     * Operacao de Compra
     *
     * @return void
     */
    public function buyNow()
    {
        $this->line('Vai comprar');
        $this->tempPrecoUltimaOperacao = $this->getPrecoNow();
        ++$this->tempQntOperacaoCompra;
        $this->tempQntOperacaoVenda = 0;

        // Desconta em USDT
        $vo = $this->getQuantidadeAComprar();
        $this->wallets['USDT']->removeFromBalance($vo);
        $this->saldoUSDT -= $vo;



        // 3.0
        $this->trader->traddingAsset(
            AssetCode::fromString('USDT'),
            AssetCode::fromString('BTC'),
            $vo, // Quantidade Vendida do Primeiro Ativo (USDT)
            $this->getPrecoNow(),
            $this->taxa
        );


        // Recebe em BTC
        $this->gastoTaxaUSDT += $vo*($this->taxa/100);
        $vo = $vo*(1-$this->taxa/100);
        $this->saldoBTC += $vo/$this->getPrecoNow();
        $this->wallets['BTC']->removeFromBalance($vo/$this->getPrecoNow());

        // $this->info('Comprando...');
        $this->addTabelaOperacoes(
            $this->tempQntOperacaoCompra.
            ' Comprando: Operando '.$vo.' USDT\'s'
        );

        $this->pc = $this->getPrecoNow();
        $this->pv = $this->pc;
        $this->tempAcabouDeOperar = true;

    }


    /**
     * Retorna o valor total em Dolar Inicialmente
     */
    public function getTotalEmDolarInicial()
    {
        return $this->saldoBTCInicial*$this->precoInicial+$this->saldoUSDTInicial;
    }
    /**
     * Retorna o valor total em Dolar Inicialmente com o preço de btc hoje
     */
    public function getTotalEmDolarInicialHoje()
    {
        return $this->saldoBTCInicial*$this->getPrecoNow()+$this->saldoUSDTInicial;
    }

    /**
     * Retorna o valor total em Dolar Hoje
     */
    public function getTotalEmDolarHoje()
    {
        return 
            $this->wallets['BTC']->getBalance()*
            $this->getPrecoNow()+$this->wallets['USDT']->getBalance();
        // return $this->saldoBTC*$this->getPrecoNow()+$this->saldoUSDT;
    }
}
