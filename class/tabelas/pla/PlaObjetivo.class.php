<?php

class PlaObjetivo{
    
    private $id_objetivo = null;
    private $id_diretriz = null;    
    private $nm_objetivo = null;
    private $nr_ordem = null;    
    private $st_ativo = null;
    
    function getIdObjetivo() {
        return $this->id_objetivo;
    }

    function getIdDiretriz() {
        return $this->id_diretriz;
    }

    function getNmObjetivo() {
        return $this->nm_objetivo;
    }

    function getNrOrdem() {
        return $this->nr_ordem;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdObjetivo($id_objetivo) {
        $this->id_objetivo = $id_objetivo;
    }

    function setIdDiretriz($id_diretriz) {
        $this->id_diretriz = $id_diretriz;
    }

    function setNmObjetivo($nm_objetivo) {
        $this->nm_objetivo = $nm_objetivo;
    }

    function setNrOrdem($nr_ordem) {
        $this->nr_ordem = $nr_ordem;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }


    
               
}
