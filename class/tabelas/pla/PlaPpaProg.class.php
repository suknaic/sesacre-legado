<?php

class PlaPpaProg{
    
    private $id_ppa_prog = null;
    private $cd_ppa_prog = null;
    private $nm_ppa_prog = null;    
    private $aa_inicio = null;
    private $aa_fim = null;
    private $st_ativo = null;
    
    
    public function getIdPpaProg() {
        return $this->id_ppa_prog;
    }

    public function getNmPpaProg() {
        return $this->nm_ppa_prog;
    }

    public function setIdPpaProg($id_ppa_prog) {
        $this->id_ppa_prog = $id_ppa_prog;
    }

    public function setNmPpaProg($nm_ppa_prog) {
        $this->nm_ppa_prog = $nm_ppa_prog;
    }
    
    public function getCdPpaProg() {
        return $this->cd_ppa_prog;
    }
    
    public function setCdPpaProg($cd_ppa_prog) {
        $this->cd_ppa_prog = $cd_ppa_prog;
    }
        
    function getAaInicio() {
        return $this->aa_inicio;
    }

    function getAaFim() {
        return $this->aa_fim;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setAaInicio($aa_inicio) {
        $this->aa_inicio = $aa_inicio;
    }

    function setAaFim($aa_fim) {
        $this->aa_fim = $aa_fim;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }




    
}
