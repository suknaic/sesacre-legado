<?php

class DiaRelatorioDestino {
    private $idRelatorioDestino = null;
    private $idRelatorio = null;
    private $idCidadeInicio = null;
    private $idCidadeFim = null;
    private $dhInicio = null;
    private $dhFim = null;
    private $idTransporte = null;
    private $idTransporteTipo = null;
    private $dsTransporteTipo = null;
    
    function getIdRelatorioDestino() {
        return $this->idRelatorioDestino;
    }

    function getIdRelatorio() {
        return $this->idRelatorio;
    }

    function getIdCidadeInicio() {
        return $this->idCidadeInicio;
    }

    function getIdCidadeFim() {
        return $this->idCidadeFim;
    }

    function getDhInicio() {
        return $this->dhInicio;
    }

    function getDhFim() {
        return $this->dhFim;
    }

    function getIdTransporte() {
        return $this->idTransporte;
    }

    function getIdTransporteTipo() {
        return $this->idTransporteTipo;
    }

    function getDsTransporteTipo() {
        return $this->dsTransporteTipo;
    }

    function setIdRelatorioDestino($idRelatorioDestino) {
        $this->idRelatorioDestino = $idRelatorioDestino;
    }

    function setIdRelatorio($idRelatorio) {
        $this->idRelatorio = $idRelatorio;
    }

    function setIdCidadeInicio($idCidadeInicio) {
        $this->idCidadeInicio = $idCidadeInicio;
    }

    function setIdCidadeFim($idCidadeFim) {
        $this->idCidadeFim = $idCidadeFim;
    }

    function setDhInicio($dhInicio) {
        $this->dhInicio = $dhInicio;
    }

    function setDhFim($dhFim) {
        $this->dhFim = $dhFim;
    }

    function setIdTransporte($idTransporte) {
        $this->idTransporte = $idTransporte;
    }

    function setIdTransporteTipo($idTransporteTipo) {
        $this->idTransporteTipo = $idTransporteTipo;
    }

    function setDsTransporteTipo($dsTransporteTipo) {
        $this->dsTransporteTipo = $dsTransporteTipo;
    }


}

