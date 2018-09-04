<?php

class LiquidacaoPesquisa {
    private $nrLiquidacao = null;
    private $anoLiquidacao = null;
    private $contratado = null;
    private $nrProtocolo = null;
    private $nrContrato = null;
    private $nrPedido = null;
    private $nrEmpenho = null;
    private $nrDocumentoFiscal = null;
    private $tipoGasto = null;
    private $situacao = null;
    
    function getNrLiquidacao() {
        return $this->nrLiquidacao;
    }

    function getAnoLiquidacao() {
        return $this->anoLiquidacao;
    }

    function getContratado() {
        return $this->contratado;
    }

    function getNrProtocolo() {
        return $this->nrProtocolo;
    }

    function getNrContrato() {
        return $this->nrContrato;
    }

    function getNrPedido() {
        return $this->nrPedido;
    }

    function getNrEmpenho() {
        return $this->nrEmpenho;
    }

    function getNrDocumentoFiscal() {
        return $this->nrDocumentoFiscal;
    }

    function getTipoGasto() {
        return $this->tipoGasto;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setNrLiquidacao($nrLiquidacao) {
        $this->nrLiquidacao = $nrLiquidacao;
        return $this;
    }

    function setAnoLiquidacao($anoLiquidacao) {
        $this->anoLiquidacao = $anoLiquidacao;
        return $this;
    }

    function setContratado($contratado) {
        $this->contratado = $contratado;
        return $this;
    }

    function setNrProtocolo($nrProtocolo) {
        $this->nrProtocolo = $nrProtocolo;
        return $this;
    }

    function setNrContrato($nrContrato) {
        $this->nrContrato = $nrContrato;
        return $this;
    }

    function setNrPedido($nrPedido) {
        $this->nrPedido = $nrPedido;
        return $this;
    }

    function setNrEmpenho($nrEmpenho) {
        $this->nrEmpenho = $nrEmpenho;
        return $this;
    }

    function setNrDocumentoFiscal($nrDocumentoFiscal) {
        $this->nrDocumentoFiscal = $nrDocumentoFiscal;
        return $this;
    }

    function setTipoGasto($tipoGasto) {
        $this->tipoGasto = $tipoGasto;
        return $this;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
        return $this;
    }


    private function montaFiltroSql(){
        $filtro = "";
 
        $array = array();
        
        if ($this->getNrLiquidacao()) {
            
            $retorno .= (empty($filtro)) ? " where liquidacao.nr_liquidacao ilike '%".$this->getNrLiquidacao()."%' " : " and liquidacao.nr_liquidacao ilike '%".$this->getNrLiquidacao()."%' " ; 
        }
        
//        if ($this->getAnoLiquidacao()) {

//        }
        
        if ($this->getContratado()) {
            $retorno .= (empty($filtro)) ? " where pessoa.id_pessoa = ".$this->getContratado() : " and pessoa.id_pessoa = ".$this->getContratado(); 
        }
        
//        if ($this->getNrProtocolo()) {
//        }
        
        if ($this->getNrContrato()) {
            $retorno .= (empty($filtro)) ? " where contrato.nr_contrato ilike '%".$this->getNrContrato()."%' " : " and contrato.nr_contrato ilike '%".$this->getNrContrato()."%' " ; 
        }
        
        if ($this->getNrPedido()) {
            $retorno .= (empty($filtro)) ? " where pedido.nr_pedido ilike '%".$this->getNrPedido()."%' " : " and pedido.nr_pedido ilike '%".$this->getNrPedido()."%' " ; 
        }
        
        if ($this->getNrEmpenho()) {
            $retorno .= (empty($filtro)) ? " where empenho.nr_empenho ilike '%".$this->getNrEmpenho()."%' " : " and empenho.nr_empenho ilike '%".$this->getNrEmpenho()."%' " ; 
        }
        
        if ($this->getNrDocumentoFiscal()) {
            $retorno .= (empty($filtro)) ? " where docFis.nr_documento_fiscal ilike '%".$this->getNrDocumentoFiscal()."%' " : " and docFis.nr_documento_fiscal ilike '%".$this->getNrDocumentoFiscal()."%' " ; 
        }
        
        return $filtro;
    }
}

