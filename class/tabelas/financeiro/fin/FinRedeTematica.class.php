<?php

 class TabelaRedeTematica {
    
    private $nmRedeTematica = null;
    private $idRedeTematica = null;
    private $idBlocOrcamentario = null;
    
    function getNmRedeTematica() {
        return $this->nmRedeTematica;
    }

    function getIdRedeTematica() {
        return $this->idRedeTematica;
    }
    function getIdBlocOrcamentario() {
        return $this->idBlocOrcamentario;
    }

    function setIdBlocOrcamentario($idBlocOrcamentario) {
        $this->idBlocOrcamentario = $idBlocOrcamentario;
    }

    function setNmRedeTematica($nmRedeTematica) {
        $this->nmRedeTematica = $nmRedeTematica;
    }

    function setIdRedeTematica($idRedeTematica) {
        $this->idRedeTematica = $idRedeTematica;
    }

 }

