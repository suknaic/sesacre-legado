<?php

class ConEmpenhoAnulacao {

    private $id_empenho_anulacao = null;
    private $id_pedido = null;
    private $nr_empenho_anulacao = null;
    private $dt_empenho_anulacao = null;
    private $dh_empenho_anulacao = null;
    private $vl_empenho_anulacao = null;
    private $vl_empenho_antigo = null;
    private $id_empenho_anulacao_situacao = null;
    private $id_empenho_anulacao_status = null;
    private $id_pessoa = null;

    function getIdEmpenhoAnulacao() {
        return $this->id_empenho_anulacao;
    }

    function getIdPedido() {
        return $this->id_pedido;
    }

    function getNrEmpenhoAnulacao() {
        return $this->nr_empenho_anulacao;
    }

    function getDtEmpenhoAnulacao() {
        return $this->dt_empenho_anulacao;
    }

    function getDhEmpenhoAnulacao() {
        return $this->dh_empenho_anulacao;
    }

    function getVlEmpenhoAnulacao() {
        return $this->vl_empenho_anulacao;
    }

    function getVlEmpenhoAntigo() {
        return $this->vl_empenho_antigo;
    }

    function getIdEmpenhoAnulacaoSituacao() {
        return $this->id_empenho_anulacao_situacao;
    }

    function getIdEmpenhoAnulacaoStatus() {
        return $this->id_empenho_anulacao_status;
    }

    function getIdPessoa() {
        return $this->id_pessoa;
    }

    function setIdEmpenhoAnulacao($id_empenho_anulacao) {
        $this->id_empenho_anulacao = $id_empenho_anulacao;
        return $this;
    }

    function setIdPedido($id_pedido) {
        $this->id_pedido = $id_pedido;
        return $this;
    }

    function setNrEmpenhoAnulacao($nr_empenho_anulacao) {
        $this->nr_empenho_anulacao = $nr_empenho_anulacao;
        return $this;
    }

    function setDtEmpenhoAnulacao($dt_empenho_anulacao) {
        $this->dt_empenho_anulacao = $dt_empenho_anulacao;
        return $this;
    }

    function setDhEmpenhoAnulacao($dh_empenho_anulacao) {
        $this->dh_empenho_anulacao = $dh_empenho_anulacao;
        return $this;
    }

    function setVlEmpenhoAnulacao($vl_empenho_anulacao) {
        $this->vl_empenho_anulacao = $vl_empenho_anulacao;
        return $this;
    }

    function setVlEmpenhoAntigo($vl_empenho_antigo) {
        $this->vl_empenho_antigo = $vl_empenho_antigo;
        return $this;
    }

    function setIdEmpenhoAnulacaoSituacao($id_empenho_anulacao_situacao) {
        $this->id_empenho_anulacao_situacao = $id_empenho_anulacao_situacao;
        return $this;
    }

    function setIdEmpenhoAnulacaoStatus($id_empenho_anulacao_status) {
        $this->id_empenho_anulacao_status = $id_empenho_anulacao_status;
        return $this;
    }

    function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
        return $this;
    }


}

