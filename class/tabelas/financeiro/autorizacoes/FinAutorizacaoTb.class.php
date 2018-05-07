<?php

class FinAutorizacoesTb {

    private $id_autorizacao = null;
    private $id_pedido = null;
    private $st_nivel = null;
    private $dt_autorizacao = null;
    private $ds_autorizacao = null;
    private $id_pessoa = null;

    /**
     * @return mixed
     */
    public function getIdAutorizacao() {
        return $this->id_autorizacao;
    }

    /**
     * @param mixed $id_autorizacao
     *
     * @return self
     */
    public function setIdAutorizacao($id_autorizacao) {
        $this->id_autorizacao = $id_autorizacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPedido() {
        return $this->id_pedido;
    }

    /**
     * @param mixed $id_pedido
     *
     * @return self
     */
    public function setIdPedido($id_pedido) {
        $this->id_pedido = $id_pedido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStNivel() {
        return $this->st_nivel;
    }

    /**
     * @param mixed $st_nivel
     *
     * @return self
     */
    public function setStNivel($st_nivel) {
        $this->st_nivel = $st_nivel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtAutorizacao() {
        return $this->dt_autorizacao;
    }

    /**
     * @param mixed $dt_autorizacao
     *
     * @return self
     */
    public function setDtAutorizacao($dt_autorizacao) {
        $this->dt_autorizacao = $dt_autorizacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsAutorizacao() {
        return $this->ds_autorizacao;
    }

    /**
     * @param mixed $ds_autorizacao
     *
     * @return self
     */
    public function setDsAutorizacao($ds_autorizacao) {
        $this->ds_autorizacao = $ds_autorizacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    /**
     * @param mixed $id_pessoa
     *
     * @return self
     */
    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

}
