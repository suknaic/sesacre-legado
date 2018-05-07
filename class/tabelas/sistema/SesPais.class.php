<?php

class SesPais{
    
    private $id_pais = null;
    private $nm_sigla = null;
    private $nm_pais = null;
    private $st_ativo = null;

    function getIdPais() {
        return $this->id_pais;
    }

    function getNmSigla() {
        return $this->nm_sigla;
    }

    function getNmPais() {
        return $this->nm_pais;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdPais($id_pais) {
        $this->id_pais = $id_pais;
    }

    function setNmSigla($nm_sigla) {
        $this->nm_sigla = $nm_sigla;
    }

    function setNmPais($nm_pais) {
        $this->nm_pais = $nm_pais;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }



    
}
