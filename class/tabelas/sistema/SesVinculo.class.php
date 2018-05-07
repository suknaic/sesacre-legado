<?php

class SesVinculo{
    
    private $id_vinculo = null;
    private $nm_vinculo = null;    
    private $st_ativo = null;

    function getIdVinculo() {
        return $this->id_vinculo;
    }
    function getNmVinculo() {
        return $this->nm_vinculo;
    }
    function getStAtivo() {
        return $this->st_ativo;
    }
    function setIdVinculo($id_vinculo) {
        $this->id_vinculo = $id_vinculo;
    }
    function setNmVinculo($nm_vinculo) {
        $this->nm_vinculo = $nm_vinculo;
    }
    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }


    
}
