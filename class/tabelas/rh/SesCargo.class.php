<?php

class SesCargo{
    
    private $id_cargo = null;
    private $nm_cargo = null;
    private $st_ativo = null;
    function getId_cargo() {
        return $this->id_cargo;
    }

    function getNm_cargo() {
        return $this->nm_cargo;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_cargo($id_cargo) {
        $this->id_cargo = $id_cargo;
    }

    function setNm_cargo($nm_cargo) {
        $this->nm_cargo = $nm_cargo;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    
             
}


