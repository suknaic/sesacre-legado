<?php

class SesVincularTramitacao {

    private $idVincularTramitacao = null;
    private $idTramitacao = null;
    private $idPessoa = null;
    private $idLotacao = null;
    private $idDocTipoLotacao = null;
    
    function getIdVincularTramitacao() {
        return $this->idVincularTramitacao;
    }

    function getIdTramitacao() {
        return $this->idTramitacao;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function setIdVincularTramitacao($idVincularTramitacao) {
        $this->idVincularTramitacao = $idVincularTramitacao;
        return $this;
    }

    function setIdTramitacao($idTramitacao) {
        $this->idTramitacao = $idTramitacao;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }



}

