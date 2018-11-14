<?php

class RecPessoaRecurso{
    
    private $id_pessoa_recurso = null;
    private $id_pessoa = null;
    private $id_recurso = null;
    private $fl_cadastrar = null;
    private $fl_editar = null;
    private $fl_excluir = null;



    /**
     * Get the value of Id Pessoa Recurso
     *
     * @return mixed
     */
    public function getIdPessoaRecurso()
    {
        return $this->id_pessoa_recurso;
    }

    /**
     * Set the value of Id Pessoa Recurso
     *
     * @param mixed id_pessoa_recurso
     *
     * @return self
     */
    public function setIdPessoaRecurso($id_pessoa_recurso)
    {
        $this->id_pessoa_recurso = $id_pessoa_recurso;

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
     * Get the value of Id Recurso
     *
     * @return mixed
     */
    public function getIdRecurso()
    {
        return $this->id_recurso;
    }

    /**
     * Set the value of Id Recurso
     *
     * @param mixed id_recurso
     *
     * @return self
     */
    public function setIdRecurso($id_recurso)
    {
        $this->id_recurso = $id_recurso;

        return $this;
    }

    /**
     * Get the value of Fl Cadastrar
     *
     * @return mixed
     */
    public function getFlCadastrar()
    {
        return $this->fl_cadastrar;
    }

    /**
     * Set the value of Fl Cadastrar
     *
     * @param mixed fl_cadastrar
     *
     * @return self
     */
    public function setFlCadastrar($fl_cadastrar)
    {
        $this->fl_cadastrar = $fl_cadastrar;

        return $this;
    }

    /**
     * Get the value of Fl Editar
     *
     * @return mixed
     */
    public function getFlEditar()
    {
        return $this->fl_editar;
    }

    /**
     * Set the value of Fl Editar
     *
     * @param mixed fl_editar
     *
     * @return self
     */
    public function setFlEditar($fl_editar)
    {
        $this->fl_editar = $fl_editar;

        return $this;
    }

    /**
     * Get the value of Fl Excluir
     *
     * @return mixed
     */
    public function getFlExcluir()
    {
        return $this->fl_excluir;
    }

    /**
     * Set the value of Fl Excluir
     *
     * @param mixed fl_excluir
     *
     * @return self
     */
    public function setFlExcluir($fl_excluir)
    {
        $this->fl_excluir = $fl_excluir;

        return $this;
    }

}
