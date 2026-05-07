<?php

class PlaDiretriz{
    
    private $id_diretriz = null;
    private $id_eixo = null;
    private $nm_diretriz = null;
    private $nr_ordem = null;    
    private $st_ativo = null;
   
    function getIdDiretriz() {
        return $this->id_diretriz;
    }

    function getIdEixo() {
        return $this->id_eixo;
    }

    function getNmDiretriz() {
        return $this->nm_diretriz;
    }

    function getNrOrdem() {
        return $this->nr_ordem;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdDiretriz($id_diretriz) {
        $this->id_diretriz = $id_diretriz;
    }

    function setIdEixo($id_eixo) {
        $this->id_eixo = $id_eixo;
    }

    function setNmDiretriz($nm_diretriz) {
        $this->nm_diretriz = $nm_diretriz;
    }

    function setNrOrdem($nr_ordem) {
        $this->nr_ordem = $nr_ordem;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }
               
}
