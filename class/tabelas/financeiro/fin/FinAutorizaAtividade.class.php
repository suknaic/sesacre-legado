<?php

class FinAutorizaAtividade {
    
    private $id_autoriza_atividade = null;
    private $dt_ini = null;
    private $dt_fim = null;
    private $sit_ativo = null;
    private $id_pessoa = null;
    private $id_lotacao = null;

    
    public function getIdAutorizaAtividade() {
        return $this->id_autoriza_atividade;
    }

    public function getDtIni() {
        return $this->dt_ini;
    }

    public function getDtFim() {
        return $this->dt_fim;
    }

    public function getSitAtivo() {
        return $this->sit_ativo;
    }

    public function setIdAutorizaAtividade($id_autoriza_atividade) {
        $this->id_autoriza_atividade = $id_autoriza_atividade;
    }

    public function setDtIni($dt_ini) {
        $this->dt_ini = $dt_ini;
    }

    public function setDtFim($dt_fim) {
        $this->dt_fim = $dt_fim;
    }

    public function setSitAtivo($sit_ativo) {
        $this->sit_ativo = $sit_ativo;
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
    
    

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

