<?php

class ConLiquidacaoPesLot {

    private $id_liquidacao_pes_lot = null;
    private $id_pessoa = null;
    private $id_lotacao = null;
    
    /**
     * Get the value of Id Liquidacao Pes Lot
     *
     * @return mixed
     */
    public function getIdLiquidacaoPesLot()
    {
        return $this->id_liquidacao_pes_lot;
    }

    /**
     * Set the value of Id Liquidacao Pes Lot
     *
     * @param mixed id_liquidacao_pes_lot
     *
     * @return self
     */
    public function setIdLiquidacaoPesLot($id_liquidacao_pes_lot)
    {
        $this->id_liquidacao_pes_lot = $id_liquidacao_pes_lot;

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

}
