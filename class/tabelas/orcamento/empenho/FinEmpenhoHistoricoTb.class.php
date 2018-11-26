<?php

class FinEmpenhoHistoricoTb {
    
    private $idEmpenhoHistorico = null;
    private $idEmpenho = null;
    private $idPessoa = null;
    private $idLotacao = null;
    private $idDocTipoLotacao = null;
    private $idEmpenhoSituacao = null;
    private $idEmpenhoStatus = null;
    private $dhEmpenhoHistorico = null;
    private $dsEmpenhoHistorico = null;
    
    function getIdEmpenhoHistorico() {
        return $this->idEmpenhoHistorico;
    }

    function getIdEmpenho() {
        return $this->idEmpenho;
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

    function getIdEmpenhoSituacao() {
        return $this->idEmpenhoSituacao;
    }

    function getIdEmpenhoStatus() {
        return $this->idEmpenhoStatus;
    }

    function getDhEmpenhoHistorico() {
        return $this->dhEmpenhoHistorico;
    }

    function getDsEmpenhoHistorico() {
        return $this->dsEmpenhoHistorico;
    }

    function setIdEmpenhoHistorico($idEmpenhoHistorico) {
        $this->idEmpenhoHistorico = $idEmpenhoHistorico;
        return $this;
    }

    function setIdEmpenho($idEmpenho) {
        $this->idEmpenho = $idEmpenho;
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

    function setIdEmpenhoSituacao($idEmpenhoSituacao) {
        $this->idEmpenhoSituacao = $idEmpenhoSituacao;
        return $this;
    }

    function setIdEmpenhoStatus($idEmpenhoStatus) {
        $this->idEmpenhoStatus = $idEmpenhoStatus;
        return $this;
    }

    function setDhEmpenhoHistorico($dhEmpenhoHistorico) {
        $this->dhEmpenhoHistorico = $dhEmpenhoHistorico;
        return $this;
    }

    function setDsEmpenhoHistorico($dsEmpenhoHistorico) {
        $this->dsEmpenhoHistorico = $dsEmpenhoHistorico;
        return $this;
    }


}

