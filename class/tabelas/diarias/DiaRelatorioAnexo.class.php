<?php

class DiaRelatorioAnexo {

    private $idRelatorioAnexo = null;
    private $idRelatorio = null;
    private $nmRelatorioAnexo = null;
    private $lkRelatorioAnexo = null;
    private $aqRelatorioAnexo = null;
    private $nmMimeType = null;
    
    function getNmMimeType() {
        return $this->nmMimeType;
    }

    function setNmMimeType($nmMimeType) {
        $this->nmMimeType = $nmMimeType;
    }

        
    function getIdRelatorioAnexo() {
        return $this->idRelatorioAnexo;
    }

    function getIdRelatorio() {
        return $this->idRelatorio;
    }

    function getNmRelatorioAnexo() {
        return $this->nmRelatorioAnexo;
    }

    function getLkRelatorioAnexo() {
        return $this->lkRelatorioAnexo;
    }

    function setIdRelatorioAnexo($idRelatorioAnexo) {
        $this->idRelatorioAnexo = $idRelatorioAnexo;
    }

    function setIdRelatorio($idRelatorio) {
        $this->idRelatorio = $idRelatorio;
    }

    function setNmRelatorioAnexo($nmRelatorioAnexo) {
        $this->nmRelatorioAnexo = $nmRelatorioAnexo;
    }

    function setLkRelatorioAnexo($lkRelatorioAnexo) {
        $this->lkRelatorioAnexo = $lkRelatorioAnexo;
    }


    function getAqRelatorioAnexo() {
        return $this->aqRelatorioAnexo;
    }

    function setAqRelatorioAnexo($aqRelatorioAnexo) {
        $this->aqRelatorioAnexo = $aqRelatorioAnexo;
    }



}
