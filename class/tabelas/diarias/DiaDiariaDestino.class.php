<?php

class DiaDiariaDestino {
    
    private $idDiariaDestino = null;
    private $idDiaria = null;
    private $idCidadeInicio = null;
    private $idCidadeFim = null;
    private $dhInicio = null;
    private $dhFim = null;
    private $idTransporte = null;
    private $idDecreto = null;
    private $idClasse = null;
    private $flPernoite = null;
    private $qtDiariaDestino = null;
    private $vlDiariaDestino = null;

    function getIdDiariaDestino() {
        return $this->idDiariaDestino;
    }

    function getIdDiaria() {
        return $this->idDiaria;
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

    function getIdDecreto() {
        return $this->idDecreto;
    }

    function getIdClasse() {
        return $this->idClasse;
    }

    function getFlPernoite() {
        return $this->flPernoite;
    }

    function getQtDiariaDestino() {
        return $this->qtDiariaDestino;
    }

    function getVlDiariaDestino() {
        return $this->vlDiariaDestino;
    }

    function setIdDiariaDestino($idDiariaDestino) {
        $this->idDiariaDestino = $idDiariaDestino;
    }

    function setIdDiaria($idDiaria) {
        $this->idDiaria = $idDiaria;
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

    function setIdDecreto($idDecreto) {
        $this->idDecreto = $idDecreto;
    }

    function setIdClasse($idClasse) {
        $this->idClasse = $idClasse;
    }

    function setFlPernoite($flPernoite) {
        $this->flPernoite = $flPernoite;
    }

    function setQtDiariaDestino($qtDiariaDestino) {
        $this->qtDiariaDestino = $qtDiariaDestino;
    }

    function setVlDiariaDestino($vlDiariaDestino) {
        $this->vlDiariaDestino = $vlDiariaDestino;
    }


    
}