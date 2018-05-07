<?php

class FinAutorizaOrcamento {
    
    private $id_autoriza_orcamento = null;
    private $dt_ini = null;
    private $dt_fim = null;
    private $st_ativo = null;
    private $id_pessoa = null;

    
    public function getIdAutorizaOrcamento() {
        return $this->id_autoriza_orcamento;
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

    public function setIdAutorizaOrcamento($id_autoriza_orcamento) {
        $this->id_autoriza_orcamento = $id_autoriza_orcamento;
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
    

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


