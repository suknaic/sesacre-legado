<?php

class PlaLiberacaoFonteUnidade {

    private $id_liberacao_fonte_unidade = null;
    private $id_liberacao_fonte = null;
    private $id_lotacao = null;
    private $id_programa_trabalho = null;
    private $id_despesa_elemento = null;
    private $vl_inicial = null;
    private $vl_suplementado = null;
    private $vl_reduzido = null;



    /**
     * Get the value of Id Liberacao Fonte Unidade 
     *
     * @return mixed
     */
    public function getIdLiberacaoFonteUnidade()
    {
        return $this->id_liberacao_fonte_unidade;
    }

    /**
     * Set the value of Id Liberacao Fonte Unidade
     *
     * @param mixed id_liberacao_fonte_unidade
     *
     * @return self
     */
    public function setIdLiberacaoFonteUnidade($id_liberacao_fonte_unidade)
    {
        $this->id_liberacao_fonte_unidade = $id_liberacao_fonte_unidade;

        return $this;
    }

    /**
     * Get the value of Id Liberacao Fonte
     *
     * @return mixed
     */
    public function getIdLiberacaoFonte()
    {
        return $this->id_liberacao_fonte;
    }

    /**
     * Set the value of Id Liberacao Fonte
     *
     * @param mixed id_liberacao_fonte
     *
     * @return self
     */
    public function setIdLiberacaoFonte($id_liberacao_fonte)
    {
        $this->id_liberacao_fonte = $id_liberacao_fonte;

        return $this;
    }

    /**
     * Get the value of Id Lotacao
     *
     * @return mixed
     */
    public function getIdLotacao()
    {
        return $this->id_lotacao;
    }

    /**
     * Set the value of Id Lotacao
     *
     * @param mixed id_lotacao
     *
     * @return self
     */
    public function setIdLotacao($id_lotacao)
    {
        $this->id_lotacao = $id_lotacao;

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
     * Get the value of Vl Inicial
     *
     * @return mixed
     */
    public function getVlInicial()
    {
        return $this->vl_inicial;
    }

    /**
     * Set the value of Vl Inicial
     *
     * @param mixed vl_inicial
     *
     * @return self
     */
    public function setVlInicial($vl_inicial)
    {
        $this->vl_inicial = $vl_inicial;

        return $this;
    }

    /**
     * Get the value of Vl Suplementado
     *
     * @return mixed
     */
    public function getVlSuplementado()
    {
        return $this->vl_suplementado;
    }

    /**
     * Set the value of Vl Suplementado
     *
     * @param mixed vl_suplementado
     *
     * @return self
     */
    public function setVlSuplementado($vl_suplementado)
    {
        $this->vl_suplementado = $vl_suplementado;

        return $this;
    }

    /**
     * Get the value of Vl Reduzido
     *
     * @return mixed
     */
    public function getVlReduzido()
    {
        return $this->vl_reduzido;
    }

    /**
     * Set the value of Vl Reduzido
     *
     * @param mixed vl_reduzido
     *
     * @return self
     */
    public function setVlReduzido($vl_reduzido)
    {
        $this->vl_reduzido = $vl_reduzido;

        return $this;
    }

}
