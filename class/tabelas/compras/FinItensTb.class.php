<?php

class FinItensTb {

    //atributos fin_cont_itens
    private $idContItens = null;
    private $nrItem = null;
    private $nrLote = null;
    private $nmMarca = null;
    private $nmModelo = null;
    private $qtItens = null;
    private $vlItens = null;
    private $pcDesconto = null;
    private $idMaterial = null;
    private $idFornecedor = null;
    private $idContItensAlt = null;
    private $cdDescMaterial = null;
    private $descItem = null;
    private $idUnidadeMedida = null;
    private $flValorVariavel = null;
    private $idContItensAditivo = null;
    private $qtItensAux = null;

    function getIdContItens() {
        return $this->idContItens;
    }

    function getNrItem() {
        return $this->nrItem;
    }

    function getNrLote() {
        return $this->nrLote;
    }

    function getNmMarca() {
        return $this->nmMarca;
    }

    function getNmModelo() {
        return $this->nmModelo;
    }

    function getQtItens() {
        return $this->qtItens;
    }

    function getVlItens() {
        return $this->vlItens;
    }

    function getPcDesconto() {
        return $this->pcDesconto;
    }

    function getIdMaterial() {
        return $this->idMaterial;
    }

    function getIdFornecedor() {
        return $this->idFornecedor;
    }

    function getIdContItensAlt() {
        return $this->idContItensAlt;
    }

    function getCdDescMaterial() {
        return $this->cdDescMaterial;
    }

    function getDescItem() {
        return $this->descItem;
    }

    function getIdUnidadeMedida() {
        return $this->idUnidadeMedida;
    }

    function setIdContItens($idContItens) {
        $this->idContItens = $idContItens;
    }

    function setNrItem($nrItem) {
        $this->nrItem = $nrItem;
    }

    function setNrLote($nrLote) {
        $this->nrLote = $nrLote;
    }

    function setNmMarca($nmMarca) {
        $this->nmMarca = $nmMarca;
    }

    function setNmModelo($nmModelo) {
        $this->nmModelo = $nmModelo;
    }

    function setQtItens($qtItens) {
        $this->qtItens = $qtItens;
    }

    function setVlItens($vlItens) {
        $this->vlItens = $vlItens;
    }

    function setPcDesconto($pcDesconto) {
        $this->pcDesconto = $pcDesconto;
    }

    function setIdMaterial($idMaterial) {
        $this->idMaterial = $idMaterial;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setIdContItensAlt($idContItensAlt) {
        $this->idContItensAlt = $idContItensAlt;
    }

    function setCdDescMaterial($cdDescMaterial) {
        $this->cdDescMaterial = $cdDescMaterial;
    }

    function setDescItem($descItem) {
        $this->descItem = $descItem;
    }

    function setIdUnidadeMedida($idUnidadeMedida) {
        $this->idUnidadeMedida = $idUnidadeMedida;
    }
    
    function getFlValorVariavel() {
        return $this->flValorVariavel;
    }

    function setFlValorVariavel($flValorVariavel) {
        $this->flValorVariavel = $flValorVariavel;
    }
    
    function getIdContItensAditivo() {
        return $this->idContItensAditivo;
    }

    function setIdContItensAditivo($idContItensAditivo) {
        $this->idContItensAditivo = $idContItensAditivo;
        return $this;
    }
    
    function getQtItensAux() {
        return $this->qtItensAux;
    }

    function setQtItensAux($qtItensAux) {
        $this->qtItensAux = $qtItensAux;
        return $this;
    }



}
