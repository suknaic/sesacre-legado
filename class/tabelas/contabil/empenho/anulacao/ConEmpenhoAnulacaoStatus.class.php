<?php

class ConEmpenhoAnulacaoStatus {

    private $id_empenho_anulacao_status = null;
    private $nm_empenho_anulacao_status = null;
    private $st_ativo = null;
    
    function getIdEmpenhoAnulacaoStatus() {
        return $this->id_empenho_anulacao_status;
    }

    function getNmEmpenhoAnulacaoStatus() {
        return $this->nm_empenho_anulacao_status;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdEmpenhoAnulacaoStatus($id_empenho_anulacao_status) {
        $this->id_empenho_anulacao_status = $id_empenho_anulacao_status;
        return $this;
    }

    function setNmEmpenhoAnulacaoStatus($nm_empenho_anulacao_status) {
        $this->nm_empenho_anulacao_status = $nm_empenho_anulacao_status;
        return $this;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
        return $this;
    }



}

