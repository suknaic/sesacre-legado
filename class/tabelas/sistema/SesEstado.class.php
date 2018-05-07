<?php

class SesEstado{
    
    private $id_pais = null;
    private $id_estado = null;
    private $nm_sigla = null;
    private $nm_estado = null;
    private $st_ativo = null;
    
    function getIdPais() {
        return $this->id_pais;
    }
     function getIdEstado() {
        return $this->id_estado;
    }

    function getNmSigla() {
        return $this->nm_sigla;
    }

    function getNmEstado() {
        return $this->nm_estado;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdPais($id_pais) {
        $this->id_pais = $id_pais;
    }
     function setIdEstado($id_estado) {
        $this->id_estado = $id_estado;
    }

    function setNmSigla($nm_sigla) {
        $this->nm_sigla = $nm_sigla;
    }

    function setNmEstado($nm_estado) {
        $this->nm_estado = $nm_estado;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }



    
}
