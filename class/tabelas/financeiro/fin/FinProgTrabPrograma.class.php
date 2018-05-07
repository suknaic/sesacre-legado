<?php

 class TabelaProgTrabPrograma {
    //atributos de prog_trab_programa
    private $codPrograma = null;
    private $idCodPrograma = null;
    //============================//
    //getters e setters de prog_trab_programa
    function getCodPrograma() {
        return $this->codPrograma;
    }

    function getIdCodPrograma() {
        return $this->idCodPrograma;
    }

    function setCodPrograma($codPrograma) {
        $this->codPrograma = $codPrograma;
    }

    function setIdCodPrograma($idCodPrograma) {
        $this->idCodPrograma = $idCodPrograma;
    }
    //=========================================//
 }