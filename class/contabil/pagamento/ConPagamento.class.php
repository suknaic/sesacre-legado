<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/pagamento/DaoConPagamento.class.php";

class ConPagamento{
    private $id_pagamento = null;
    private $id_pagamento_situacao = null;
    private $id_pagamento_status = null;
    private $id_liquidacao = null;
    private $id_lotacao = null;
    private $id_doc_tipo_lotacao = null;
    private $nr_pagamento = null;
    private $dt_pagamento = null;
    private $vl_pagamento = null;
    private $ds_pagamento = null;
    private $st_ativo = null;
    
    function getId_pagamento() {
        return $this->id_pagamento;
    }

    function getId_pagamento_situacao() {
        return $this->id_pagamento_situacao;
    }

    function getId_pagamento_status() {
        return $this->id_pagamento_status;
    }

    function getId_liquidacao() {
        return $this->id_liquidacao;
    }

    function getId_lotacao() {
        return $this->id_lotacao;
    }

    function getId_doc_tipo_lotacao() {
        return $this->id_doc_tipo_lotacao;
    }

    function getNr_pagamento() {
        return $this->nr_pagamento;
    }

    function getDt_pagamento() {
        return $this->dt_pagamento;
    }

    function getVl_pagamento() {
        return $this->vl_pagamento;
    }

    function getDs_pagamento() {
        return $this->ds_pagamento;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_pagamento($id_pagamento) {
        $this->id_pagamento = $id_pagamento;
    }

    function setId_pagamento_situacao($id_pagamento_situacao) {
        $this->id_pagamento_situacao = $id_pagamento_situacao;
    }

    function setId_pagamento_status($id_pagamento_status) {
        $this->id_pagamento_status = $id_pagamento_status;
    }

    function setId_liquidacao($id_liquidacao) {
        $this->id_liquidacao = $id_liquidacao;
    }

    function setId_lotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;
    }

    function setId_doc_tipo_lotacao($id_doc_tipo_lotacao) {
        $this->id_doc_tipo_lotacao = $id_doc_tipo_lotacao;
    }

    function setNr_pagamento($nr_pagamento) {
        $this->nr_pagamento = $nr_pagamento;
    }

    function setDt_pagamento($dt_pagamento) {
        $this->dt_pagamento = $dt_pagamento;
    }

    function setVl_pagamento($vl_pagamento) {
        $this->vl_pagamento = $vl_pagamento;
    }

    function setDs_pagamento($ds_pagamento) {
        $this->ds_pagamento = $ds_pagamento;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    
    
    public function salvaPagamento(){
        try{
            if(empty($this->id_pagamento_situacao) || empty($this->id_pagamento_status) || empty($this->id_liquidacao) || empty($this->id_lotacao) 
              || empty($this->id_doc_tipo_lotacao) || empty($this->nr_pagamento) || empty($this->dt_pagamento) || empty($this->vl_pagamento) 
              || empty($this->vl_pagamento) || empty($this->ds_pagamento) || empty($this->st_ativo)){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->setId_pagamento_situacao($this->id_pagamento_situacao);
            $daoConPagamento->setId_pagamento_status($this->id_pagamento_status);
            $daoConPagamento->setId_liquidacao($this->id_liquidacao);
            $daoConPagamento->setId_lotacao($this->id_lotacao);
            $daoConPagamento->setId_doc_tipo_lotacao($this->id_doc_tipo_lotacao);
            $daoConPagamento->setNr_pagamento($this->nr_pagamento);
            
        } catch (Exception $ex) {

        }
    }
    
}