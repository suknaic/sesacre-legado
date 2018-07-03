<?php

class FinTipoAdministracao {
    private $idTipoAdministracao = null;
    private $nmTipoAdministracao = null;
    private $stAtivo = null;
    
    function __construct(string $nmTipoAdministracao = "") {
        $this->nmTipoAdministracao = $nmTipoAdministracao;
    }
    
    function getIdTipoAdministracao() {
        return $this->idTipoAdministracao;
    }

    function getNmTipoAdministracao() {
        return $this->nmTipoAdministracao;
    }

    function setIdTipoAdministracao($idTipoAdministracao) {
        $this->idTipoAdministracao = $idTipoAdministracao;
    }

    function setNmTipoAdministracao($nmTipoAdministracao) {
        $this->nmTipoAdministracao = $nmTipoAdministracao;
    }
    
    function getStAtivo() {
        return $this->stAtivo;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }




}

