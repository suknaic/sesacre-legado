<?php

class DiaTipo {
    private $idTipo = null;
    private $nmTipo = null;
    private $stAtivo = null;
    
    function getIdTipo() {
        return $this->idTipo;
    }

    function getNmTipo() {
        return $this->nmTipo;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    function setNmTipo($nmTipo) {
        $this->nmTipo = $nmTipo;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }


}

