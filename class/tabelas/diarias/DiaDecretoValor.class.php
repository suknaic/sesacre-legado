<?php

class DiaDecretoValor {
    private $idDecretoValor = null;
    private $idDecreto = null;
    private $idClasse = null;
    private $tpDecretoValor = null;
    private $vlDecretoValor = null;
    
    function __construct(int $idDecreto = 0, int $idClasse = 0, string $tpDecretoValor = "",  string $vlDecretoValor = "") {
        $this->idDecreto = $idDecreto;
        $this->idClasse = $idClasse;
        $this->tpDecretoValor = $tpDecretoValor;
        $this->vlDecretoValor = $vlDecretoValor;
    }
    
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

