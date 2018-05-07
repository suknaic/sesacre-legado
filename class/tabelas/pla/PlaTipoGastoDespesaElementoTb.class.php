<?php

class PlatipoGastoDespesaElementoTb {

    private $id_tipo_gasto_despesa_elemento = null;
    private $id_tipo_gasto = null;
    private $id_despesa_elemento = null;
    private $st_ativo = null;

    /**
     * @return mixed
     */
    public function getIdTipoGastoDespesaElemento() {
        return $this->id_tipo_gasto_despesa_elemento;
    }

    /**
     * @param mixed $id_tipo_gasto_despesa_elemento
     *
     * @return self
     */
    public function setIdTipoGastoDespesaElemento($id_tipo_gasto_despesa_elemento) {
        $this->id_tipo_gasto_despesa_elemento = $id_tipo_gasto_despesa_elemento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdTipoGasto() {
        return $this->id_tipo_gasto;
    }

    /**
     * @param mixed $id_tipo_gasto
     *
     * @return self
     */
    public function setIdTipoGasto($id_tipo_gasto) {
        $this->id_tipo_gasto = $id_tipo_gasto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdDespesaElemento() {
        return $this->id_despesa_elemento;
    }

    /**
     * @param mixed $id_despesa_elemento
     *
     * @return self
     */
    public function setIdDespesaElemento($id_despesa_elemento) {
        $this->id_despesa_elemento = $id_despesa_elemento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStAtivo() {
        return $this->st_ativo;
    }

    /**
     * @param mixed $st_ativo
     *
     * @return self
     */
    public function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;

        return $this;
    }

}
