<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/fornecedor/DaoFornecedor.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoaJuridica/PessoaJuridica.class.php";
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
    private $nmEmpresa = null;
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
    public function getNmEmpresa()
    {
        return $this->nmEmpresa;
    }

    /**
     * @param null $nmEmpresa
     */
    public function setNmEmpresa($nmEmpresa)
    {
        $this->nmEmpresa = $nmEmpresa;
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

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $pessoa = new Pessoa();
            $cadastraPessoa = false;
            $continua = false;

            $fornedor = new DaoFornecedor();
            if (!empty($this->pessoaFisica)) {
                if (!Metodos::validaCPF($this->pessoaFisica['cpf'])) {
                    return Metodos::retornoAjax('Erro', 'alert', 'O CPF informado é inválido.');
                } else {
                    $pf = $fornedor->verificaPfCPF($pdo, Metodos::limpaCPF_CNPJ($this->pessoaFisica['cpf']));
                    if ($pf == null) {
                        $cadastraPessoa = true;
                    } else {
                        $verificaFornecedor = $fornedor->verificaFornecedor($pdo, $pf['id_pessoa']);
                        if ($verificaFornecedor) {
                            return Metodos::retornoAjax('Erro', 'alert', 'Fornecedor com o mesmo CPF já está cadastrado no sistema.');
                        } else {
                            $continua = true;
                            $cadastraPessoa = false;
                            $pessoa->setId_pessoa($pf['id_pessoa']);
                        }
                    }
                }
            }

            if (!empty($this->pessoaJuridica)) {
                if (!Metodos::validaCNPJ($this->pessoaJuridica['cnpj'])) {
                    return Metodos::retornoAjax('Erro', 'alert', 'Fornecedor com o mesmo CNPJ já está cadastrado no sistema.');
                } else {
                    $pj = $fornedor->verificaPJCNPJ($pdo, Metodos::limpaCPF_CNPJ($this->pessoaJuridica['cnpj']));
                    if ($pj == null) {
                        $cadastraPessoa = true;
                    } else {
                        $verificaFornecedor = $fornedor->verificaFornecedor($pdo, $pj['id_pessoa']);
                        if ($verificaFornecedor) {
                            return Metodos::retornoAjax('Erro', 'alert', 'Você já é um fornecedor no sistema.');
                        } else {
                            $continua = true;
                            $cadastraPessoa = false;
                            $pessoa->setId_pessoa($pj['id_pessoa']);
                        }
                    }
                }
            }
//            var_dump($continua);
//            var_dump($cadastraPessoa);
//            return;
            if ($cadastraPessoa) {
                $pessoa->setNm_pessoa(empty($this->pessoaFisica['nmPessoaFisica']) ? trim($this->pessoaJuridica['nmRazaoSoc']):trim($this->pessoaFisica['nmPessoaFisica']));
                $pessoa->setId_cidade($this->pessoa['cidade']);
                $pessoa->setDs_logradouro($this->pessoa['logradouro']);
                $pessoa->setDs_bairro($this->pessoa['bairro']);
                $pessoa->setDs_complemento(empty($this->pessoa['complemento']) ? null:trim($this->pessoa['complemento']));
                $pessoa->setNr_cep($this->pessoa['cep']);
                $pessoa->setNrNumero($this->pessoa['numero']);

                //****************** Valida E-mail *****************
                if (empty($this->pessoa['email'])) {
                    $pessoa->setNm_email(null);
                } else {
                    if (!Metodos::validaEmail($this->pessoa['email'])) {
                        return Metodos::retornoAjax("Erro", "alert", "O E-mail Informado é Inválido.");
                    } else {
                        $pessoa->setNm_email($this->pessoa['email']);
                    }
                }
                //**************************************************

                $pessoa->setNr_telefone_celular(empty($this->pessoaFisica['tl_celular']) ? Metodos::removeMascaraCel_Tel($this->pessoaJuridica['tl_empresa']):Metodos::removeMascaraCel_Tel($this->pessoaFisica['tl_celular']));
                $pessoa->setNr_elefone_residencial($this->pessoa['tl_residencial'] == '' ? null:Metodos::removeMascaraCel_Tel($this->pessoa['tl_residencial']));

                $pessoa->cadastrarPessoa($pdo);
                if (!$pessoa->getSuccess()) {
                    return Metodos::retornoAjax('Erro', 'alert', $pessoa->getMsg());
                } else {
                    $continua = true;
                }
            }

            if ($continua) {
                if (!empty($this->pessoaFisica)) {

                    $pessoaFisica = new pessoaFisica();

                    $pessoaFisica->setId_pessoa($pessoa->getId_pessoa());
                    $verificaPf = $pessoaFisica->verificaPf($pdo);

                    if ($verificaPf == false) {
                        $pessoaFisica->setTp_sexo($this->pessoaFisica['sexo']);

                        if (Metodos::validaCPF($this->pessoaFisica['cpf'])) {
                            $pessoaFisica->setNr_cpf(Metodos::limpaCPF_CNPJ($this->pessoaFisica['cpf']));
                        } else {
                            return Metodos::retornoAjax('Erro', 'alert', 'O CPF informado é inválido.');
                        }

                        $pessoaFisica->cadastrarPessoaFisica($pdo);
                        if (!$pessoaFisica->getSuccess()) {
                            if ($pessoaFisica->getMsg() == STR_CPF_EXISTE) {
                                return Metodos::retornoAjax('Erro', 'alert', 'O CPF informado já está cadastrado.');
                            } else {
                                return Metodos::retornoAjax('Erro', 'console', $pessoaFisica->getMsg());
                            }
                        }
                    }
                }

                if (!empty($this->pessoaJuridica)) {

                    $pessoaJuridica = new pessoaJuridica();

                    $pessoaJuridica->setId_pessoa($pessoa->getId_pessoa());
                    $verificaPj = $pessoaJuridica->retornaPJ($pdo);

                    if ($verificaPj == false) {
                        $pessoaJuridica->setNm_fantasia($this->pessoaJuridica['nmFantasia']);

                        if (Metodos::validaCNPJ($this->pessoaJuridica['cnpj'])) {
                            $pessoaJuridica->setNr_cnpj(Metodos::limpaCPF_CNPJ($this->pessoaJuridica['cnpj']));
                        } else {
                            return Metodos::retornoAjax('Erro', 'alert', 'O CNPJ informado é inválido.');
                        }

                        $pessoaJuridica->setDs_insc_estadual(empty($this->pessoaJuridica['nrEstudal']) ? null:trim($this->pessoaJuridica['nrEstudal']));
                        $pessoaJuridica->setDs_insc_municipal(empty($this->pessoaJuridica['nrMunicipal']) ? null:trim($this->pessoaJuridica['nrMunicipal']));
                        $pessoaJuridica->setId_natureza($this->pessoaJuridica['natureza']);

                        $pessoaJuridica->cadastrarPessoaJuridica($pdo);
                        if (!$pessoaJuridica->getSuccess()) {
                            if ($pessoaJuridica->getMsg() == STR_CNPJ_EXISTE) {
                                return Metodos::retornoAjax('Erro', 'alert', 'O CNPJ informado já está vinculado a um fornecedor.');
                            } else {
                                return Metodos::retornoAjax('Erro', 'console', $pessoaJuridica->getMsg());
                            }
                        }
                    }
                }
            }

            $fornedor->setIdPessoa($pessoa->getId_pessoa());
            $fornedor->setNmEmpresa(empty($this->nmEmpresa) ? null:trim($this->nmEmpresa));
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
        } catch (Exception $ex) {
            return Metodos::retornoAjax('Erro', 'console', $ex->getMessage());
        }
    }

    public function relatorioFornecedor($tipoFornecedor) {
        try {

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $fornecedores = new DaoFornecedor();

            $condicoes = array();
            if (!empty($tipoFornecedor)) {
                if ($tipoFornecedor == 1) {
                    $condicoes[] = "PF.id_pessoa IS NOT NULL";
                } else {
                    $condicoes[] = "PJ.id_pessoa IS NOT NULL";
                }
            }

            if (!empty($this->pessoaFisica['cpf'])) {
                if (!Metodos::validaCPF($this->pessoaFisica['cpf'])) {
                    return Metodos::retornoAjax('Erro', 'alert', 'O CPF informado é inválido.');
                }
                $condicoes[] = "PF.nr_cpf ='".Metodos::limpaCPF_CNPJ($this->pessoaFisica['cpf'])."'";
            }

            if (!empty($this->pessoaJuridica['cnpj'])) {
                if (!Metodos::validaCNPJ($this->pessoaJuridica['cnpj'])) {
                    return Metodos::retornoAjax('Erro', 'alert', 'O CNPJ informado é inválido.');
                }
                $condicoes[] = "PJ.nr_cnpj ='".Metodos::limpaCPF_CNPJ($this->pessoaJuridica['cnpj'])."'";
            }

            if (!empty($this->pessoaFisica['nmPessoaFisica'])) {
                $condicoes[] = "unaccent(PE.nm_pessoa) ilike '%".$this->pessoaFisica['nmPessoaFisica']."%'";
            }

            if (!empty($this->pessoaJuridica['nmRazaoSoc'])) {
                $condicoes[] = "unaccent(PE.nm_pessoa) ilike '%".$this->pessoaJuridica['nmRazaoSoc']."%'";
            }

            if (!empty($this->medicamento)) {
                $condicoes[] = count($this->medicamento) > 1 ? "MED.id_medicamento IN (" . implode(',', $this->medicamento) . ")" : $this->medicamento[0] == 'todos' ? "MED.id_medicamento IN (SELECT for_medicamento.id_medicamento FROM for_medicamento)":"MED.id_medicamento IN (" . $this->medicamento[0] . ")";
            }

            if (!empty($this->servico)) {
                $condicoes[] = count($this->servico) > 1 ? "SE.id_servico IN (" . implode(',', $this->servico) . ")" : $this->servico[0] == 'todos' ? "SE.id_servico IN (SELECT id_servico FROM for_servico)":"SE.id_servico IN (" . $this->servico[0] . ")";
            }

            if (!empty($this->materialConsumo)) {
                $condicoes[] = count($this->materialConsumo) > 1 ? "MATCON.id_material_consumo IN (" . implode(',', $this->materialConsumo) . ")" : $this->materialConsumo[0] == 'todos' ? "MATCON.id_material_consumo IN (SELECT for_material_consumo.id_material_consumo FROM for_material_consumo)":"MATCON.id_material_consumo IN (" . $this->materialConsumo[0] . ")";
            }

            if (!empty($this->materialPermanente)) {
                $condicoes[] = count($this->materialPermanente) > 1 ? "MATPERM.id_material_permanente IN (" . implode(',', $this->materialPermanente) . ")" : $this->materialPermanente[0] == "todos" ? "MATPERM.id_material_permanente IN (SELECT for_material_permanente.id_material_permanente FROM for_material_permanente)":"MATPERM.id_material_permanente IN (" . $this->materialPermanente[0] . ")";
            }

            if (count($condicoes) > 0) {
                $filtro = "AND " . implode(' AND ', $condicoes);
            } else {
                return FALSE;
            }
//            var_dump($filtro);
//            return;
            $busca = $fornecedores->retornaFornecedores($pdo, $filtro);
            if (empty($busca)) {
                return null;
            } else {
                return $busca;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax('Erro', 'console', $ex->getMessage());
        }
    }
}