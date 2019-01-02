<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesPessoa.class.php";

class Pessoa {

    private $id_pessoa = null;
    private $nm_pessoa = null;
    private $id_naturalidade = null;
    private $ds_logradouro = null;
    private $ds_bairro = null;
    private $ds_complemento = null;
    private $nr_cep = null;
    private $nr_numero = null;
    private $id_cidade = null;
    private $nr_elefone_residencial = null;
    private $nr_telefone_celular = null;
    private $nm_email = null;
    private $nm_senha = null;
    private $ds_observacao = null;
    private $dh_login = null;
    private $st_ativo = null;
    private $st_login = null;
    //**************************************************************************
    private $success = null;
    private $msg = null;

    function getMsg() {
        return $this->msg;
    }

    function setMsg($msg) {
        $this->msg = $msg;
    }

    function getSuccess() {
        return $this->success;
    }

    function setSuccess($success) {
        $this->success = $success;
    }

//*******************************************************************************
    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function getNm_pessoa() {
        return $this->nm_pessoa;
    }

    function getId_naturalidade() {
        return $this->id_naturalidade;
    }

    function getDs_logradouro() {
        return $this->ds_logradouro;
    }

    function getDs_bairro() {
        return $this->ds_bairro;
    }

    function getDs_complemento() {
        return $this->ds_complemento;
    }

    function getNr_cep() {
        return $this->nr_cep;
    }

    /**
     * @return null
     */
    public function getNrNumero()
    {
        return $this->nr_numero;
    }

    /**
     * @param null $nr_numero
     */
    public function setNrNumero($nr_numero)
    {
        $this->nr_numero = $nr_numero;
    }

    function getId_cidade() {
        return $this->id_cidade;
    }

    function getNr_elefone_residencial() {
        return $this->nr_elefone_residencial;
    }

    function getNr_telefone_celular() {
        return $this->nr_telefone_celular;
    }

    function getNm_email() {
        return $this->nm_email;
    }

    function getNm_senha() {
        return $this->nm_senha;
    }

    function getDs_observacao() {
        return $this->ds_observacao;
    }

    function getDh_login() {
        return $this->dh_login;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function getSt_login() {
        return $this->st_login;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setNm_pessoa($nm_pessoa) {
        $this->nm_pessoa = $nm_pessoa;
    }

    function setId_naturalidade($id_naturalidade) {
        $this->id_naturalidade = $id_naturalidade;
    }

    function setDs_logradouro($ds_logradouro) {
        $this->ds_logradouro = $ds_logradouro;
    }

    function setDs_bairro($ds_bairro) {
        $this->ds_bairro = $ds_bairro;
    }

    function setDs_complemento($ds_complemento) {
        $this->ds_complemento = $ds_complemento;
    }

    function setNr_cep($nr_cep) {
        $this->nr_cep = $nr_cep;
    }

    function setId_cidade($id_cidade) {
        $this->id_cidade = $id_cidade;
    }

    function setNr_elefone_residencial($nr_elefone_residencial) {
        $this->nr_elefone_residencial = $nr_elefone_residencial;
    }

    function setNr_telefone_celular($nr_telefone_celular) {
        $this->nr_telefone_celular = $nr_telefone_celular;
    }

    function setNm_email($nm_email) {
        $this->nm_email = $nm_email;
    }

    function setNm_senha($nm_senha) {
        $this->nm_senha = $nm_senha;
    }

    function setDs_observacao($ds_observacao) {
        $this->ds_observacao = $ds_observacao;
    }

    function setDh_login($dh_login) {
        $this->dh_login = $dh_login;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    function setSt_login($st_login) {
        $this->st_login = $st_login;
    }

//*******************************************************************************
    public function cadastrarPessoa($pdo) {
        try {
            $pessoa = new DaoSesPessoa();
            $pessoa->setDsBairro($this->ds_bairro);
            $pessoa->setDsComplemento($this->ds_complemento);
            $pessoa->setDsLogradouro($this->ds_logradouro);
            $pessoa->setDsObservacao($this->ds_observacao);
            $pessoa->setIdCidade($this->id_cidade);
            $pessoa->setIdNaturalidade($this->id_naturalidade);
            $pessoa->setNmPessoa(ucwords(strtolower($this->nm_pessoa)));
            $pessoa->setNrCep($this->nr_cep);
            $pessoa->setNrNumero($this->nr_numero);
            $pessoa->setNrTelefoneCelular($this->nr_telefone_celular);
            $pessoa->setNrTelefoneResidencial($this->nr_elefone_residencial);
            $pessoa->setNmSenha($this->nm_senha);
            //***********************************************************************
            if (empty($this->nm_email)) {
                $pessoa->setNmEmail(null);
            } else {
                if (!Metodos::validaEmail($this->nm_email)) {
                    $this->setSuccess(false);
                    $this->setMsg('O E-mail Informado é Inválido.');
                    $pdo->rollBack();
                    return;
                } else {
                    $validaEmail = $pessoa->validarEmail($pdo, $this->nm_email);
                    if ($validaEmail) {
                        $this->setSuccess(false);
                        $this->setMsg('E-mail Informado Já Está Sendo Utilizado.');
                        $pdo->rollBack();
                        return;
                    } else {
                        $pessoa->setNmEmail($this->nm_email);
                    }
                }
            }

            //*****************************************
            $result = $pessoa->insert($pdo);
            //*****************************************
            if ($result != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($result);
                $pdo->rollBack();
                return;
            }
            $this->setId_pessoa($pdo->lastInsertId('ses_pessoa_id_pessoa_seq'));

            if (Log::SalvaLogI('ses_pessoa', $this->getId_pessoa(), $pdo)) {
                $this->setSuccess(TRUE);
                return;
            } else {
                $this->setSuccess(false);
                $this->setMsg(STR_ERROR);
                $pdo->rollBack();
                return;
            }
        } catch (Exception $exc) {
            //return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
        }
    }

//*******************************************************************************************************
    public function editarPessoa($pdo) {
        try {
            $pessoa = new DaoSesPessoa();
            $pessoa->setIdPessoa($this->id_pessoa);
            $pessoa->setDsBairro($this->ds_bairro);
            $pessoa->setDsComplemento($this->ds_complemento);
            $pessoa->setDsLogradouro($this->ds_logradouro);
            $pessoa->setDsObservacao($this->ds_observacao);
            $pessoa->setIdCidade($this->id_cidade);
            $pessoa->setIdNaturalidade($this->id_naturalidade);
            $pessoa->setNmEmail($this->nm_email);
            $pessoa->setNmPessoa(ucwords(strtolower($this->nm_pessoa)));
            $pessoa->setNrCep($this->nr_cep);
            $pessoa->setNrTelefoneCelular($this->nr_telefone_celular);
            $pessoa->setNrTelefoneResidencial($this->nr_elefone_residencial);

            //***********************************************************************
            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &1 ");
            $validaEmail = $pessoa->validarEmail($pdo, $this->nm_email);
            if ($validaEmail) {
                $this->setSuccess(false);
                $this->setMsg(STR_EMAIL_EXISTE);
                $pdo->rollBack();
                return;
            }
            //print_r($pessoa);
            //*****************************************
            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &3 ");
            $busca = $pessoa->retornaPessoa($pdo);
            //print_r($busca);
            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &4 ");
            if (!$busca) {
                $this->setSuccess(false);
                $this->setMsg($busca);
                $pdo->rollBack();
                return;
            }
            //*****************************************
            $result = $pessoa->update($pdo);
            //*****************************************
            if ($result != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($result);
                $pdo->rollBack();
                return;
            }
            if (Log::SalvaLogU('ses_pessoa', $this->getId_pessoa(), $busca, $pdo)) {
                $this->setSuccess(TRUE);
                return;
            } else {
                $this->setSuccess(false);
                $this->setMsg("ERRO de LOG em UPDATE de PESSOA");
                $pdo->rollBack();
                return;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //*******************************************************************************************************
    public function redefinirSenha() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $pessoa = new DaoSesPessoa();
            $pessoa->setIdPessoa($this->id_pessoa);
            $pessoa->setNmSenha('$2y$14$rnt28R3reooTFh1exTRw9.aF08zbyP2Kio73YxgVeqh/3qZmCPbQ2');

            //***********************************************************************
            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &1 ");

            $busca = $pessoa->retornaPessoa($pdo);
            //print_r($busca);
            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &4 ");

            if (!$busca) {
                $this->setSuccess(false);
                $this->setMsg($busca);
                $pdo->rollBack();
                return;
            }
            //*****************************************
            $result = $pessoa->mudarSenha($pdo);
            //*****************************************
            if ($result != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($result);
                $pdo->rollBack();
                return;
            }

            if (Log::SalvaLogU('ses_pessoa', $this->getId_pessoa(), $busca, $pdo)) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "alert", STR_REDEFINIR_SENHA);
                return $retorno;
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                return $retorno;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function mudarStatusPessoa($pdo) {
        try {
            $pessoa = new DaoSesPessoa();
            $pessoa->setIdPessoa($this->id_pessoa);
            $pessoa->setStAtivo($this->st_ativo);
            $busca = $pessoa->retornaPessoa($pdo);
            if (!$busca) {
                $this->setSuccess(false);
                $this->setMsg($busca);
                $pdo->rollBack();
                return;
            }
            $rs = $pessoa->upadateStatusPessoa($pdo);
            if ($rs != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($rs);
                $pdo->rollBack();
                return;
            }
            //if (Log::SalvaLogI('ses_pessoa', $this->getId_pessoa(), $pdo)) {
            if (Log::SalvaLogU('ses_pessoa', $this->getId_pessoa(), $busca, $pdo)) {
                $this->setSuccess(TRUE);
                return;
            } else {
                $pdo->rollBack();
                $this->getMsg("Erro ao cadastrar Log");
                return ;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //*******************************************
    public function removerPessoa($pdo) {
        try {
            $pessoa = new DaoSesPessoa();
            $pessoa->setIdPessoa($this->id_pessoa);

            $buscaPessoa = $pessoa->retornaPessoa($pdo);
            if ($buscaPessoa != FALSE) {
                if (!Log::SalvaLogD('ses_pessoa', $pessoa->getId_pessoa(), $pdo)) {
                    $pdo->rollBack();
                    $this->setMsg("alert", "Erro ao Cadastrar Log de Pessoa");
                    $this->setSuccess(false);
                    return;
                }
            }
            //***************************************************************************************
            $rs = $pessoa->deletePessoa($pdo);
            if ($rs != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($rs);
                $pdo->rollBack();
                return;
            }
            $this->setSuccess(TRUE);
            return;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPessoa($pdo) {
        try {
            $pessoa = new DaoSesPessoa();
            $pessoa->setIdPessoa($this->id_pessoa);
            $rs = $pessoa->retornaPessoa($pdo);
            if ($rs != FALSE) {
                if ($this->msg != "contrato") {
                    $retorno[] = array(
                        "id_pessoa" => $rs["id_pessoa"],
                        "nm_pessoa" => $rs["nm_pessoa"],
                        "id_naturalidade" => $rs["id_naturalidade"],
                        "id_estado_naturalidade" => $rs["id_estado_naturalidade"],
                        "id_pais_naturalidade" => $rs["id_pais_naturalidade"],
                        "ds_logradouro" => $rs["ds_logradouro"],
                        "ds_bairro" => $rs["ds_bairro"],
                        "ds_complemento" => $rs["ds_complemento"],
                        "nr_cep" => $rs["nr_cep"],
                        "id_cidade_endereco" => $rs["id_cidade_endereco"],
                        "id_estado_endereco" => $rs["id_estado_endereco"],
                        "id_pais_endereco" => $rs["id_pais_endereco"],
                        "nr_telefone_residencial" => $rs["nr_telefone_residencial"],
                        "nr_telefone_celular" => $rs["nr_telefone_celular"],
                        "nm_email" => $rs["nm_email"],
                        "ds_observacao" => $rs["ds_observacao"],
                        "nm_senha" => $rs["nm_senha"],
                        "dh_login" => $rs["dh_login"],
                        "st_login" => $rs["st_login"],
                        "st_ativo" => $rs["st_ativo"]
                    );
                    return json_encode($retorno);
                } else {

                    return $rs;
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaOptionPessoa() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pessoa = new DaoSesPessoa();
            $result = $pessoa->retornaTodosFuncionarios($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_pessoa'] . "'>" . $v['nm_pessoa'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    //********************************************* Desativar Login da Pessoa ******************************************
    public function desativarLogin() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $pessoa = new DaoSesPessoa();
            $pessoa->setIdPessoa($this->id_pessoa);

            $busca = $pessoa->retornaPessoa($pdo);

            if ($busca == false) {
                return Metodos::retornoAjax('Erro', 'alert', STR_NAO_ENCONTRADO);
            } else {
                $desativa = $pessoa->desativarLoginPessoa($pdo);
                if ($desativa) {
                    if (!Log::SalvaLogU('ses_pessoa', $this->id_pessoa, $busca, $pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $pdo->commit();
                        return Metodos::retornoAjax('ok', 'html', 'Login Desativado Com Sucesso.');
                    }
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax('Erro', 'console', $desativa);
                }
            }
        } catch (Exception $erro) {
            return Metodos::retornoAjax("Erro", "console", $erro->getMessage());
        }
    }
    //******************************************************************************************************************

    //********************************************** Ativar Login da Pessoa ********************************************
    public function ativarLogin() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $pessoa = new DaoSesPessoa();
            $pessoa->setIdPessoa($this->id_pessoa);

            $busca = $pessoa->retornaPessoa($pdo);
            if ($busca == false) {
                return Metodos::retornoAjax('Erro', 'alert', STR_NAO_ENCONTRADO);
            } else {
                $ativa = $pessoa->ativarLoginPessoa($pdo);
                if ($ativa) {
                    if (!Log::SalvaLogU('ses_pessoa', $this->id_pessoa, $busca, $pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $pdo->commit();
                        return Metodos::retornoAjax('ok', 'html', 'Login Ativado Com Sucesso.');
                    }
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax('Erro', 'console', $ativa);
                }
            }
        } catch (Exception $erro) {
            return Metodos::retornoAjax("Erro", "console", $erro->getMessage());
        }
    }
    //******************************************************************************************************************
}

?>
