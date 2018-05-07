<?php

class DiaTransporte {
    private $idTransporte = null;
    private $nmTransporte = null;
    private $stAtivo = null;
    
    function getIdTransporte() {
        return $this->idTransporte;
    }

    function getNmTransporte() {
        return $this->nmTransporte;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdTransporte($idTransporte) {
        $this->idTransporte = $idTransporte;
    }

    function setNmTransporte($nmTransporte) {
        $this->nmTransporte = $nmTransporte;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }


}

