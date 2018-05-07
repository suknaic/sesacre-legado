<?php

class ChaStatus {

    private $idStatus = null;
    private $nmStatus = null;
    private $stAtivo = null;

    /**
     * nm_status: Finalizado, Cancelado, Aguardando Atendimento, Pausado, Conferência de Equipe
     *
     */
    
    function getIdStatus() {
        return $this->idStatus;
    }

    function getNmStatus() {
        return $this->nmStatus;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdStatus($idStatus) {
        $this->idStatus = $idStatus;
    }

    function setNmStatus($nmStatus) {
        $this->nmStatus = $nmStatus;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

}
