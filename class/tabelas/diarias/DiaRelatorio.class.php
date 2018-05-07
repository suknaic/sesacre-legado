<?php

class DiaRelatorio {
    private $idRelatorio = null;
    private $dsServicoExecutado = null;
    private $dsLocaisExecutado = null;
    private $dtRelatorioDestino = null;
    private $flRetorno = null;
    
    function getDsLocaisExecutado() {
        return $this->dsLocaisExecutado;
    }

    function setDsLocaisExecutado($dsLocaisExecutado) {
        $this->dsLocaisExecutado = $dsLocaisExecutado;
    }

    function getIdRelatorio() {
        return $this->idRelatorio;
    }

    function getDsServicoExecutado() {
        return $this->dsServicoExecutado;
    }

    function getDtRelatorioDestino() {
        return $this->dtRelatorioDestino;
    }

    function getFlRetorno() {
        return $this->flRetorno;
    }

    function setIdRelatorio($idRelatorio) {
        $this->idRelatorio = $idRelatorio;
    }

    function setDsServicoExecutado($dsServicoExecutado) {
        $this->dsServicoExecutado = $dsServicoExecutado;
    }

    function setDtRelatorioDestino($dtRelatorioDestino) {
        $this->dtRelatorioDestino = $dtRelatorioDestino;
    }

    function setFlRetorno($flRetorno) {
        $this->flRetorno = $flRetorno;
    }


}

