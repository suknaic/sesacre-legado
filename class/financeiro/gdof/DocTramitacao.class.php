<?php

class DocTramitacao {

    private $idDocTramitacao = null;
    private $idDocumentoFiscal = null;
    private $idPessoa = null;
    private $dhDocTramitacao = null;
    private $dsDocTramitacao = null;
    private $idDocOrigem = null;
    private $idDocDestino = null;
    private $idDocumentoSituacao = null;
    
    function getIdDocTramitacao() {
        return $this->idDocTramitacao;
    }

    function getIdDocumentoFiscal() {
        return $this->idDocumentoFiscal;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getDhDocTramitacao() {
        return $this->dhDocTramitacao;
    }

    function getDsDocTramitacao() {
        return $this->dsDocTramitacao;
    }

    function getIdDocOrigem() {
        return $this->idDocOrigem;
    }

    function getIdDocDestino() {
        return $this->idDocDestino;
    }

    function getIdDocumentoSituacao() {
        return $this->idDocumentoSituacao;
    }

    function setIdDocTramitacao($idDocTramitacao) {
        $this->idDocTramitacao = $idDocTramitacao;
        return $this;
    }

    function setIdDocumentoFiscal($idDocumentoFiscal) {
        $this->idDocumentoFiscal = $idDocumentoFiscal;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setDhDocTramitacao($dhDocTramitacao) {
        $this->dhDocTramitacao = $dhDocTramitacao;
        return $this;
    }

    function setDsDocTramitacao($dsDocTramitacao) {
        $this->dsDocTramitacao = $dsDocTramitacao;
        return $this;
    }

    function setIdDocOrigem($idDocOrigem) {
        $this->idDocOrigem = $idDocOrigem;
        return $this;
    }

    function setIdDocDestino($idDocDestino) {
        $this->idDocDestino = $idDocDestino;
        return $this;
    }

    function setIdDocumentoSituacao($idDocumentoSituacao) {
        $this->idDocumentoSituacao = $idDocumentoSituacao;
        return $this;
    }
}

