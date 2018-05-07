<?php

class DiaDecreto {
    private $idDecreto = null;
    private $nmDecreto = null;
    private $stAtivo = null;
    
    function getIdDecreto() {
        return $this->idDecreto;
    }

    function getNmDecreto() {
        return $this->nmDecreto;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdDecreto($idDecreto) {
        $this->idDecreto = $idDecreto;
    }

    function setNmDecreto($nmDecreto) {
        $this->nmDecreto = $nmDecreto;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }



}

