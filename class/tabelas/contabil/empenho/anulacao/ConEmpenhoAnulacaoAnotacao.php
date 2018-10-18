<?php

class ConEmpenhoAnulacaoAnotacao {

    private $id_empenho_anulacao_anotacao = null;
    private $id_pessoa = null;
    private $id_empenho_anulacao = null;
    private $ds_empenho_anulacao_anotacao = null;
    private $dh_empenho_anulacao_anotacao = null;
    
    function getIdEmpenhoAnulacaoAnotacao() {
        return $this->id_empenho_anulacao_anotacao;
    }

    function getIdPessoa() {
        return $this->id_pessoa;
    }

    function getIdEmpenhoAnulacao() {
        return $this->id_empenho_anulacao;
    }

    function getDsEmpenhoAnulacaoAnotacao() {
        return $this->ds_empenho_anulacao_anotacao;
    }

    function getDhEmpenhoAnulacaoAnotacao() {
        return $this->dh_empenho_anulacao_anotacao;
    }

    function setIdEmpenhoAnulacaoAnotacao($id_empenho_anulacao_anotacao) {
        $this->id_empenho_anulacao_anotacao = $id_empenho_anulacao_anotacao;
        return $this;
    }

    function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
        return $this;
    }

    function setIdEmpenhoAnulacao($id_empenho_anulacao) {
        $this->id_empenho_anulacao = $id_empenho_anulacao;
        return $this;
    }

    function setDsEmpenhoAnulacaoAnotacao($ds_empenho_anulacao_anotacao) {
        $this->ds_empenho_anulacao_anotacao = $ds_empenho_anulacao_anotacao;
        return $this;
    }

    function setDhEmpenhoAnulacaoAnotacao($dh_empenho_anulacao_anotacao) {
        $this->dh_empenho_anulacao_anotacao = $dh_empenho_anulacao_anotacao;
        return $this;
    }



}

