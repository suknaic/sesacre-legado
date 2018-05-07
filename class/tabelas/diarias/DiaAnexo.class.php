<?php

class DiaAnexo {

    private $idAnexo = null;
    private $idDiaria = null;
    private $nmAnexo = null;
    private $aqAnexo = null;
    private $nmMimeType = null;
    
    function getIdAnexo() {
        return $this->idAnexo;
    }

    function getIdDiaria() {
        return $this->idDiaria;
    }

    function getNmAnexo() {
        return $this->nmAnexo;
    }

    function getAqAnexo() {
        return $this->aqAnexo;
    }

    function getNmMimeType() {
        return $this->nmMimeType;
    }

    function setIdAnexo($idAnexo) {
        $this->idAnexo = $idAnexo;
    }

    function setIdDiaria($idDiaria) {
        $this->idDiaria = $idDiaria;
    }

    function setNmAnexo($nmAnexo) {
        $this->nmAnexo = $nmAnexo;
    }

    function setAqAnexo($aqAnexo) {
        $this->aqAnexo = $aqAnexo;
    }

    function setNmMimeType($nmMimeType) {
        $this->nmMimeType = $nmMimeType;
    }



}

