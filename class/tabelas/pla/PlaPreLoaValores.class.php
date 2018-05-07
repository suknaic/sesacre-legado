<?php

class PlaPreLoaValores{

    private $id_pre_loa_valores = null;
    private $id_pre_loa = null;
    private $id_programa_trabalho = null;
    private $id_despesa_elemento = null;
    private $id_fonte = null;
    private $vl_pre_loa_valores = null;
            

    /**
     * Get the value of Id Pre Loa Valores
     *
     * @return mixed
     */
    public function getIdPreLoaValores()
    {
        return $this->id_pre_loa_valores;
    }

    /**
     * Set the value of Id Pre Loa Valores
     *
     * @param mixed id_pre_loa_valores
     *
     * @return self
     */
    public function setIdPreLoaValores($id_pre_loa_valores)
    {
        $this->id_pre_loa_valores = $id_pre_loa_valores;

        return $this;
    }

    /**
     * Get the value of Id Pre Loa
     *
     * @return mixed
     */
    public function getIdPreLoa()
    {
        return $this->id_pre_loa;
    }

    /**
     * Set the value of Id Pre Loa
     *
     * @param mixed id_pre_loa
     *
     * @return self
     */
    public function setIdPreLoa($id_pre_loa)
    {
        $this->id_pre_loa = $id_pre_loa;

        return $this;
    }

    /**
     * Get the value of Id Programa Trabalho
     *
     * @return mixed
     */
    public function getIdProgramaTrabalho()
    {
        return $this->id_programa_trabalho;
    }

    /**
     * Set the value of Id Programa Trabalho
     *
     * @param mixed id_programa_trabalho
     *
     * @return self
     */
    public function setIdProgramaTrabalho($id_programa_trabalho)
    {
        $this->id_programa_trabalho = $id_programa_trabalho;

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
     * Get the value of Id Fonte
     *
     * @return mixed
     */
    public function getIdFonte()
    {
        return $this->id_fonte;
    }

    /**
     * Set the value of Id Fonte
     *
     * @param mixed id_fonte
     *
     * @return self
     */
    public function setIdFonte($id_fonte)
    {
        $this->id_fonte = $id_fonte;

        return $this;
    }

    /**
     * Get the value of Vl Pre Loa Valores
     *
     * @return mixed
     */
    public function getVlPreLoaValores()
    {
        return $this->vl_pre_loa_valores;
    }

    /**
     * Set the value of Vl Pre Loa Valores
     *
     * @param mixed vl_pre_loa_valores
     *
     * @return self
     */
    public function setVlPreLoaValores($vl_pre_loa_valores)
    {
        $this->vl_pre_loa_valores = $vl_pre_loa_valores;

        return $this;
    }

}
