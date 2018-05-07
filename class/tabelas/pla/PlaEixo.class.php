<?php

class PlaEixo{
    
    private $id_eixo = null;
    private $id_pes = null;    
    private $nm_eixo = null;    
    private $nr_ordem = null;    
    private $st_ativo = null;

    function getIdEixo() {
        return $this->id_eixo;
    }

    function getIdPes() {
        return $this->id_pes;
    }
   
    function getNmEixo() {
        return $this->nm_eixo;
    }

    function getNrOrdem() {
        return $this->nr_ordem;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdEixo($id_eixo) {
        $this->id_eixo = $id_eixo;
    }

    function setIdPes($id_pes) {
        $this->id_pes = $id_pes;
    }
   
    function setNmEixo($nm_eixo) {
        $this->nm_eixo = $nm_eixo;
    }

    function setNrOrdem($nr_ordem) {
        $this->nr_ordem = $nr_ordem;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }   
}
