<?php

class FinAdministracaoSolicitacao {
    private $idAdministracaoSolicitacao = null;
    private $idTipoAdministracao = null;
    private $idTipoSolicitacao = null;
    
    function __construct(int $idTipoAdministracao = 0, int $idTipoSolicitacao = 0) {
        $this->idTipoAdministracao = $idTipoAdministracao;
        $this->idTipoSolicitacao = $idTipoSolicitacao;
    }
    
    function getIdAdministracaoSolicitacao() {
        return $this->idAdministracaoSolicitacao;
    }

    function getIdTipoAdministracao() {
        return $this->idTipoAdministracao;
    }

    function getIdTipoSolicitacao() {
        return $this->idTipoSolicitacao;
    }

    function setIdAdministracaoSolicitacao($idAdministracaoSolicitacao) {
        $this->idAdministracaoSolicitacao = $idAdministracaoSolicitacao;
    }

    function setIdTipoAdministracao($idTipoAdministracao) {
        $this->idTipoAdministracao = $idTipoAdministracao;
    }

    function setIdTipoSolicitacao($idTipoSolicitacao) {
        $this->idTipoSolicitacao = $idTipoSolicitacao;
    }


}
