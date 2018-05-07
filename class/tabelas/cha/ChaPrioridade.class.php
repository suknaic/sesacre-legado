<?php

class ChaPrioridade {
    
    private $idPrioridade = null;
    private $nmPrioridade = null;
    private $csPrioridade = null;
    private $stAtivo = null;
    
    /**
     * nm_prioridade: Crítico, Alto, Médio, Baixo
     * cs_prioridade é a Condição da prioridade: Se for uma upa com a máquina de raio-x quebrada a prioridade é crítica
     */
    function getIdPrioridade() {
        return $this->idPrioridade;
    }

    function getNmPrioridade() {
        return $this->nmPrioridade;
    }

    function getCsPrioridade() {
        return $this->csPrioridade;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdPrioridade($idPrioridade) {
        $this->idPrioridade = $idPrioridade;
    }

    function setNmPrioridade($nmPrioridade) {
        $this->nmPrioridade = $nmPrioridade;
    }

    function setCsPrioridade($csPrioridade) {
        $this->csPrioridade = $csPrioridade;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }
    
}
