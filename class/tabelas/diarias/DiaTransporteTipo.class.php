<?php

class DiaTransporteTipo {
    private $idTransporteTipo = null;
    private $nmTransporteTipo = null;
    private $stAtivo = null;
    
    function getIdTransporteTipo() {
        return $this->idTransporteTipo;
    }

    function getNmTransporteTipo() {
        return $this->nmTransporteTipo;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdTransporteTipo($idTransporteTipo) {
        $this->idTransporteTipo = $idTransporteTipo;
    }

    function setNmTransporteTipo($nmTransporteTipo) {
        $this->nmTransporteTipo = $nmTransporteTipo;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }


}

