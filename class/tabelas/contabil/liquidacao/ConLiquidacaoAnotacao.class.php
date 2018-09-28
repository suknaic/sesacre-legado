<?php

class ConLiquidacaoAnotacao {

    private $id_liquidacao_anotacao = null;
    private $id_pessoa = null;
    private $id_liquidacao = null;
    private $dh_liquidacao_anotacao = null;
    private $ds_liquidacao_anotacao = null;
    
    function getIdLiquidacaoAnotacao() {
        return $this->id_liquidacao_anotacao;
    }

    function getIdPessoa() {
        return $this->id_pessoa;
    }

    function getIdLiquidacao() {
        return $this->id_liquidacao;
    }

    function getDhLiquidacaoAnotacao() {
        return $this->dh_liquidacao_anotacao;
    }

    function getDsLiquidacaoAnotacao() {
        return $this->ds_liquidacao_anotacao;
    }

    function setIdLiquidacaoAnotacao($id_liquidacao_anotacao) {
        $this->id_liquidacao_anotacao = $id_liquidacao_anotacao;
        return $this;
    }

    function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
        return $this;
    }

    function setIdLiquidacao($id_liquidacao) {
        $this->id_liquidacao = $id_liquidacao;
        return $this;
    }

    function setDhLiquidacaoAnotacao($dh_liquidacao_anotacao) {
        $this->dh_liquidacao_anotacao = $dh_liquidacao_anotacao;
        return $this;
    }

    function setDsLiquidacaoAnotacao($ds_liquidacao_anotacao) {
        $this->ds_liquidacao_anotacao = $ds_liquidacao_anotacao;
        return $this;
    }



}

