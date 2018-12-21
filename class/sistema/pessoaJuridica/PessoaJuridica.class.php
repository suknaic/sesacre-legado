<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesPessoaJuridica.class.php";

class pessoaJuridica {

    //**************************************************************************
    private $id_pessoa_juridica = null;
    private $id_pessoa = null;
    private $nm_fantasia = null;
    private $nr_cnae = null;
    private $nr_cnpj = null;
    private $ds_insc_estadual = null;
    private $ds_insc_municipal = null;
    private $dt_fundacao = null;
    private $id_natureza = null;
    private $nr_safira = null;

    //**************************************************************************
    function getNr_safira() {
        return $this->nr_safira;
    }

    function setNr_safira($nr_safira) {
        $this->nr_safira = $nr_safira;
    }

    function getId_natureza() {
        return $this->id_natureza;
    }

    function setId_natureza($id_natureza) {
        $this->id_natureza = $id_natureza;
    }

    function getNm_fantasia() {
        return $this->nm_fantasia;
    }

    function setNm_fantasia($nm_fantasia) {
        $this->nm_fantasia = $nm_fantasia;
    }

    function getId_pessoa_juridica() {
        return $this->id_pessoa_juridica;
    }

    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function getNr_cnae() {
        return $this->nr_cnae;
    }

    function getNr_cnpj() {
        return $this->nr_cnpj;
    }

    function getDs_insc_estadual() {
        return $this->ds_insc_estadual;
    }

    function getDs_insc_municipal() {
        return $this->ds_insc_municipal;
    }

    function getDt_fundacao() {
        return $this->dt_fundacao;
    }

    function setId_pessoa_juridica($id_pessoa_juridica) {
        $this->id_pessoa_juridica = $id_pessoa_juridica;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setNr_cnae($nr_cnae) {
        $this->nr_cnae = $nr_cnae;
    }

    function setNr_cnpj($nr_cnpj) {
        $this->nr_cnpj = $nr_cnpj;
    }

    function setDs_insc_estadual($ds_insc_estadual) {
        $this->ds_insc_estadual = $ds_insc_estadual;
    }

    function setDs_insc_municipal($ds_insc_municipal) {
        $this->ds_insc_municipal = $ds_insc_municipal;
    }

    function setDt_fundacao($dt_fundacao) {
        $this->dt_fundacao = $dt_fundacao;
    }

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
    //*************************************************************************
    public function cadastrarPessoaJuridica($pdo) {
        try {
            $sucesso = false;

            $pessoaJuridica = new DaoSesPessoaJuridica();
            $pessoaJuridica->setNm_fantasia(ucwords(strtolower($this->nm_fantasia)));
            $pessoaJuridica->setId_natureza($this->id_natureza);
            $pessoaJuridica->setNr_cnpj($this->nr_cnpj);
            $pessoaJuridica->setNr_cnae($this->nr_cnae);
            $pessoaJuridica->setNr_safira($this->nr_safira);
            $pessoaJuridica->setDs_insc_estadual($this->ds_insc_estadual);
            $pessoaJuridica->setDs_insc_municipal($this->ds_insc_municipal);
            $pessoaJuridica->setDt_fundacao($this->dt_fundacao);
            $pessoaJuridica->setId_pessoa($this->id_pessoa);
            //***********************************************************************

            //******************************************** Valida cnpj *************************************************
            if (!Metodos::validaCNPJ($this->nr_cnpj)) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', 'O CNPJ informado é inválido.');
            }
            //**********************************************************************************************************

            //**************************** Verifica a existencia do cnpj na base de dados ******************************
            $validaCnpj = $pessoaJuridica->validarCnpj($pdo);
            if ($validaCnpj) {
                $this->setSuccess(false);
                $this->setMsg(STR_CNPJ_EXISTE);
                $pdo->rollBack();
                return;
            }
            //**********************************************************************************************************

            //**************************************** Valida a data da fundação ***************************************
            if (!empty($this->dt_fundacao)) {
                $dtFund = explode('/', $this->dt_fundacao);
                $d = $dtFund[0];
                $m = $dtFund[1];
                $y = $dtFund[2];
                if (!checkdate($m, $d, $y)) {
                    return Metodos::retornoAjax('Erro', 'alert', 'A data da fundação informada é inválida.');
                }
            }
            //**********************************************************************************************************

            //*****************************************
            $result = $pessoaJuridica->insert($pdo);
            //*****************************************
            if ($result != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($result);
                $pdo->rollBack();
                return;
            }
            $this->setId_pessoa_juridica($pdo->lastInsertId('ses_pessoa_juridica_id_pessoa_juridica_seq'));

            if (Log::SalvaLogI('ses_pessoa_juridica', $this->getId_pessoa_juridica(), $pdo)) {
                $this->setSuccess(TRUE);
                return;
            } else {
                $this->setSuccess(false);
                $this->setMsg(STR_ERROR);
                $pdo->rollBack();
                return;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    public function cadastrarCompetencia($pdo) {
        try {

            $pessoaJuridica = new DaoSesPessoaJuridica();
            $pessoaJuridica->setId_escolaridade_formacao_competencia($this->id_escolaridade_formacao_competencia);
            $pessoaJuridica->setId_pessoa_fisica($this->id_pessoa_fisica);
//          ****************************************************************************
            $result = $pessoaJuridica->insertCompetencia($pdo);
//          ****************************************************************************
            if ($result != "Sucesso") {
                $sucesso = false;
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                return $retorno;
            }

            $idCompetencia = $pdo->lastInsertId('ses_competencia_id_competencia_seq');
            if (!(Log::SalvaLogI('ses_competencia', $idCompetencia, $pdo))) {
                $retorno = Metodos::retornoAjax("Erro", "console", $idCompetencia);
                return $retorno;
            }
            return $result;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaCompetencia($idPessoaJuridica) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pessoaJuridica = new DaoSesPessoaJuridica();
            $pessoaJuridica->setId_pessoa_fisica($idPessoaJuridica);
            $rs = $pessoaJuridica->retornaCompetencia($pdo);
//          ****************************************************************************
            if ($rs != FALSE) {
                foreach ($rs as $linha) {
                    echo "  <tr class='warning competenciaLinha' idPf= '" . $idPessoaJuridica . "'>
                                <td class='text-center escolaridade' idEscolaridadeFormacao='" . $linha['id_escolaridade_formacao'] . "'>" . $linha['nm_escolaridade_formacao'] . "</td>\n\
                                <td class='text-center'>" . $linha['nm_escolaridade'] . "</td>\n\
                                <td class='text-center'><button type='button' title='Remover' class='excluirLinha' value= " . $linha['id_competencia'] . "><i class='fa fa-remove text-danger'></i></button></td>\n\
                            </tr>";
                }
            } else {
                return $rs;
            }

//          ****************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPessoaJuridica($pdo) {
        try {
            $pessoaJuridica = new DaoSesPessoaJuridica();
            $pessoaJuridica->setId_pessoa_juridica($this->id_pessoa_juridica);

            $rs = $pessoaJuridica->retornaPessoaJuridica($pdo);
            if ($rs != FALSE) {
                return $rs;
            }
            return FALSE;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPJ($pdo) {
        try {
            $pessoaJuridica = new DaoSesPessoaJuridica();
            $pessoaJuridica->setId_pessoa($this->id_pessoa);

            $rs = $pessoaJuridica->retornaPJ($pdo);
            if ($rs != FALSE) {
                return true;
            }
            return FALSE;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarPessoaJuridica($pdo) {
        try {
            $sucesso = false;
            //**************************************
            $pessoaJuridica = new DaoSesPessoaJuridica();
            $pessoaJuridica->setId_pessoa_juridica($this->id_pessoa_juridica);
            $pessoaJuridica->setNm_fantasia(ucwords(strtolower($this->nm_fantasia)));
            $pessoaJuridica->setId_natureza($this->id_natureza);
            $pessoaJuridica->setNr_cnpj($this->nr_cnpj);
            $pessoaJuridica->setNr_cnae($this->nr_cnae);
            $pessoaJuridica->setNr_safira($this->nr_safira);
            $pessoaJuridica->setDs_insc_estadual($this->ds_insc_estadual);
            $pessoaJuridica->setDs_insc_municipal($this->ds_insc_municipal);
            $pessoaJuridica->setDt_fundacao($this->dt_fundacao);
            $pessoaJuridica->setId_pessoa($this->id_pessoa);
            //***********************************************************************
            $validaCnpj = $pessoaJuridica->validarCnpj($pdo);
            if ($validaCnpj) {
                $this->setSuccess(false);
                $this->setMsg(STR_CNPJ_EXISTE);
                $pdo->rollBack();
                return;
            }

            //*************************************************************************
            $busca = $pessoaJuridica->retornaPessoaJuridica($pdo);

            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &4 ");
            if (!$busca) {
                $this->setSuccess(false);
                $this->setMsg("Erro ao Buscar Pessoa Jurídica");
                $pdo->rollBack();
                return;
            }
            //*****************************************
            $result = $pessoaJuridica->update($pdo);
            //*****************************************
            if ($result != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($result);
                $pdo->rollBack();
                return;
            }
            if (Log::SalvaLogU('ses_pessoa_juridica', $this->getId_pessoa_juridica(), $busca, $pdo)) {
                $this->setSuccess(TRUE);
                return;
            } else {
                $this->setSuccess(false);
                $this->setMsg("ERRO de LOG em UPDATE de PESSOA JURÍDICA");
                $pdo->rollBack();
                return;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//***********************************************************************************************
    public function removerPessoaJuridica() {
        try {
            //***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $pessoaJuridica = new DaoSesPessoaJuridica();
            $pessoaJuridica->setId_pessoa($this->id_pessoa);
            $pessoaJuridica->setId_pessoa_juridica($this->id_pessoa_juridica);
            //**************************************************************************************************
            $buscaPessoaJurica = $pessoaJuridica->retornaPessoaJuridicaCadastrada($pdo);
            if ($buscaPessoaJurica != FALSE) {
                if (!Log::SalvaLogD('ses_pessoa_juridica', $pessoaJuridica->getId_pessoa_juridica(), $pdo)) {
                    $pdo->rollBack();
                    return retornoAjax("Erro", "alert", "Erro ao Cadastrar Log de Pessoa Fisica");
                }
            }
            //***************************************************************************************
            $rs = $pessoaJuridica->deletePessoaJuridica($pdo);
            if ($rs != "Sucesso") {
                $pdo->rollBack();
                if ($rs->getCode() == 23503) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Registro está vinculado a outro registro.");
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $rs->getMessage());
                }
            }
            //***************remove pessoa*********************************************************
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($this->id_pessoa);
            $pessoa->removerPessoa($pdo);
            if ($pessoa->getSuccess()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", $pessoa->getMsg());
            }

            return $retorno;
            //***********************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//***********************************************************************************************
    public function retornaTrPessoaJuridica($nome, $cnpj) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesPessoaJuridica;
            $filtro = "";
//*********************************************************************
            $filter = array();
            if (!empty($nome)) {
                $filter[] = "unaccent(P.nm_pessoa) ilike '%$nome%'";
            }
            if (!empty($cnpj)) {
                $filter[] = "PJ.nr_cnpj = '".Metodos::formataCnpj($cnpj)."'";
            }
            if (count($filter) > 0) {
                $filtro = " where " . implode(' and ', $filter);
            }
            if ($filtro == "") {
                return false;
            }
            //********************************************************
            $result = $rh->retornaTrPessoaJuridica($pdo, $filtro);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $cnpj = Metodos::formataCnpj($v['nr_cnpj']);
                    $idPessoa = $v['id_pessoa'];
                    $idPessoaJuridica = $v['id_pessoa_juridica'];
                    $icone = "";
                    $title = "";
                    if ($v['st_ativo'] == '0') {
                        $icone = "<i class='fa fa-user text-success' aria-hidden='true'></i>";
                        $title = "title='Ativar Pessoa'";
                    }
                    if ($v['st_ativo'] == '1') {
                        $icone = "<i class='fa fa-user-times text-danger' aria-hidden='true'></i>";
                        $title = "title='Desativar Pessoa'";
                    }
                    $retorno .= "<tr>";
                    $retorno .= "   <td>" . $v['nm_pessoa'] . "</td>
                                    <td>" . $cnpj . "</td>";
                    if ($v['nm_cidade'] != '') {
                        $retorno .= "   <td>" . $v['nm_sigla'] . " - " . $v['nm_cidade'] . "</td>";
                    } else {
                        $retorno .= "   <td></td>";
                    }
                    $retorno .= "   <td>" . $v['ds_logradouro'] . "</td>   
                                    <td>" . $v['ds_bairro'] . "</td>
                                    <td>" . ($v['nr_telefone_residencial'] === NULL ? "" : Metodos::formataTelefone($v['nr_telefone_residencial'])) . "</td>
                                    <td>" . ($v['nr_telefone_celular'] === NULL ? "" : Metodos::formataCelular($v['nr_telefone_celular'])) . "</td>
                                    <td>" . $v['nm_email'] . "</td>
                                    <td style='text-align: center;'>                           
                                        <button type='button' class='btn btn-default btn-edit btn-xs'                               
                                              title='Editar' nome='" . $v['nm_pessoa'] . "' value='2-" . $idPessoaJuridica . "' >
                                               <i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>                                
                                        </button> 
                                        <button type='button' class='btn btn-default btn-remover btn-xs' title='Remover' value='2-" . $idPessoa . "-" . $idPessoaJuridica . "'>
                                            <i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>
                                        </button>
                                        <button type='button' class='btn btn-default btn-desativar btn-xs' $title value='2-" . $idPessoa . "-" . $idPessoaJuridica . "-" . $v['st_ativo'] . "'>
                                            $icone
                                        </button>
                                    </td>
                                 </tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

//***********************************************************************************************
    public function listaPessoaJuridica($nome) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesPessoaJuridica;
            $filtro = "";
//*********************************************************************
            $filter = array();
            if (!empty($nome)) {
                $filter[] = "unaccent(lower(P.nm_pessoa)) ilike '%$nome%'";
            }
            if (count($filter) > 0) {
                $filtro = " where " . implode(' and ', $filter);
            }
            if ($filtro == "") {
                return false;
            }
            //********************************************************
            $result = $rh->retornaTrPessoaJuridicaAtivos($pdo, $filtro);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $cnpj = Metodos::formataCnpj($v['nr_cnpj']);
                    $idPessoa = $v['id_pessoa'];
                    $idPessoaJuridica = $v['id_pessoa_juridica'];
                    $retorno .= "<tr class='pessoa' idPessoa='$idPessoa' idPessoa2='$idPessoaJuridica' style='cursor:pointer;'>";
                    $retorno .= "   <td>" . $v['nm_pessoa'] . "</td>
                                    <td>" . $cnpj . "</td>
                                 </tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    //****************************************************************
    public function retornaOptionPj() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesPessoaJuridica();
            $result = $cidade->listaPessoaJuridica($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_pessoa_juridica'] . "'>" . $v['nm_pessoa'] . " / " . $v['nm_fantasia'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    //************************************************************************************************************************
    public function retornaNatureza($id = null) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $natureza = new DaoSesPessoaJuridica();
            $result = $natureza->listaNatureza($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($v['id_natureza'] == $id) {
                        $retorno .= "<option selected value = '" . $v['id_natureza'] . "'>" . $v['ds_natureza'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_natureza'] . "'>" . $v['ds_natureza'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
