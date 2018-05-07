<?php

class SesFuncao{
    private $id_funcao = null;
    private $nm_funcao = null;
    private $st_ativo = null;
    //***************************************
    function getId_funcao() {
        return $this->id_funcao;
    }

    function getNm_funcao() {
        return $this->nm_funcao;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_funcao($id_funcao) {
        $this->id_funcao = $id_funcao;
    }

    function setNm_funcao($nm_funcao) {
        $this->nm_funcao = $nm_funcao;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }


}


