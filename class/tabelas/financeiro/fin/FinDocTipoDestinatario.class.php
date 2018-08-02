<?php

class FinDocTipoDestinatario {

    private $idDocTipoDestinatario = null;
    private $nmDocTipoDestinatario = null;
    private $st_ativo = '1';
    
    function getIdDocTipoDestinatario() {
        return $this->idDocTipoDestinatario;
    }

    function getNmDocTipoDestinatario() {
        return $this->nmDocTipoDestinatario;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setIdDocTipoDestinatario($idDocTipoDestinatario) {
        $this->idDocTipoDestinatario = $idDocTipoDestinatario;
        return $this;
    }

    function setNmDocTipoDestinatario($nmDocTipoDestinatario) {
        $this->nmDocTipoDestinatario = $nmDocTipoDestinatario;
        return $this;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
        return $this;
    }



}

