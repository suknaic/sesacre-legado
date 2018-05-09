<?php

class DiaTransporteTemTipo {

    private $idTransporteTemTipo = null;
    private $idTransporte = null;
    private $idTransporteTipo = null;
    
    function getIdTransporteTemTipo() {
        return $this->idTransporteTemTipo;
    }

    function getIdTransporte() {
        return $this->idTransporte;
    }

    function getIdTransporteTipo() {
        return $this->idTransporteTipo;
    }

    function setIdTransporteTemTipo($idTransporteTemTipo) {
        $this->idTransporteTemTipo = $idTransporteTemTipo;
    }

    function setIdTransporte($idTransporte) {
        $this->idTransporte = $idTransporte;
    }

    function setIdTransporteTipo($idTransporteTipo) {
        $this->idTransporteTipo = $idTransporteTipo;
    }



}

