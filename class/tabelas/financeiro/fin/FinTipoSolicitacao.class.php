<?php

class FinTipoSolicitacao {
    private $idTipoSolicitacao = null;
    private $nmTipoSolicitacao = null;
    
    function __construct(string $nmTipoSolicitacao = "") {
        $this->nmTipoSolicitacao = $nmTipoSolicitacao;
    }

    
    function getIdTipoSolicitacao() {
        return $this->idTipoSolicitacao;
    }

    function getNmTipoSolicitacao() {
        return $this->nmTipoSolicitacao;
    }

    function setIdTipoSolicitacao($idTipoSolicitacao) {
        $this->idTipoSolicitacao = $idTipoSolicitacao;
    }

    function setNmTipoSolicitacao($nmTipoSolicitacao) {
        $this->nmTipoSolicitacao = $nmTipoSolicitacao;
    }


}

