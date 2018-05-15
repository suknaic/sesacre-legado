<?php

class DiaDiariaHistorico {

    private $idDiariaHistorico = null;
    private $idDiaria = null;
    private $idPessoa = null;
    private $dhDiariaHistorico = null;
    private $dsDiariaHistorico = null;
    
    function getIdDiariaHistorico() {
        return $this->idDiariaHistorico;
    }

    function getIdDiaria() {
        return $this->idDiaria;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getDhDiariaHistorico() {
        return $this->dhDiariaHistorico;
    }

    function getDsDiariaHistorico() {
        return $this->dsDiariaHistorico;
    }

    function setIdDiariaHistorico($idDiariaHistorico) {
        $this->idDiariaHistorico = $idDiariaHistorico;
    }

    function setIdDiaria($idDiaria) {
        $this->idDiaria = $idDiaria;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    function setDhDiariaHistorico($dhDiariaHistorico) {
        $this->dhDiariaHistorico = $dhDiariaHistorico;
    }

    function setDsDiariaHistorico($dsDiariaHistorico) {
        $this->dsDiariaHistorico = $dsDiariaHistorico;
    }



}

