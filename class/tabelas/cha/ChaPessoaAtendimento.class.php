<?php

class ChaPessoaAtendimento {
    
    private $id_pessoa_atendimento = null;
    private $id_chamado = null;
    private $id_pessoa = null;
    
    function getId_pessoa_atendimento() {
        return $this->id_pessoa_atendimento;
    }

    function getId_chamado() {
        return $this->id_chamado;
    }

    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function setId_pessoa_atendimento($id_pessoa_atendimento) {
        $this->id_pessoa_atendimento = $id_pessoa_atendimento;
    }

    function setId_chamado($id_chamado) {
        $this->id_chamado = $id_chamado;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

}

