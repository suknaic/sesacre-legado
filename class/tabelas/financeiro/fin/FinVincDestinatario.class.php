<?php

class FinVincDestinatario {

    private $idVincDestinatario = null;
    private $idDocTipoDestinatario = null;
    private $idLotacao = null;
    private $idPessoa = null;
    
    function getIdVincDestinatario() {
        return $this->idVincDestinatario;
    }

    function getIdDocTipoDestinatario() {
        return $this->idDocTipoDestinatario;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }
    
    function getIdPessoa(){
        return $this->idPessoa;
    }

    function setIdVincDestinatario($idVincDestinatario) {
        $this->idVincDestinatario = $idVincDestinatario;
        return $this;
    }

    function setIdDocTipoDestinatario($idDocTipoDestinatario) {
        $this->idDocTipoDestinatario = $idDocTipoDestinatario;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }
    
    function setIdPessoa($idPessoa){
        $this->idPessoa = $idPessoa;
        return $this;
    }


}

