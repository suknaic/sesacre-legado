<?php

class FinEmpenhoStatus {

    private $id_empenho_status = null;
    private $nm_empenho_status = null;
    private $st_ativo = null;
    
    function getIdEmpenhoStatus() {
        return $this->id_empenho_status;
    }

    function getNmEmpenhoStatus() {
        return $this->nm_empenho_status;
    }

    function getStStivo() {
        return $this->st_ativo;
    }

    function setIdEmpenhoStatus($id_empenho_status) {
        $this->id_empenho_status = $id_empenho_status;
        return $this;
    }

    function setNmEmpenhoStatus($nm_empenho_status) {
        $this->nm_empenho_status = $nm_empenho_status;
        return $this;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
        return $this;
    }



}