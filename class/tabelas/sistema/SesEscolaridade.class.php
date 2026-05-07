<?php

class SesEscolaridade {

    private $id_escolaridade = null;
    private $nm_escolaridade = null;
    private $id_pessoa_fisica = null;
    private $st_ativo = null;

    function getIdEscolaridade() {
        return $this->id_escolaridade;
    }

    function getNmEscolaridade() {
        return $this->nm_escolaridade;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdEscolaridade($id_escolaridade) {
        $this->id_escolaridade = $id_escolaridade;
    }

    function setNmEscolaridade($nm_escolaridade) {
        $this->nm_escolaridade = $nm_escolaridade;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    function getId_pessoa_fisica() {
        return $this->id_pessoa_fisica;
    }

    function setId_pessoa_fisica($id_pessoa_fisica) {
        $this->id_pessoa_fisica = $id_pessoa_fisica;
    }

}
