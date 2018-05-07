<?php

class SesPerfil{
    
    private $id_perfil = null;
    private $id_sistema = null;
    private $nm_perfil = null;
    private $st_ativo = null;
    
    function getIdPerfil() {
        return $this->id_perfil;
    }

    function getIdSistema() {
        return $this->id_sistema;
    }

    function getNmPerfil() {
        return $this->nm_perfil;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdPerfil($id_perfil) {
        $this->id_perfil = $id_perfil;
    }

    function setIdSistema($id_sistema) {
        $this->id_sistema = $id_sistema;
    }

    function setNmPerfil($nm_perfil) {
        $this->nm_perfil = $nm_perfil;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }


    
    
}

