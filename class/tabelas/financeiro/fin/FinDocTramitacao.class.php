<?php

class FinDocTramitacao {

    private $idDocTramitacao = null;
    private $idDocTipoRemetente = null;
    private $idDocTipoDestinatario = null;
    private $tpDocTramitacao = null;
    private $idDocumentoSituacao = null;

    function getIdDocTramitacao() {
        return $this->idDocTramitacao;
    }

    function getIdDocTipoRemetente() {
        return $this->idDocTipoRemetente;
    }

    function getIdDocTipoDestinatario() {
        return $this->idDocTipoDestinatario;
    }

    function getTpDocTramitacao() {
        return $this->tpDocTramitacao;
    }

    function getIdDocumentoSituacao() {
        return $this->idDocumentoSituacao;
    }

    function setIdDocTramitacao($idDocTramitacao) {
        $this->idDocTramitacao = $idDocTramitacao;
        return $this;
    }

    function setIdDocTipoRemetente($idDocTipoRemetente) {
        $this->idDocTipoRemetente = $idDocTipoRemetente;
        return $this;
    }

    function setIdDocTipoDestinatario($idDocTipoDestinatario) {
        $this->idDocTipoDestinatario = $idDocTipoDestinatario;
        return $this;
    }

    function setTpDocTramitacao($tpDocTramitacao) {
        $this->tpDocTramitacao = $tpDocTramitacao;
        return $this;
    }

    function setIdDocumentoSituacao($idDocumentoSituacao) {
        $this->idDocumentoSituacao = $idDocumentoSituacao;
        return $this;
    }


}

