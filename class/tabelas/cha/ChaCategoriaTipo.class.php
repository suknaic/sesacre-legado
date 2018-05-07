<?php

class ChaCategoriaTipo{

    private $idCategoriaTipo = null;
    private $idCategoriaPrincipal = null;
    private $nmCategoriaTipo = null;
    private $stAtivo = null;
    
    function getIdCategoriaTipo() {
        return $this->idCategoriaTipo;
    }

    function getIdCategoriaPrincipal() {
        return $this->idCategoriaPrincipal;
    }

    function getNmCategoriaTipo() {
        return $this->nmCategoriaTipo;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdCategoriaTipo($idCategoriaTipo) {
        $this->idCategoriaTipo = $idCategoriaTipo;
    }

    function setIdCategoriaPrincipal($idCategoriaPrincipal) {
        $this->idCategoriaPrincipal = $idCategoriaPrincipal;
    }

    function setNmCategoriaTipo($nmCategoriaTipo) {
        $this->nmCategoriaTipo = $nmCategoriaTipo;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

}
