<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 27/09/18
 * Time: 15:28
 */

class Servidor {
    private $idServidor = null;
    private $id_pessoa = null;

    private $id_pessoa_fisica = null;
    private $tp_sexo = null;
    private $nm_civil = null;
    private $nr_cpf = null;
    private $nr_rg = null;
    private $ds_orgao_expedidor = null;
    private $id_estado_expedidor = null;
    private $id_estado_civil = null;
    private $id_escolaridade_formacao = null;
    private $ds_habilidade = null;
    private $nm_pai = null;
    private $nm_mae = null;
    private $dt_nascimento = null;
    private $nr_cns = null;

    /**
     * @return null
     */
    public function getIdServidor()
    {
        return $this->idServidor;
    }

    /**
     * @param null $idServidor
     */
    public function setIdServidor($idServidor)
    {
        $this->idServidor = $idServidor;
    }

    /**
     * @return null
     */
    public function getIdPessoaFisica()
    {
        return $this->id_pessoa_fisica;
    }

    /**
     * @param null $id_pessoa_fisica
     * @return Servidor
     */
    public function setIdPessoaFisica($id_pessoa_fisica)
    {
        $this->id_pessoa_fisica = $id_pessoa_fisica;
        return $this;
    }

    /**
     * @return null
     */
    public function getIdPessoa()
    {
        return $this->id_pessoa;
    }

    /**
     * @param null $id_pessoa
     */
    public function setIdPessoa($id_pessoa)
    {
        $this->id_pessoa = $id_pessoa;
    }

    /**
     * @return null
     */
    public function getTpSexo()
    {
        return $this->tp_sexo;
    }

    /**
     * @param null $tp_sexo
     */
    public function setTpSexo($tp_sexo)
    {
        $this->tp_sexo = $tp_sexo;
    }

    /**
     * @return null
     */
    public function getNmCivil()
    {
        return $this->nm_civil;
    }

    /**
     * @param null $nm_civil
     */
    public function setNmCivil($nm_civil)
    {
        $this->nm_civil = $nm_civil;
    }

    /**
     * @return null
     */
    public function getNrCpf()
    {
        return $this->nr_cpf;
    }

    /**
     * @param null $nr_cpf
     */
    public function setNrCpf($nr_cpf)
    {
        $this->nr_cpf = $nr_cpf;
    }

    /**
     * @return null
     */
    public function getNrCns()
    {
        return $this->nr_cns;
    }

    /**
     * @param null $nr_cns
     */
    public function setNrCns($nr_cns)
    {
        $this->nr_cns = $nr_cns;
    }

    /**
     * @return null
     */
    public function getNrRg()
    {
        return $this->nr_rg;
    }

    /**
     * @param null $nr_rg
     */
    public function setNrRg($nr_rg)
    {
        $this->nr_rg = $nr_rg;
    }

    /**
     * @return null
     */
    public function getDsOrgaoExpedidor()
    {
        return $this->ds_orgao_expedidor;
    }

    /**
     * @param null $ds_orgao_expedidor
     */
    public function setDsOrgaoExpedidor($ds_orgao_expedidor)
    {
        $this->ds_orgao_expedidor = $ds_orgao_expedidor;
    }

    /**
     * @return null
     */
    public function getIdEstadoExpedidor()
    {
        return $this->id_estado_expedidor;
    }

    /**
     * @param null $id_estado_expedidor
     */
    public function setIdEstadoExpedidor($id_estado_expedidor)
    {
        $this->id_estado_expedidor = $id_estado_expedidor;
    }

    /**
     * @return null
     */
    public function getIdEstadoCivil()
    {
        return $this->id_estado_civil;
    }

    /**
     * @param null $id_estado_civil
     */
    public function setIdEstadoCivil($id_estado_civil)
    {
        $this->id_estado_civil = $id_estado_civil;
    }

    /**
     * @return null
     */
    public function getIdEscolaridadeFormacao()
    {
        return $this->id_escolaridade_formacao;
    }

    /**
     * @param null $id_escolaridade_formacao
     */
    public function setIdEscolaridadeFormacao($id_escolaridade_formacao)
    {
        $this->id_escolaridade_formacao = $id_escolaridade_formacao;
    }

    /**
     * @return null
     */
    public function getDsHabilidade()
    {
        return $this->ds_habilidade;
    }

    /**
     * @param null $ds_habilidade
     */
    public function setDsHabilidade($ds_habilidade)
    {
        $this->ds_habilidade = $ds_habilidade;
    }

    /**
     * @return null
     */
    public function getNmPai()
    {
        return $this->nm_pai;
    }

    /**
     * @param null $nm_pai
     */
    public function setNmPai($nm_pai)
    {
        $this->nm_pai = $nm_pai;
    }

    /**
     * @return null
     */
    public function getNmMae()
    {
        return $this->nm_mae;
    }

    /**
     * @param null $nm_mae
     */
    public function setNmMae($nm_mae)
    {
        $this->nm_mae = $nm_mae;
    }

    /**
     * @return null
     */
    public function getDtNascimento()
    {
        return $this->dt_nascimento;
    }

    /**
     * @param null $dt_nascimento
     */
    public function setDtNascimento($dt_nascimento)
    {
        $this->dt_nascimento = $dt_nascimento;
    }

    public function listarFornecedor() {
        try {
            if (empty($this->nm_civil) && empty($this->nr_cpf)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }

            $cpf = null;
            if (!empty($this->nr_cpf)){
                if (!Metodos::validaCPF($this->nr_cpf)) {
                    return Metodos::retornoAjax('Erro', 'alert', 'CPF informado é inválido.');
                } else {
                    $cpf = Metodos::formataCpf($this->nr_cpf);
                }
            }

            $pessoaFisica = new pessoaFisica();
            $resultado = $pessoaFisica->listaPessoaFisica($this->nm_civil, $cpf, true);
            return $resultado;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
}

