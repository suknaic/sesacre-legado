<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/pagamento/DaoConPagamento.class.php";

class ConPagamento {

    private $id_pagamento = null;
    private $id_pagamento_situacao = null;
    private $id_pagamento_status = null;
    private $id_liquidacao = null;
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

    public function salvaPagamento() {
        try {
            

            if (empty($this->id_liquidacao) || empty($this->id_lotacao) || empty($this->id_doc_tipo_lotacao) || empty($this->nr_pagamento) || empty($this->dt_pagamento) || empty($this->vl_pagamento) || empty($this->vl_pagamento_saldo) || empty($this->ds_pagamento)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->setIdPagamentoSituacao(1);
            $daoConPagamento->setIdPagamentoStatus(1);
            $daoConPagamento->setIdLiquidacao($this->id_liquidacao);
            $daoConPagamento->setIdLotacao($this->id_lotacao);
            $daoConPagamento->setIdDocTipoLotacao($this->id_doc_tipo_lotacao);
            $daoConPagamento->setNrPagamento($this->nr_pagamento);
            $daoConPagamento->setNrPagamento($this->nr_pagamento);
            $daoConPagamento->setDtPagamento(Metodos::ConverteDataING($this->dt_pagamento));
            $daoConPagamento->setVlPagamento(Metodos::ConverteValorIng($this->vl_pagamento));
            $daoConPagamento->setVlPagamentoSaldo($this->vl_pagamento_saldo);
            $daoConPagamento->setDsPagamento($this->ds_pagamento);
            $daoConPagamento->salvaPagamento($pdo);

            if ($daoConPagamento->Sucesso()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", "Pagamento cadastrado com sucesso.");
            }

            return Metodos::retornoAjax("Erro", "alert", "Erro ao cadastrar o pagamento");
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "alert", "Erro ao verificar os dados desta Liquidação");
        }
    }

  
}
