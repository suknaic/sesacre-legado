<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/fornecedor/DaoFornecedor.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/FornecedorMedicamento.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/FornecedorServico.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/FornecedorMaterialConsumo.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/FornecedorMaterialPermanente.class.php";
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
            if ((empty($this->pessoaFisica['nmPessoaFisica']) || empty($this->pessoaJuridica['nmRazaoSoc'])) && empty($this->pessoa['cidade'] && $this->pessoa['logradouro'] && $this->pessoa['bairro'] && $this->pessoa['cep'])) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $pessoa = new Pessoa();
            $pessoa->setNm_pessoa(empty($this->pessoaFisica['nmPessoaFisica']) ? trim($this->pessoaJuridica['nmRazaoSoc']):trim($this->pessoaFisica['nmPessoaFisica']));
            $pessoa->setId_cidade($this->pessoa['cidade']);
            $pessoa->setDs_logradouro($this->pessoa['logradouro']);
            $pessoa->setDs_bairro($this->pessoa['bairro']);
            $pessoa->setNr_cep($this->pessoa['cep']);
            $pessoa->setNm_email(empty($this->pessoa['email']) ? null:$this->pessoa['email']);
            $pessoa->setNr_telefone_celular(empty($this->pessoaFisica['tl_celular']) ? Metodos::formataTelefone($this->pessoaJuridica['tl_empresa']):Metodos::formataTelefone($this->pessoaFisica['tl_celular']));
            $pessoa->setNr_elefone_residencial($this->pessoa['tl_residencial'] == '' ? null:Metodos::formataTelefone($this->pessoa['tl_residencial']));

            $continua = false;
            $pessoa->cadastrarPessoa($pdo);
            if ($pessoa->getSuccess()) {
                if (!empty($this->pessoaFisica)) {
                    $pessoaFisica = new pessoaFisica();

                    $pessoaFisica->setId_pessoa($pessoa->getId_pessoa());
                    $pessoaFisica->setTp_sexo($this->pessoaFisica['sexo']);
                    $pessoaFisica->setNr_cpf($this->pessoaFisica['cpf']);

                    $pessoaFisica->cadastrarPessoaFisica($pdo);
                    if ($pessoaFisica->getSuccess()) {
                        $continua = true;
                    } else {
                        return Metodos::retornoAjax('Erro', 'console', $pessoaFisica->getMsg());
                    }
                }

                if (!empty($this->pessoaJuridica)) {
                    $pessoaJuridica = new pessoaJuridica();
                    $pessoaJuridica->setId_pessoa($pessoa->getId_pessoa());
                    $pessoaJuridica->setNm_fantasia($this->pessoaJuridica['nmFantasia']);
                    $pessoaJuridica->setNr_cnpj($this->pessoaJuridica['cnpj']);
                    $pessoaJuridica->setDs_insc_estadual(empty($this->pessoaJuridica['nrEstudal']) ? null:trim($this->pessoaJuridica['nrEstudal']));
                    $pessoaJuridica->setDs_insc_municipal(empty($this->pessoaJuridica['nrMunicipal']) ? null:trim($this->pessoaJuridica['nrMunicipal']));
                    $pessoaJuridica->setId_natureza($this->pessoaJuridica['natureza']);

                    $pessoaJuridica->cadastrarPessoaJuridica($pdo);
                    if ($pessoaJuridica->getSuccess()) {
                        $continua = true;
                    } else {
                        return Metodos::retornoAjax('Erro', 'console', $pessoaJuridica->getMsg());
                    }
                }

                if ($continua) {
                    $fornedor = new DaoFornecedor();
                    $fornedor->setIdPessoa($pessoa->getId_pessoa());
                    $fornedor->setFlDistribuidora($this->flDistribuidora);
                    $fornedor->setFlExclusiva($this->flExclusiva);

                    $cadastraFornecedor = $fornedor->cadastrarFornecedor($pdo);
                    if ($cadastraFornecedor) {
                        $this->setIdFornecedor($pdo->lastInsertId('for_fornecedor_id_fornecedor_seq'));
                        if (!LOG::SalvaLogI('for_fornecedor', $this->getIdFornecedor(), $pdo)) {
                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                        }
                        $continua = true;
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', $cadastraFornecedor);
                    }
                }

                if ($continua) {
                    if (!empty($this->medicamento)) {
                        $fornecedorMedicamento = new FornecedorMedicamento();
                        foreach ($this->medicamento as $idMedicamento) {
                            $fornecedorMedicamento->setIdMedicamento($idMedicamento);
                            $fornecedorMedicamento->setIdFornecedor($this->getIdFornecedor());

                            if (!$fornecedorMedicamento->cadastrarFornecedorMedicamento($pdo)) {
                                return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                            }
                        }
                    }

                    if (!empty($this->servico)) {
                        $fornecedorServico = new FornecedorServico();
                        foreach ($this->servico as $idServico) {
                            $fornecedorServico->setIdServico($idServico);
                            $fornecedorServico->setIdFornecedor($this->getIdFornecedor());

                            if (!$fornecedorServico->cadastraFornecedorServico($pdo)) {
                                return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                            }
                        }
                    }

                    if (!empty($this->materialConsumo)) {
                        $fornedorMaterialConsumo = new FornecedorMaterialConsumo();
                        foreach ($this->materialConsumo as $idMaterialConsumo) {
                            $fornedorMaterialConsumo->setIdMaterialConsumo($idMaterialConsumo);
                            $fornedorMaterialConsumo->setIdFornecedor($this->getIdFornecedor());

                            if (!$fornedorMaterialConsumo->cadastrarFornecedorMaterialConsumo($pdo)){
                                return Metodos::retornoAjax('Erro', 'alert', STR_ERROR);
                            }
                        }
                    }

                    if (!empty($this->materialPermanente)) {
                        $fornedorMaterialPermanente = new FornecedorMaterialPermanente();
                        foreach ($this->materialPermanente as $idMaterialPermanente) {
                            $fornedorMaterialPermanente->setIdMaterialPermanente($idMaterialPermanente);
                            $fornedorMaterialPermanente->setIdFornecedor($this->getIdFornecedor());

                            if (!$fornedorMaterialPermanente->cadastraFornecedorMaterialPermanente($pdo)) {
                                return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                            }
                        }
                    }
                    $continua = true;
                }

                if ($continua) {
                    $pdo->commit();
                    return Metodos::retornoAjax('ok', 'html', STR_CADASTRO_SUCESSO);
                }
            } else {
                return Metodos::retornoAjax('Erro', 'alert', $pessoa->getMsg());
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax($ex->getMessage());
        }
    }
}