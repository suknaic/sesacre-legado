<?php

class SesFormacao{
    private $id_escolaridade_formacao = null;
    private $nm_escolaridade_formacao = null;
    private $id_escolaridade = null;
    private $st_ativo = null;
    //***************************************
    function getId_escolaridade_formacao() {
        return $this->id_escolaridade_formacao;
    }

    function getNm_escolaridade_formacao() {
        return $this->nm_escolaridade_formacao;
    }

    function getId_escolaridade() {
        return $this->id_escolaridade;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_escolaridade_formacao($id_escolaridade_formacao) {
        $this->id_escolaridade_formacao = $id_escolaridade_formacao;
    }

    function setNm_escolaridade_formacao($nm_escolaridade_formacao) {
        $this->nm_escolaridade_formacao = $nm_escolaridade_formacao;
    }

    function setId_escolaridade($id_escolaridade) {
        $this->id_escolaridade = $id_escolaridade;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }



}


