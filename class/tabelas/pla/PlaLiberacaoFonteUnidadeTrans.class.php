<?php

class PlaLiberacaoFonteUnidadeTrans {

    private $id_liberacao_fonte_unidade_trans = null;
    private $id_pessoa = null;
    private $id_liberacao_fonte_unidade = null;
    private $vl_liberacao_fonte_unidade_trans = null;
    private $tp_liberacao_fonte_unidade_trans = null;


            
    /**
     * Get the value of Id Liberacao Fonte Unidade Trans
     *
     * @return mixed
     */
    public function getIdLiberacaoFonteUnidadeTrans()
    {
        return $this->id_liberacao_fonte_unidade_trans;
    }

    /**
     * Set the value of Id Liberacao Fonte Unidade Trans
     *
     * @param mixed id_liberacao_fonte_unidade_trans
     *
     * @return self
     */
    public function setIdLiberacaoFonteUnidadeTrans($id_liberacao_fonte_unidade_trans)
    {
        $this->id_liberacao_fonte_unidade_trans = $id_liberacao_fonte_unidade_trans;

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
     * Get the value of Vl Liberacao Fonte Unidade Trans
     *
     * @return mixed
     */
    public function getVlLiberacaoFonteUnidadeTrans()
    {
        return $this->vl_liberacao_fonte_unidade_trans;
    }

    /**
     * Set the value of Vl Liberacao Fonte Unidade Trans
     *
     * @param mixed vl_liberacao_fonte_unidade_trans
     *
     * @return self
     */
    public function setVlLiberacaoFonteUnidadeTrans($vl_liberacao_fonte_unidade_trans)
    {
        $this->vl_liberacao_fonte_unidade_trans = $vl_liberacao_fonte_unidade_trans;

        return $this;
    }

    /**
     * Get the value of Tp Liberacao Fonte Unidade Trans
     *
     * @return mixed
     */
    public function getTpLiberacaoFonteUnidadeTrans()
    {
        return $this->tp_liberacao_fonte_unidade_trans;
    }

    /**
     * Set the value of Tp Liberacao Fonte Unidade Trans
     *
     * @param mixed tp_liberacao_fonte_unidade_trans
     *
     * @return self
     */
    public function setTpLiberacaoFonteUnidadeTrans($tp_liberacao_fonte_unidade_trans)
    {
        $this->tp_liberacao_fonte_unidade_trans = $tp_liberacao_fonte_unidade_trans;

        return $this;
    }

}
