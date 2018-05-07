<?php

class FinAutorizaCentral {

    private $id_autoriza_central = null;
    private $dt_ini = null;
    private $dt_fim = null;
    private $st_ativo = null;
    private $id_pessoa = null;
    private $id_lotacao = null;
    private $tipo_autorizacao = null;

    public function getIdAutorizaCentral() {
        return $this->id_autoriza_central;
    }

    public function getDtIni() {
        return $this->dt_ini;
    }

    public function getDtFim() {
        return $this->dt_fim;
    }

    public function getStAtivo() {
        return $this->st_ativo;
    }

    public function getTipoAutorizacao() {
        return $this->tipo_autorizacao;
    }

    public function setIdAutorizaCentral($id_autoriza_central) {
        $this->id_autoriza_central = $id_autoriza_central;
    }

    public function setDtIni($dt_ini) {
        $this->dt_ini = $dt_ini;
    }

    public function setDtFim($dt_fim) {
        $this->dt_fim = $dt_fim;
    }

    public function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    public function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;
    }

    public function getIdLotacao() {
        return $this->id_lotacao;
    }

    public function setTipoAutorizacao($tipo_autorizacao) {
        $this->tipo_autorizacao = $tipo_autorizacao;
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

