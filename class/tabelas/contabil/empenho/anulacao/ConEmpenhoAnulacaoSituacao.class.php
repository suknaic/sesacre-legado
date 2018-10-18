<?php

class ConEmpenhoAnulacaoSituacao {

    private $id_empenho_anulacao_situacao = null;
    private $nm_empenho_anulacao_situacao = null;
    private $st_ativo = null;
    
    function getIdEmpenhoAnulacaoSituacao() {
        return $this->id_empenho_anulacao_situacao;
    }

    function getNmEmpenhoAnulacaoSituacao() {
        return $this->nm_empenho_anulacao_situacao;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdEmpenhoAnulacaoSituacao($id_empenho_anulacao_situacao) {
        $this->id_empenho_anulacao_situacao = $id_empenho_anulacao_situacao;
        return $this;
    }

    function setNmEmpenhoAnulacaoSituacao($nm_empenho_anulacao_situacao) {
        $this->nm_empenho_anulacao_situacao = $nm_empenho_anulacao_situacao;
        return $this;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
        return $this;
    }



}

