<?php

class SesPerfilPessoa{
    
    private $id_perfil_pessoa = null;
    private $id_perfil = null;
    private $id_pessoa = null;
    
    
    function getIdPerfilPessoa() {
        return $this->id_perfil_pessoa;
    }

    function getIdPerfil() {
        return $this->id_perfil;
    }

    function getIdPessoa() {
        return $this->id_pessoa;
    }

    function setIdPerfilPessoa($id_perfil_pessoa) {
        $this->id_perfil_pessoa = $id_perfil_pessoa;
    }

    function setIdPerfil($id_perfil) {
        $this->id_perfil = $id_perfil;
    }

    function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }


 
    
    
}

