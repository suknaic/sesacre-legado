<?php

class ChaCondicao {

    private $idCondicao = null;
    private $nmCondicao = null;
    private $stAtivo = null;

    /*
     * nm_condicao: Alugado ou comprado. 
     */

    function getIdCondicao() {
        return $this->idCondicao;
    }

    function getNmCondicao() {
        return $this->nmCondicao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdCondicao($idCondicao) {
        $this->idCondicao = $idCondicao;
    }

    function setNmCondicao($nmCondicao) {
        $this->nmCondicao = $nmCondicao;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

}
