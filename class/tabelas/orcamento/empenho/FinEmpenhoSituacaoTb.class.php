<?php

class FinEmpenhoSituacaoTb {

    private $id_empenho_situacao = null;
    private $nm_empenho_situacao = null;
    private $st_ativo = null;
    
    function getIdEmpenhoSituacao() {
        return $this->id_empenho_situacao;
    }

    function getNmEmpenhoSituacao() {
        return $this->nm_empenho_situacao;
    }

    function getStStivo() {
        return $this->st_ativo;
    }

    function setIdEmpenhoSituacao($id_empenho_situacao) {
        $this->id_empenho_situacao = $id_empenho_situacao;
        return $this;
    }

    function setNmEmpenhoSituacao($nm_empenho_situacao) {
        $this->nm_empenho_situacao = $nm_empenho_situacao;
        return $this;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
        return $this;
    }

}