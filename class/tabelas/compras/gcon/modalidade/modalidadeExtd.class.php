<?php

class modalidade_extd {
    
    private $idModalidade = null;
    private $modalidade = null;
   
    function getIdModalidade() {
        return $this->idModalidade;
    }

    function getModalidade() {
        return $this->modalidade;
    }

    function setIdModalidade($idModalidade) {
        $this->idModalidade = $idModalidade;
    }

    function setModalidade($modalidade) {
        $this->modalidade = $modalidade;
    }


}