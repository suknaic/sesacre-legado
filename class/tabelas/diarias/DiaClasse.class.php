<?php

class DiaClasse {
    private $idClasse = null;
    private $nmClasse = null;
    private $cdClasse = null;
    private $stAtivo = null;
    
    function getIdClasse() {
        return $this->idClasse;
    }

    function getNmClasse() {
        return $this->nmClasse;
    }

    function getCdClasse() {
        return $this->cdClasse;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdClasse($idClasse) {
        $this->idClasse = $idClasse;
    }

    function setNmClasse($nmClasse) {
        $this->nmClasse = $nmClasse;
    }

    function setCdClasse($cdClasse) {
        $this->cdClasse = $cdClasse;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }



}

