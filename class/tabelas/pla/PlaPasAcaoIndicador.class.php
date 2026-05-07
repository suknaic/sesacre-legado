<?php

class PlaPasAcaoIndicador{

    private $id_pas_acao_indicador = null;
    private $id_pas = null;
    private $id_acao = null;
    private $id_indicador_saude = null;                

    /**
     * Get the value of Id Pas Acao Indicador
     *
     * @return mixed
     */
    public function getIdPasAcaoIndicador()
    {
        return $this->id_pas_acao_indicador;
    }

    /**
     * Set the value of Id Pas Acao Indicador
     *
     * @param mixed id_pas_acao_indicador
     *
     * @return self
     */
    public function setIdPasAcaoIndicador($id_pas_acao_indicador)
    {
        $this->id_pas_acao_indicador = $id_pas_acao_indicador;

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
     * Get the value of Id Acao
     *
     * @return mixed
     */
    public function getIdAcao()
    {
        return $this->id_acao;
    }

    /**
     * Set the value of Id Acao
     *
     * @param mixed id_acao
     *
     * @return self
     */
    public function setIdAcao($id_acao)
    {
        $this->id_acao = $id_acao;

        return $this;
    }

    /**
     * Get the value of Id Indicador Saude
     *
     * @return mixed
     */
    public function getIdIndicadorSaude()
    {
        return $this->id_indicador_saude;
    }

    /**
     * Set the value of Id Indicador Saude
     *
     * @param mixed id_indicador_saude
     *
     * @return self
     */
    public function setIdIndicadorSaude($id_indicador_saude)
    {
        $this->id_indicador_saude = $id_indicador_saude;

        return $this;
    }

}
