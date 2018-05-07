<?php

class FinDespesa {

    private $id_despesa = null;
    private $id_despesa_categoria = null;
    private $id_despesa_grupo = null;
    private $id_despesa_modalidade = null;
    private $id_despesa_elemento = null;
    private $id_despesa_subelemento = null;


    /**
     * Get the value of Id Despesa
     *
     * @return mixed
     */
    public function getIdDespesa()
    {
        return $this->id_despesa;
    }

    /**
     * Set the value of Id Despesa
     *
     * @param mixed id_despesa
     *
     * @return self
     */
    public function setIdDespesa($id_despesa)
    {
        $this->id_despesa = $id_despesa;

        return $this;
    }

    /**
     * Get the value of Id Despesa Categoria
     *
     * @return mixed
     */
    public function getIdDespesaCategoria()
    {
        return $this->id_despesa_categoria;
    }

    /**
     * Set the value of Id Despesa Categoria
     *
     * @param mixed id_despesa_categoria
     *
     * @return self
     */
    public function setIdDespesaCategoria($id_despesa_categoria)
    {
        $this->id_despesa_categoria = $id_despesa_categoria;

        return $this;
    }

    /**
     * Get the value of Id Despesa Grupo
     *
     * @return mixed
     */
    public function getIdDespesaGrupo()
    {
        return $this->id_despesa_grupo;
    }

    /**
     * Set the value of Id Despesa Grupo
     *
     * @param mixed id_despesa_grupo
     *
     * @return self
     */
    public function setIdDespesaGrupo($id_despesa_grupo)
    {
        $this->id_despesa_grupo = $id_despesa_grupo;

        return $this;
    }

    /**
     * Get the value of Id Despesa Modalidade
     *
     * @return mixed
     */
    public function getIdDespesaModalidade()
    {
        return $this->id_despesa_modalidade;
    }

    /**
     * Set the value of Id Despesa Modalidade
     *
     * @param mixed id_despesa_modalidade
     *
     * @return self
     */
    public function setIdDespesaModalidade($id_despesa_modalidade)
    {
        $this->id_despesa_modalidade = $id_despesa_modalidade;

        return $this;
    }

    /**
     * Get the value of Id Despesa Elemento
     *
     * @return mixed
     */
    public function getIdDespesaElemento()
    {
        return $this->id_despesa_elemento;
    }

    /**
     * Set the value of Id Despesa Elemento
     *
     * @param mixed id_despesa_elemento
     *
     * @return self
     */
    public function setIdDespesaElemento($id_despesa_elemento)
    {
        $this->id_despesa_elemento = $id_despesa_elemento;

        return $this;
    }

    /**
     * Get the value of Id Despesa Subelemento
     *
     * @return mixed
     */
    public function getIdDespesaSubelemento()
    {
        return $this->id_despesa_subelemento;
    }

    /**
     * Set the value of Id Despesa Subelemento
     *
     * @param mixed id_despesa_subelemento
     *
     * @return self
     */
    public function setIdDespesaSubelemento($id_despesa_subelemento)
    {
        $this->id_despesa_subelemento = $id_despesa_subelemento;

        return $this;
    }

}
