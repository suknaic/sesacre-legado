<?php

class FinProgramaTrabalho {

    private $id_programa_trabalho = null;
    private $id_prog_trab_funcao = null;
    private $id_prog_trab_subfuncao = null;
    private $id_prog_trab_programa = null;
    private $cd_programa_trabalho = null;
    private $ds_programa_trabalho = null;
    private $aa_programa_trabalho = null;
    private $st_ativo = null;    

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
     * Get the value of Id Prog Trab Funcao
     *
     * @return mixed
     */
    public function getIdProgTrabFuncao()
    {
        return $this->id_prog_trab_funcao;
    }

    /**
     * Set the value of Id Prog Trab Funcao
     *
     * @param mixed id_prog_trab_funcao
     *
     * @return self
     */
    public function setIdProgTrabFuncao($id_prog_trab_funcao)
    {
        $this->id_prog_trab_funcao = $id_prog_trab_funcao;

        return $this;
    }

    /**
     * Get the value of Id Prog Trab Subfuncao
     *
     * @return mixed
     */
    public function getIdProgTrabSubfuncao()
    {
        return $this->id_prog_trab_subfuncao;
    }

    /**
     * Set the value of Id Prog Trab Subfuncao
     *
     * @param mixed id_prog_trab_subfuncao
     *
     * @return self
     */
    public function setIdProgTrabSubfuncao($id_prog_trab_subfuncao)
    {
        $this->id_prog_trab_subfuncao = $id_prog_trab_subfuncao;

        return $this;
    }

    /**
     * Get the value of Id Prog Trab Programa
     *
     * @return mixed
     */
    public function getIdProgTrabPrograma()
    {
        return $this->id_prog_trab_programa;
    }

    /**
     * Set the value of Id Prog Trab Programa
     *
     * @param mixed id_prog_trab_programa
     *
     * @return self
     */
    public function setIdProgTrabPrograma($id_prog_trab_programa)
    {
        $this->id_prog_trab_programa = $id_prog_trab_programa;

        return $this;
    }

    /**
     * Get the value of Cd Programa Trabalho
     *
     * @return mixed
     */
    public function getCdProgramaTrabalho()
    {
        return $this->cd_programa_trabalho;
    }

    /**
     * Set the value of Cd Programa Trabalho
     *
     * @param mixed cd_programa_trabalho
     *
     * @return self
     */
    public function setCdProgramaTrabalho($cd_programa_trabalho)
    {
        $this->cd_programa_trabalho = $cd_programa_trabalho;

        return $this;
    }

    /**
     * Get the value of Ds Programa Trabalho
     *
     * @return mixed
     */
    public function getDsProgramaTrabalho()
    {
        return $this->ds_programa_trabalho;
    }

    /**
     * Set the value of Ds Programa Trabalho
     *
     * @param mixed ds_programa_trabalho
     *
     * @return self
     */
    public function setDsProgramaTrabalho($ds_programa_trabalho)
    {
        $this->ds_programa_trabalho = $ds_programa_trabalho;

        return $this;
    }

    /**
     * Get the value of Aa Programa Trabalho
     *
     * @return mixed
     */
    public function getAaProgramaTrabalho()
    {
        return $this->aa_programa_trabalho;
    }

    /**
     * Set the value of Aa Programa Trabalho
     *
     * @param mixed aa_programa_trabalho
     *
     * @return self
     */
    public function setAaProgramaTrabalho($aa_programa_trabalho)
    {
        $this->aa_programa_trabalho = $aa_programa_trabalho;

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

}
