<?php

class DiaDecretoValor {
    private $idDecretoValor = null;
    private $idDecreto = null;
    private $idClasse = null;
    private $tpDecretoValor = null;
    private $vlDecretoValor = null;
    
    function getIdDecretoValor() {
        return $this->idDecretoValor;
    }

    function getIdDecreto() {
        return $this->idDecreto;
    }

    function getIdClasse() {
        return $this->idClasse;
    }

    function getTpDecretoValor() {
        return $this->tpDecretoValor;
    }

    function getVlDecretoValor() {
        return $this->vlDecretoValor;
    }

    function setIdDecretoValor($idDecretoValor) {
        $this->idDecretoValor = $idDecretoValor;
    }

    function setIdDecreto($idDecreto) {
        $this->idDecreto = $idDecreto;
    }

    function setIdClasse($idClasse) {
        $this->idClasse = $idClasse;
    }

    function setTpDecretoValor($tpDecretoValor) {
        $this->tpDecretoValor = $tpDecretoValor;
    }

    function setVlDecretoValor($vlDecretoValor) {
        $this->vlDecretoValor = $vlDecretoValor;
    }


}

