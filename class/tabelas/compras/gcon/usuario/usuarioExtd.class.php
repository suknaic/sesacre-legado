<?php

class UsuarioExtd {
    
    private $idPerfilPessoa = null;
    private $idUsuario = null;
    private $idPermissao =  null;
    private $idPerfil = null;
     
    function getIdUsuario() {
        return $this->idUsuario;
    }
    
    function getIdPermissao() {
        return $this->idPermissao;
    }
    
    function getIdPerfil() {
        return $this->idPerfil;
    }
    
    function getIdPerfilPessoa() {
        return $this->idPerfilPessoa;
    }

    function setIdPerfilPessoa($idPerfilPessoa) {
        $this->idPerfilPessoa = $idPerfilPessoa;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    function setIdPermissao($idPermissao) {
        $this->idPermissao = $idPermissao;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

}
    

