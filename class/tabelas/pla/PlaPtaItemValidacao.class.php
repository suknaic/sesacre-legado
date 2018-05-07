<?php

class PlaPtaItemValidacao {

    private $id_pta_item_validacao = null;
    private $id_pas = null;
    private $id_tipo_gasto_categoria = null;
    private $id_pessoa = null;
    private $ds_pta_item_validacao = null;
    private $dh_pta_item_validacao = null;
    private $st_pta_item_validacao = null;
    
    
    function getStPtaItemValidacao() {
        return $this->st_pta_item_validacao;
    }

    function setStPtaItemValidacao($st_pta_item_validacao) {
        $this->st_pta_item_validacao = $st_pta_item_validacao;
        return $this;
    }

        
    /**
     * Get the value of Id Pta Item Validacao
     *
     * @return mixed
     */
    public function getIdPtaItemValidacao()
    {
        return $this->id_pta_item_validacao;
    }

    /**
     * Set the value of Id Pta Item Validacao
     *
     * @param mixed id_pta_item_validacao
     *
     * @return self
     */
    public function setIdPtaItemValidacao($id_pta_item_validacao)
    {
        $this->id_pta_item_validacao = $id_pta_item_validacao;

        return $this;
    }

    /**
     * Get the value of Id Pas
     *
     * @return mixed
     */
    public function getIdPas()
    {
        return $this->id_pas;
    }

    /**
     * Set the value of Id Pas
     *
     * @param mixed id_pas
     *
     * @return self
     */
    public function setIdPas($id_pas)
    {
        $this->id_pas = $id_pas;

        return $this;
    }

    /**
     * Get the value of Id Tipo Gasto Categoria
     *
     * @return mixed
     */
    public function getIdTipoGastoCategoria()
    {
        return $this->id_tipo_gasto_categoria;
    }

    /**
     * Set the value of Id Tipo Gasto Categoria
     *
     * @param mixed id_tipo_gasto_categoria
     *
     * @return self
     */
    public function setIdTipoGastoCategoria($id_tipo_gasto_categoria)
    {
        $this->id_tipo_gasto_categoria = $id_tipo_gasto_categoria;

        return $this;
    }

    /**
     * Get the value of Id Pessoa
     *
     * @return mixed
     */
    public function getIdPessoa()
    {
        return $this->id_pessoa;
    }

    /**
     * Set the value of Id Pessoa
     *
     * @param mixed id_pessoa
     *
     * @return self
     */
    public function setIdPessoa($id_pessoa)
    {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    /**
     * Get the value of Ds Pta Item Validacao
     *
     * @return mixed
     */
    public function getDsPtaItemValidacao()
    {
        return $this->ds_pta_item_validacao;
    }

    /**
     * Set the value of Ds Pta Item Validacao
     *
     * @param mixed ds_pta_item_validacao
     *
     * @return self
     */
    public function setDsPtaItemValidacao($ds_pta_item_validacao)
    {
        $this->ds_pta_item_validacao = $ds_pta_item_validacao;

        return $this;
    }

    /**
     * Get the value of Dh Pta Item Validacao
     *
     * @return mixed
     */
    public function getDhPtaItemValidacao()
    {
        return $this->dh_pta_item_validacao;
    }

    /**
     * Set the value of Dh Pta Item Validacao
     *
     * @param mixed dh_pta_item_validacao
     *
     * @return self
     */
    public function setDhPtaItemValidacao($dh_pta_item_validacao)
    {
        $this->dh_pta_item_validacao = $dh_pta_item_validacao;

        return $this;
    }

}
