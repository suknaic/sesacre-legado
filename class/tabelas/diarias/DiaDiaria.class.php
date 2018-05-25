<?php

class DiaDiaria {
    
    private $idDiaria            = null;
    private $idTipo              = null;
    
    private $idPessoaProponente = null;
    private $idFuncaoProponente = null;
    private $idLotacaoProponente = null;
    
    private $idPessoaProposto   = null;
    private $idFuncaoProposto   = null;
    private $idLotacaoProposto  = null;
    
    private $dsServicoExecutado = null;
    private $dsLocaisExecutado  = null;
    private $dsObs               = null;
    
    private $dtCriacao = null;
    private $dhDiaria  = null;
    
    private $idPessoaSolicitante = null;
    private $flRetorno           = null;
    private $idPedido            = null;
    private $idDiariaPai         = null;
    private $idRelatorio         = null;
    private $stEstagio           = null;
    private $stAtivo             = null;
    private $nrProtocolo         = null;
    
    function getIdDiaria() {
        return $this->idDiaria;
    }

    function getIdTipo() {
        return $this->idTipo;
    }

    function getIdPessoaProponente() {
        return $this->idPessoaProponente;
    }

    function getIdFuncaoProponente() {
        return $this->idFuncaoProponente;
    }

    function getIdLotacaoProponente() {
        return $this->idLotacaoProponente;
    }

    function getIdPessoaProposto() {
        return $this->idPessoaProposto;
    }

    function getIdFuncaoProposto() {
        return $this->idFuncaoProposto;
    }

    function getIdLotacaoProposto() {
        return $this->idLotacaoProposto;
    }

    function getDsServicoExecutado() {
        return $this->dsServicoExecutado;
    }

    function getDsLocaisExecutado() {
        return $this->dsLocaisExecutado;
    }

    function getDsObs() {
        return $this->dsObs;
    }

    function getDtCriacao() {
        return $this->dtCriacao;
    }

    function getDhDiaria() {
        return $this->dhDiaria;
    }

    function getIdPessoaSolicitante() {
        return $this->idPessoaSolicitante;
    }

    function getFlRetorno() {
        return $this->flRetorno;
    }

    function getIdPedido() {
        return $this->idPedido;
    }

    function getIdDiariaPai() {
        return $this->idDiariaPai;
    }

    function getIdRelatorio() {
        return $this->idRelatorio;
    }

    function getStEstagio() {
        return $this->stEstagio;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdDiaria($idDiaria) {
        $this->idDiaria = $idDiaria;
    }

    function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }
    
    function getNrProtocolo() {
        return $this->nrProtocolo;
    }

    function setNrProtocolo($nrProtocolo) {
        $this->nrProtocolo = $nrProtocolo;
    }

    
    function setIdPessoaProponente($idPessoaProponente) {
        $this->idPessoaProponente = $idPessoaProponente;
    }

    function setIdFuncaoProponente($idFuncaoProponente) {
        $this->idFuncaoProponente = $idFuncaoProponente;
    }

    function setIdLotacaoProponente($idLotacaoProponente) {
        $this->idLotacaoProponente = $idLotacaoProponente;
    }

    function setIdPessoaProposto($idPessoaProposto) {
        $this->idPessoaProposto = $idPessoaProposto;
    }

    function setIdFuncaoProposto($idFuncaoProposto) {
        $this->idFuncaoProposto = $idFuncaoProposto;
    }

    function setIdLotacaoProposto($idLotacaoProposto) {
        $this->idLotacaoProposto = $idLotacaoProposto;
    }

    function setDsServicoExecutado($dsServicoExecutado) {
        $this->dsServicoExecutado = $dsServicoExecutado;
    }

    function setDsLocaisExecutado($dsLocaisExecutado) {
        $this->dsLocaisExecutado = $dsLocaisExecutado;
    }

    function setDsObs($dsObs) {
        $this->dsObs = $dsObs;
    }

    function setDtCriacao($dtCriacao) {
        $this->dtCriacao = $dtCriacao;
    }

    function setDhDiaria($dhDiaria) {
        $this->dhDiaria = $dhDiaria;
    }

    function setIdPessoaSolicitante($idPessoaSolicitante) {
        $this->idPessoaSolicitante = $idPessoaSolicitante;
    }

    function setFlRetorno($flRetorno) {
        $this->flRetorno = $flRetorno;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }

    function setIdDiariaPai($idDiariaPai) {
        $this->idDiariaPai = $idDiariaPai;
    }

    function setIdRelatorio($idRelatorio) {
        $this->idRelatorio = $idRelatorio;
    }

    function setStEstagio($stEstagio) {
        $this->stEstagio = $stEstagio;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }


    
}

