<?php

class PlaPtaItemValidacaoItem{

    private $id_pta_item_validacao_item = null;
    private $id_pta_item = null;
    private $id_lotacao = null;
    private $id_pessoa = null;
    private $dh_pta_item_validacao_item = null;



    /**
     * Get the value of Id Pta Item Validacao Item
     *
     * @return mixed
     */
    public function getIdPtaItemValidacaoItem()
    {
        return $this->id_pta_item_validacao_item;
    }

    /**
     * Set the value of Id Pta Item Validacao Item
     *
     * @param mixed id_pta_item_validacao_item
     *
     * @return self
     */
    public function setIdPtaItemValidacaoItem($id_pta_item_validacao_item)
    {
        $this->id_pta_item_validacao_item = $id_pta_item_validacao_item;

        return $this;
    }

    /**
     * Get the value of Id Pta Item
     *
     * @return mixed
     */
    public function getIdPtaItem()
    {
        return $this->id_pta_item;
    }

    /**
     * Set the value of Id Pta Item
     *
     * @param mixed id_pta_item
     *
     * @return self
     */
    public function setIdPtaItem($id_pta_item)
    {
        $this->id_pta_item = $id_pta_item;

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
     * Get the value of Dh Pta Item Validacao Item
     *
     * @return mixed
     */
    public function getDhPtaItemValidacaoItem()
    {
        return $this->dh_pta_item_validacao_item;
    }

    /**
     * Set the value of Dh Pta Item Validacao Item
     *
     * @param mixed dh_pta_item_validacao_item
     *
     * @return self
     */
    public function setDhPtaItemValidacaoItem($dh_pta_item_validacao_item)
    {
        $this->dh_pta_item_validacao_item = $dh_pta_item_validacao_item;

        return $this;
    }

}
