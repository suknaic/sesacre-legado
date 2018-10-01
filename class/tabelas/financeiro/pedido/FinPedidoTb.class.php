<?php

class FinPedidoTb {

    private $idPedido = null;
    private $nrPedido = null;
    private $idTipoSolicitacao = null;
    private $idFornecedor = null;
    private $idPortatia = null;
    private $idConvenio = null;
    private $idFonte = null;
    private $idProgramaTrabalho = null;
    private $idDespesaElemento = null;
    private $idDespesa = null;
    private $idTipoGasto = null;
    private $idLotacao = null;
    private $dsPedido = null;
    private $vlPedido = null;
    private $dtPedido = null;
    private $stPedido = null;
    
    private $idPedidoSituacao = null;
    
    function getIdPedidoSituacao() {
        return $this->idPedidoSituacao;
    }

    function setIdPedidoSituacao($idPedidoSituacao) {
        $this->idPedidoSituacao = $idPedidoSituacao;
        return $this;
    }
    
    function getIdPedido() {
        return $this->idPedido;
    }

    function getNrPedido() {
        return $this->nrPedido;
    }

    function getIdTipoSolicitacao() {
        return $this->idTipoSolicitacao;
    }

    function getIdFornecedor() {
        return $this->idFornecedor;
    }

    function getIdPortatia() {
        return $this->idPortatia;
    }

    function getIdConvenio() {
        return $this->idConvenio;
    }

    function getIdFonte() {
        return $this->idFonte;
    }

    function getIdProgramaTrabalho() {
        return $this->idProgramaTrabalho;
    }

    function getIdDespesaElemento() {
        return $this->idDespesaElemento;
    }

    function getIdDespesa() {
        return $this->idDespesa;
    }

    function getIdTipoGasto() {
        return $this->idTipoGasto;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getDsPedido() {
        return $this->dsPedido;
    }

    function getVlPedido() {
        return $this->vlPedido;
    }

    function getDtPedido() {
        return $this->dtPedido;
    }

    function getStPedido() {
        return $this->stPedido;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }

    function setNrPedido($nrPedido) {
        $this->nrPedido = $nrPedido;
    }

    function setIdTipoSolicitacao($idTipoSolicitacao) {
        $this->idTipoSolicitacao = $idTipoSolicitacao;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setIdPortatia($idPortatia) {
        $this->idPortatia = $idPortatia;
    }

    function setIdConvenio($idConvenio) {
        $this->idConvenio = $idConvenio;
    }

    function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;
    }

    function setIdProgramaTrabalho($idProgramaTrabalho) {
        $this->idProgramaTrabalho = $idProgramaTrabalho;
    }

    function setIdDespesaElemento($idDespesaElemento) {
        $this->idDespesaElemento = $idDespesaElemento;
    }

    function setIdDespesa($idDespesa) {
        $this->idDespesa = $idDespesa;
    }

    function setIdTipoGasto($idTipoGasto) {
        $this->idTipoGasto = $idTipoGasto;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
    }

    function setDsPedido($dsPedido) {
        $this->dsPedido = $dsPedido;
    }

    function setVlPedido($vlPedido) {
        $this->vlPedido = $vlPedido;
    }

    function setDtPedido($dtPedido) {
        $this->dtPedido = $dtPedido;
    }

    function setStPedido($stPedido) {
        $this->stPedido = $stPedido;
    }


}
