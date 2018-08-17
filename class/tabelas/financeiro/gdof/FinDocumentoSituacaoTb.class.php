<?php


class FinDocumentoSituacaoTb {

    private $idDocumentoSituacao = null;
    private $nmSituacao = null;
    private $stAtivo = null;
    
    function getIdDocumentoSituacao() {
        return $this->idDocumentoSituacao;
    }

    function getNmSituacao() {
        return $this->nmSituacao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdDocumentoSituacao($idDocumentoSituacao) {
        $this->idDocumentoSituacao = $idDocumentoSituacao;
        return $this;
    }

    function setNmSituacao($nmSituacao) {
        $this->nmSituacao = $nmSituacao;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }

}
