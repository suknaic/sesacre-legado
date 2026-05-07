<?php

class PlaPtaAcaoDet{

    private $id_pta_acao_det = null;
    private $id_pta = null;
    private $id_acao = null;
    private $nm_pta_acao_det = null;
    private $st_ativo = null;

    /**
     * Get the value of Id Pta Acao Det
     *
     * @return mixed
     */
    public function getIdPtaAcaoDet()
    {
        return $this->id_pta_acao_det;
    }

    /**
     * Set the value of Id Pta Acao Det
     *
     * @param mixed id_pta_acao_det
     *
     * @return self
     */
    public function setIdPtaAcaoDet($id_pta_acao_det)
    {
        $this->id_pta_acao_det = $id_pta_acao_det;

        return $this;
    }

    /**
     * Get the value of Id Pta Acao
     *
     * @return mixed
     */
    public function getIdPta()
    {
        return $this->id_pta;
    }

    /**
     * Set the value of Id Pta
     *
     * @param mixed id_pta
     *
     * @return self
     */
    public function setIdPta($id_pta)
    {
        $this->id_pta = $id_pta;

        return $this;
    }

    /**
     * Get the value of Nm Pta Acao Det
     *
     * @return mixed
     */
    public function getNmPtaAcaoDet()
    {
        return $this->nm_pta_acao_det;
    }

    /**
     * Set the value of Nm Pta Acao Det
     *
     * @param mixed nm_pta_acao_det
     *
     * @return self
     */
    public function setNmPtaAcaoDet($nm_pta_acao_det)
    {
        $this->nm_pta_acao_det = $nm_pta_acao_det;

        return $this;
    }

    /**
     * Get the value of St Ativo
     *
     * @return mixed
     */
    public function getStAtivo()
    {
        return $this->st_ativo;
    }

    /**
     * Set the value of St Ativo
     *
     * @param mixed st_ativo
     *
     * @return self
     */
    public function setStAtivo($st_ativo)
    {
        $this->st_ativo = $st_ativo;

        return $this;
    }
    
    function getIdAcao() {
        return $this->id_acao;
    }

    function setIdAcao($id_acao) {
        $this->id_acao = $id_acao;
        return $this;
    }



}
