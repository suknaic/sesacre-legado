<?php

class FinEmpenhoAnotacaoTb {
    private $id_empenho_anotacao = null;
    private $id_empenho = null;
    private $id_pessoa = null;
    private $ds_empenho_anotacao = null;
    private $dh_empenho_anotacao = null;
    
    function getIdEmpenhoAnotacao() {
        return $this->id_empenho_anotacao;
    }

    function getIdEmpenho() {
        return $this->id_empenho;
    }

    function getIdPessoa() {
        return $this->id_pessoa;
    }

    function getDsEmpenhoAnotacao() {
        return $this->ds_empenho_anotacao;
    }

    function getDhEmpenhoAnotacao() {
        return $this->dh_empenho_anotacao;
    }

    function setIdEmpenhoAnotacao($id_empenho_anotacao) {
        $this->id_empenho_anotacao = $id_empenho_anotacao;
        return $this;
    }

    function setIdEmpenho($id_empenho) {
        $this->id_empenho = $id_empenho;
        return $this;
    }

    function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
        return $this;
    }

    function setDsEmpenhoAnotacao($ds_empenho_anotacao) {
        $this->ds_empenho_anotacao = $ds_empenho_anotacao;
        return $this;
    }

    function setDhEmpenhoAnotacao($dh_empenho_anotacao) {
        $this->dh_empenho_anotacao = $dh_empenho_anotacao;
        return $this;
    }


}

