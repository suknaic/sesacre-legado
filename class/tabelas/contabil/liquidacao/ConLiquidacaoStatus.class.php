<?php


class ConLiquidacaoStatus {
    private $id_liquidacao_status = null;
    private $nm_liquidacao_status = null;
    private $st_ativo = null;
    
    function getIdLiquidacaoStatus() {
        return $this->id_liquidacao_status;
    }

    function getNmLiquidacaoStatus() {
        return $this->nm_liquidacao_status;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdLiquidacaoStatus($id_liquidacao_status) {
        $this->id_liquidacao_status = $id_liquidacao_status;
        return $this;
    }

    function setNmLiquidacaoStatus($nm_liquidacao_status) {
        $this->nm_liquidacao_status = $nm_liquidacao_status;
        return $this;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
        return $this;
    }


}

