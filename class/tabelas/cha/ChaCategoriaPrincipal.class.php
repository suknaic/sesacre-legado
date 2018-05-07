<?php

class ChaCategoriaPrincipal {
    private $id_categoria_principal = null;
    private $nm_categoria_principal = null;
    private $st_ativo = null;
    
    function getId_categoria_principal() {
        return $this->id_categoria_principal;
    }

    function getNm_categoria_principal() {
        return $this->nm_categoria_principal;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_categoria_principal($id_categoria_principal) {
        $this->id_categoria_principal = $id_categoria_principal;
    }

    function setNm_categoria_principal($nm_categoria_principal) {
        $this->nm_categoria_principal = $nm_categoria_principal;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }



}
