<?php

class PlaPas{
    
    private $id_pas = null;
    private $id_pes = null;
    private $id_lotacao = null;
    private $nm_pas = null;
    private $dt_inicio = null;
    private $dt_fim = null;
    private $id_pessoa_resp = null;
    private $id_pessoa_exec = null;
    private $ds_observacao = null;
    private $st_pas = null;
    private $st_ativo = null;
    
    function getIdPas() {
        return $this->id_pas;
    }

    function getIdPes() {
        return $this->id_pes;
    }

    function getIdLotacao() {
        return $this->id_lotacao;
    }

    function getNmPas() {
        return $this->nm_pas;
    }

    function getDtInicio() {
        return $this->dt_inicio;
    }
    
    function getDtFim() {
        return $this->dt_fim;
    }

    function getIdPessoaResp() {
        return $this->id_pessoa_resp;
    }

    function getIdPessoaExec() {
        return $this->id_pessoa_exec;
    }

    function getDsObservacao() {
        return $this->ds_observacao;
    }
    
    function getStPas() {
        return $this->st_pas;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdPas($id_pas) {
        $this->id_pas = $id_pas;
    }

    function setIdPes($id_pes) {
        $this->id_pes = $id_pes;
    }

    function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;
    }

    function setNmPas($nm_pas) {
        $this->nm_pas = $nm_pas;
    }

    function setDtInicio($dt_inicio) {
        $this->dt_inicio = $dt_inicio;
    }
    
    function setDtFim($dt_fim) {
        $this->dt_fim = $dt_fim;
    }

    function setIdPessoaResp($id_pessoa_resp) {
        $this->id_pessoa_resp = $id_pessoa_resp;
    }

    function setIdPessoaExec($id_pessoa_exec) {
        $this->id_pessoa_exec = $id_pessoa_exec;
    }

    function setDsObservacao($ds_observacao) {
        $this->ds_observacao = $ds_observacao;
    }

    function setStPas($st_pas) {
        $this->st_pas = $st_pas;
    }
    
    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }       
}

