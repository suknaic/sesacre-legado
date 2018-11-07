<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 06/11/18
 * Time: 11:46
 */

class Fornecedor {

    private $idFornecedor = null;
    private $idPessoa = null;
    private $pessoaFisica = null;
    private $pessoaJuridica = null;
    private $pessoa = null;
    private $medicamento = null;
    private $servico = null;
    private $materialConsumo = null;
    private $materialPermanente = null;
    private $flDistribuidora = null;
    private $flExclusiva = null;

    /**
     * @return null
     */
    public function getIdFornecedor()
    {
        return $this->idFornecedor;
    }

    /**
     * @param null $idFornecedor
     * @return class
     */
    public function setIdFornecedor($idFornecedor)
    {
        $this->idFornecedor = $idFornecedor;
        return $this;
    }

    /**
     * @return null
     */
    public function getIdPessoa()
    {
        return $this->idPessoa;
    }

    /**
     * @param null $idPessoa
     */
    public function setIdPessoa($idPessoa)
    {
        $this->idPessoa = $idPessoa;
    }

    /**
     * @return null
     */
    public function getPessoaFisica()
    {
        return $this->pessoaFisica;
    }

    /**
     * @param null $pessoaFisica
     */
    public function setPessoaFisica($pessoaFisica)
    {
        $this->pessoaFisica = $pessoaFisica;
    }

    /**
     * @return null
     */
    public function getPessoaJuridica()
    {
        return $this->pessoaJuridica;
    }

    /**
     * @param null $pessoaJuridica
     */
    public function setPessoaJuridica($pessoaJuridica)
    {
        $this->pessoaJuridica = $pessoaJuridica;
    }

    /**
     * @return null
     */
    public function getPessoa()
    {
        return $this->pessoa;
    }

    /**
     * @param null $pessoa
     */
    public function setPessoa($pessoa)
    {
        $this->pessoa = $pessoa;
    }

    /**
     * @return null
     */
    public function getMedicamento()
    {
        return $this->medicamento;
    }

    /**
     * @param null $medicamento
     */
    public function setMedicamento($medicamento)
    {
        $this->medicamento = $medicamento;
    }

    /**
     * @return null
     */
    public function getServico()
    {
        return $this->servico;
    }

    /**
     * @param null $servico
     */
    public function setServico($servico)
    {
        $this->servico = $servico;
    }

    /**
     * @return null
     */
    public function getMaterialConsumo()
    {
        return $this->materialConsumo;
    }

    /**
     * @param null $materialConsumo
     */
    public function setMaterialConsumo($materialConsumo)
    {
        $this->materialConsumo = $materialConsumo;
    }

    /**
     * @return null
     */
    public function getMaterialPermanente()
    {
        return $this->materialPermanente;
    }

    /**
     * @param null $materialPermanente
     */
    public function setMaterialPermanente($materialPermanente)
    {
        $this->materialPermanente = $materialPermanente;
    }

    /**
     * @return null
     */
    public function getFlDistribuidora()
    {
        return $this->flDistribuidora;
    }

    /**
     * @param null $flDistribuidora
     */
    public function setFlDistribuidora($flDistribuidora)
    {
        $this->flDistribuidora = $flDistribuidora;
    }

    /**
     * @return null
     */
    public function getFlExclusiva()
    {
        return $this->flExclusiva;
    }

    /**
     * @param null $flExclusiva
     */
    public function setFlExclusiva($flExclusiva)
    {
        $this->flExclusiva = $flExclusiva;
    }

    public function cadastrarFornecedor() {
        try {
//            var_dump($this->pessoaFisica);
//            return;
            if (empty($this->pessoa['nmPessoa'] && $this->pessoa['cidade'] && $this->pessoa['logradouro'] && $this->pessoa['bairro'] && $this->pessoa['cep'] && $this->pessoa['email'])) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $pessoa = new Pessoa();
            $pessoa->setNm_pessoa(trim($this->pessoa['nmPessoa']));
            $pessoa->setId_cidade($this->pessoa['cidade']);
            $pessoa->setDs_logradouro($this->pessoa['logradouro']);
            $pessoa->setDs_bairro($this->pessoa['bairro']);
            $pessoa->setNr_cep($this->pessoa['cep']);
            $pessoa->setNm_email($this->pessoa['email'] == '' ? null:$this->pessoa['email']);
            $pessoa->setNr_telefone_celular($this->pessoaFisica['tl_celular'] == '' ? Metodos::formataTelefone($this->pessoaJuridica['tl_empresa']): Metodos::formataTelefone($this->pessoaFisica['tl_celular']));
            $pessoa->setNr_elefone_residencial($this->pessoa['tl_residencial'] == '' ? null: Metodos::formataTelefone($this->pessoa['tl_residencial']));

            $continua = false;
            $pessoa->cadastrarPessoa($pdo);
            if ($pessoa->getSuccess()) {
                if (!empty($this->pessoaFisica)) {
                    $pessoaFisica = new pessoaFisica();
                    $pessoaFisica->setId_pessoa($pessoa->getMsg());
                    $pessoaFisica->setTp_sexo($pessoaFisica['sexo']);
                    $pessoaFisica->setNr_cpf($pessoaFisica['cpf']);

                    $pessoaFisica->cadastrarPessoaFisica($pdo);
                    if ($pessoaFisica->getSuccess()) {
                        $continua = true;
                    }
                }

//                if (!empty($this->pessoaJuridica)) {
//
//                }

                if ($continua) {
                    $fornedor = new DaoFornecedor();
                    $fornedor->setIdPessoa($pessoa->getMsg());
                    $fornedor->setFlDistribuidora($this->flDistribuidora);
                    $fornedor->setFlExclusiva($this->flExclusiva);

                    $cadastraFornecedor = $fornedor->cadastrarFornecedor($pdo);

                } else {
                    return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                }

            }
            var_dump($pessoa->getSuccess());
            var_dump($pessoa->getMsg());
//            $pdo->rollBack();
            return;
        } catch (Exception $ex) {
            return Metodos::retornoAjax($ex->getMessage());
        }
    }
}