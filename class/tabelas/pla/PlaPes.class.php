<?php

class PlaPes{
    
    private $id_pes = null;
    private $nm_pes = null;    
    private $aa_vigencia_inicio = null;
    private $aa_vigencia_fim = null;
    private $st_ativo = null;

    function getIdPes() {
        return $this->id_pes;
    }

    function getNmPes() {
        return $this->nm_pes;
    }

    function getAaVigenciaInicio() {
        return $this->aa_vigencia_inicio;
    }

    function getAaVigenciaFim() {
        return $this->aa_vigencia_fim;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdPes($id_pes) {
        $this->id_pes = $id_pes;
    }

    function setNmPes($nm_pes) {
        $this->nm_pes = $nm_pes;
    }

    function setAaVigenciaInicio($aa_vigencia_inicio) {
        $this->aa_vigencia_inicio = $aa_vigencia_inicio;
    }

    function setAaVigenciaFim($aa_vigencia_fim) {
        $this->aa_vigencia_fim = $aa_vigencia_fim;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }




    
}
