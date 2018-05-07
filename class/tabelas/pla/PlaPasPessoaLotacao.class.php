<?php

class PlaPasPessoaLotacao{
    
    private $id_pas_pessoa_lotacao = null;
    private $id_pessoa = null;
    private $id_lotacao = null;
    
    function getIdPasPessoaLotacao() {
        return $this->id_pas_pessoa_lotacao;
    }

    function getIdPessoa() {
        return $this->id_pessoa;
    }

    function getIdLotacao() {
        return $this->id_lotacao;
    }

    function setIdPasPessoaLotacao($id_pas_pessoa_lotacao) {
        $this->id_pas_pessoa_lotacao = $id_pas_pessoa_lotacao;
    }

    function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;
    }

}

