<?php

class FinAdministracaoAnotacaoTb {

    private $id_ordem_administracao_anotacao = null;
    private $id_ordem_administracao = null;
    private $ds_ordem_administracao_anotacao = null;
    private $dh_ordem_administracao_anotacao = null;
    private $id_pessoa = null;

    public function getIdOrdemAdministracaoAnotacao() {
        return $this->id_ordem_administracao_anotacao;
    }

    public function setIdOrdemAdministracaoAnotacao($id_ordem_administracao_anotacao) {
        $this->id_ordem_administracao_anotacao = $id_ordem_administracao_anotacao;

        return $this;
    }

    public function getIdOrdemAdministracao() {
        return $this->id_ordem_administracao;
    }

    public function setIdOrdemAdministracao($id_ordem_administracao) {
        $this->id_ordem_administracao = $id_ordem_administracao;

        return $this;
    }

    public function getDsOrdemAdministracaoAnotacao() {
        return $this->ds_ordem_administracao_anotacao;
    }

    public function setDsOrdemAdministracaoAnotacao($ds_ordem_administracao_anotacao) {
        $this->ds_ordem_administracao_anotacao = $ds_ordem_administracao_anotacao;

        return $this;
    }

    public function getDhOrdemAdministracaoAnotacao() {
        return $this->dh_ordem_administracao_anotacao;
    }

    public function setDhOrdemAdministracaoAnotacao($dh_ordem_administracao_anotacao) {
        $this->dh_ordem_administracao_anotacao = $dh_ordem_administracao_anotacao;

        return $this;
    }

    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

}
