<?php

 class TabelaBlocOrcamentario {
    
    private $nmBlocOrcamentario = null;
    private $idBlocOrcamentario = null;
    
    function getNmBlocOrcamentario() {
        return $this->nmBlocOrcamentario;
    }

    function getIdBlocOrcamentario() {
        return $this->idBlocOrcamentario;
    }

    function setNmBlocOrcamentario($nmBlocOrcamentario) {
        $this->nmBlocOrcamentario = $nmBlocOrcamentario;
    }

    function setIdBlocOrcamentario($idBlocOrcamentario) {
        $this->idBlocOrcamentario = $idBlocOrcamentario;
    }

 }

