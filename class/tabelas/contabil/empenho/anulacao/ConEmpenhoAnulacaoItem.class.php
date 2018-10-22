<?php

class ConEmpenhoAnulacaoItem {

    private $id_empenho_anulacao_item = null;
    private $id_empenho_anulacao = null;
    private $id_pre_ordem = null;
    private $qt_item = null;
    private $vl_item = null;
    private $qt_anulacao = null;
    private $vl_anulado = null;
    private $vl_saldo = null;
    private $vl_utilizado = null;
    private $qt_utilizado = null;
    
    public function getVlUtilizado() {
        return $this->vl_utilizado;
    }

    public function setVlUtilizado($vl_utilizado) {
        $this->vl_utilizado = $vl_utilizado;
        return $this;
    }

    function getQtUtilizado() {
        return $this->qt_utilizado;
    }

    function setQtUtilizado($qt_utilizado) {
        $this->qt_utilizado = $qt_utilizado;
        return $this;
    }
        
    function getVlSaldo() {
        return $this->vl_saldo;
    }

    function setVlSaldo($vl_saldo) {
        $this->vl_saldo = $vl_saldo;
        return $this;
    }
    
    function getIdEmpenhoAnulacaoItem() {
        return $this->id_empenho_anulacao_item;
    }

    function getIdEmpenhoAnulacao() {
        return $this->id_empenho_anulacao;
    }

    function getIdPreOrdem() {
        return $this->id_pre_ordem;
    }

    function getQtItem() {
        return $this->qt_item;
    }

    function getVlItem() {
        return $this->vl_item;
    }

    function getQtAnulacao() {
        return $this->qt_anulacao;
    }

    function getVlAnulado() {
        return $this->vl_anulado;
    }

    function setIdEmpenhoAnulacaoItem($id_empenho_anulacao_item) {
        $this->id_empenho_anulacao_item = $id_empenho_anulacao_item;
        return $this;
    }

    function setIdEmpenhoAnulacao($id_empenho_anulacao) {
        $this->id_empenho_anulacao = $id_empenho_anulacao;
        return $this;
    }

    function setIdPreOrdem($id_pre_ordem) {
        $this->id_pre_ordem = $id_pre_ordem;
        return $this;
    }

    function setQtItem($qt_item) {
        $this->qt_item = $qt_item;
        return $this;
    }

    function setVlItem($vl_item) {
        $this->vl_item = $vl_item;
        return $this;
    }

    function setQtAnulacao($qt_anulacao) {
        $this->qt_anulacao = $qt_anulacao;
        return $this;
    }

    function setVlAnulado($vl_anulado) {
        $this->vl_anulado = $vl_anulado;
        return $this;
    }


}

