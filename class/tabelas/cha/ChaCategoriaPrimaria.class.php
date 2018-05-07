<?php

class ChaCategoriaPrimaria {
    
    private $idCategoriaPrimaria = null;
    private $idCategoriaTipo = null;
    private $nmCategoriaPrimaria = null;
    private $stAtivo = null;
    
    /**
     * nm_categoria_primaria: GRP, Sesacrenet, Computador, Impressora 
     */
    
    function getIdCategoriaPrimaria() {
        return $this->idCategoriaPrimaria;
    }

    function getIdCategoriaTipo() {
        return $this->idCategoriaTipo;
    }

    function getNmCategoriaPrimaria() {
        return $this->nmCategoriaPrimaria;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdCategoriaPrimaria($idCategoriaPrimaria) {
        $this->idCategoriaPrimaria = $idCategoriaPrimaria;
    }

    function setIdCategoriaTipo($idCategoriaTipo) {
        $this->idCategoriaTipo = $idCategoriaTipo;
    }

    function setNmCategoriaPrimaria($nmCategoriaPrimaria) {
        $this->nmCategoriaPrimaria = $nmCategoriaPrimaria;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }



}

