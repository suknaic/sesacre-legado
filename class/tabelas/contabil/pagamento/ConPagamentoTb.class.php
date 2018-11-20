<?php

class ConPagamentoTb {

    private $id_pagamento = null;
    private $id_pagamento_situacao = null;
    private $id_pagamento_status = null;
    private $id_liquidacao = null;
    private $id_liquidacao_situacao = null;
    private $id_lotacao = null;
    private $id_doc_tipo_lotacao = null;
    private $nr_pagamento = null;
    private $dt_pagamento = null;
    private $vl_pagamento = null;
    private $vl_pagamento_saldo = null;
    private $ds_pagamento = null;
    private $st_ativo = null;
    private $docs_pagamento = null;

    public function getIdPagamento() {
        return $this->id_pagamento;
    }

    public function setIdPagamento($id_pagamento) {
        $this->id_pagamento = $id_pagamento;

        return $this;
    }

    public function getIdPagamentoSituacao() {
        return $this->id_pagamento_situacao;
    }

    public function setIdPagamentoSituacao($id_pagamento_situacao) {
        $this->id_pagamento_situacao = $id_pagamento_situacao;

        return $this;
    }

    public function getIdPagamentoStatus() {
        return $this->id_pagamento_status;
    }

    public function setIdPagamentoStatus($id_pagamento_status) {
        $this->id_pagamento_status = $id_pagamento_status;

        return $this;
    }

    public function getIdLiquidacao() {
        return $this->id_liquidacao;
    }

    public function setIdLiquidacao($id_liquidacao) {
        $this->id_liquidacao = $id_liquidacao;

        return $this;
    }

    public function getIdLiquidacaoSituacao() {
        return $this->id_liquidacao_situacao;
    }

    public function setIdLiquidacaoSituacao($id_liquidacao_situacao) {
        $this->id_liquidacao_situacao = $id_liquidacao_situacao;

        return $this;
    }

    public function getIdLotacao() {
        return $this->id_lotacao;
    }

    public function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;

        return $this;
    }

    public function getIdDocTipoLotacao() {
        return $this->id_doc_tipo_lotacao;
    }

    public function setIdDocTipoLotacao($id_doc_tipo_lotacao) {
        $this->id_doc_tipo_lotacao = $id_doc_tipo_lotacao;

        return $this;
    }

    public function getNrPagamento() {
        return $this->nr_pagamento;
    }

    public function setNrPagamento($nr_pagamento) {
        $this->nr_pagamento = $nr_pagamento;

        return $this;
    }

    public function getDtPagamento() {
        return $this->dt_pagamento;
    }

    public function setDtPagamento($dt_pagamento) {
        $this->dt_pagamento = $dt_pagamento;

        return $this;
    }

    public function getVlPagamento() {
        return $this->vl_pagamento;
    }

    public function setVlPagamento($vl_pagamento) {
        $this->vl_pagamento = $vl_pagamento;

        return $this;
    }

    public function getVlPagamentoSaldo() {
        return $this->vl_pagamento_saldo;
    }

    public function setVlPagamentoSaldo($vl_pagamento_saldo) {
        $this->vl_pagamento_saldo = $vl_pagamento_saldo;

        return $this;
    }

    public function getDsPagamento() {
        return $this->ds_pagamento;
    }

    public function setDsPagamento($ds_pagamento) {
        $this->ds_pagamento = $ds_pagamento;

        return $this;
    }

    public function getStAtivo() {
        return $this->st_ativo;
    }

    public function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;

        return $this;
    }

    public function getDocsPagamento() {
        return $this->docs_pagamento;
    }

    public function setDocsPagamento($docs_pagamento) {
        $this->docs_pagamento = $docs_pagamento;

        return $this;
    }

}
