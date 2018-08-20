<?php

class FinDocLotacao {

    private $idDocLotacao = null;
    private $idDocTipoLotacao = null;
    private $idLotacao = null;
    private $stAtivo = null;

    function getIdDocLotacao() {
        return $this->idDocLotacao;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setIdDocLotacao($idDocLotacao) {
        $this->idDocLotacao = $idDocLotacao;
        return $this;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }
    
    function getStAtivo() {
        return $this->stAtivo;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }


}

