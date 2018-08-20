<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/formacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesPessoaFisica.class.php";

class pessoaFisica {

    private $id_pessoa = null;
//**************************************************************************
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
    private $lk_foto = null;
    private $st_ativo = null;
//**************************************************************************
    private $id_escolaridade_formacao_competencia = null;

//**************************************************************************
    function getId_escolaridade_formacao_competencia() {
        return $this->id_escolaridade_formacao_competencia;
    }

    function setId_escolaridade_formacao_competencia($id_escolaridade_formacao_competencia) {
        $this->id_escolaridade_formacao_competencia = $id_escolaridade_formacao_competencia;
    }

//**************************************************************************
    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

//*************************************************************************
    function getId_pessoa_fisica() {
        return $this->id_pessoa_fisica;
    }

    function getTp_sexo() {
        return $this->tp_sexo;
    }

    function getNm_civil() {
        return $this->nm_civil;
    }

    function getNr_cpf() {
        return $this->nr_cpf;
    }

    function getNr_rg() {
        return $this->nr_rg;
    }

    function getDs_orgao_expedidor() {
        return $this->ds_orgao_expedidor;
    }

    function getId_estado_expedidor() {
        return $this->id_estado_expedidor;
    }

    function getId_estado_civil() {
        return $this->id_estado_civil;
    }

    function getId_escolaridade_formacao() {
        return $this->id_escolaridade_formacao;
    }

    function getDs_habilidade() {
        return $this->ds_habilidade;
    }

    function getNm_pai() {
        return $this->nm_pai;
    }

    function getNm_mae() {
        return $this->nm_mae;
    }

    function getDt_nascimento() {
        return $this->dt_nascimento;
    }

    function getNr_cns() {
        return $this->nr_cns;
    }

    function getLk_foto() {
        return $this->lk_foto;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_pessoa_fisica($id_pessoa_fisica) {
        $this->id_pessoa_fisica = $id_pessoa_fisica;
    }

    function setTp_sexo($tp_sexo) {
        $this->tp_sexo = $tp_sexo;
    }

    function setNm_civil($nm_civil) {
        $this->nm_civil = $nm_civil;
    }

    function setNr_cpf($nr_cpf) {
        $this->nr_cpf = $nr_cpf;
    }

    function setNr_rg($nr_rg) {
        $this->nr_rg = $nr_rg;
    }

    function setDs_orgao_expedidor($ds_orgao_expedidor) {
        $this->ds_orgao_expedidor = $ds_orgao_expedidor;
    }

    function setId_estado_expedidor($id_estado_expedidor) {
        $this->id_estado_expedidor = $id_estado_expedidor;
    }

    function setId_estado_civil($id_estado_civil) {
        $this->id_estado_civil = $id_estado_civil;
    }

    function setId_escolaridade_formacao($id_escolaridade_formacao) {
        $this->id_escolaridade_formacao = $id_escolaridade_formacao;
    }

    function setDs_habilidade($ds_habilidade) {
        $this->ds_habilidade = $ds_habilidade;
    }

    function setNm_pai($nm_pai) {
        $this->nm_pai = $nm_pai;
    }

    function setNm_mae($nm_mae) {
        $this->nm_mae = $nm_mae;
    }

    function setDt_nascimento($dt_nascimento) {
        $this->dt_nascimento = $dt_nascimento;
    }

    function setNr_cns($nr_cns) {
        $this->nr_cns = $nr_cns;
    }

    function setLk_foto($lk_foto) {
        $this->lk_foto = $lk_foto;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
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
    public function cadastrarPessoaFisica($pdo) {
        try {
            $sucesso = false;

            $pessoaFisica = new DaoSesPessoaFisica();
            $pessoaFisica->setDs_habilidade($this->ds_habilidade);
            $pessoaFisica->setDs_orgao_expedidor($this->ds_orgao_expedidor);
            $pessoaFisica->setDt_nascimento($this->dt_nascimento);
            $pessoaFisica->setId_escolaridade_formacao($this->id_escolaridade_formacao);
            $pessoaFisica->setId_estado_civil($this->id_estado_civil);
            $pessoaFisica->setId_estado_expedidor($this->id_estado_expedidor);
            $pessoaFisica->setId_pessoa($this->id_pessoa);
            $pessoaFisica->setNm_civil(ucwords(strtolower($this->nm_civil)));
            $pessoaFisica->setNm_mae(ucwords(strtolower($this->nm_mae)));
            $pessoaFisica->setNm_pai(ucwords(strtolower($this->nm_pai)));
            $pessoaFisica->setNr_cns($this->nr_cns);
            $pessoaFisica->setNr_cpf($this->nr_cpf);
            $pessoaFisica->setNr_rg($this->nr_rg);
            $pessoaFisica->setTp_sexo($this->tp_sexo);
//***********************************************************************
            $validaCpf = $pessoaFisica->validarCpf($pdo, $this->nr_cpf);
            if ($validaCpf) {
                $this->setSuccess(false);
                $this->setMsg(STR_CPF_EXISTE);
                $pdo->rollBack();
                return;
            }
//************************************************************************
            print_r(new DateTime());
            $pdo->rollBack();
            return;
//            if ($this->dt_nascimento > date('d:m:Y')new DateTime();) {
//                $this->setSuccess(false);
//                $this->setMsg('Data de Nascimento é Maior que a Data Atual.');
//                $pdo->rollBack();
//                return;
//            }
//*****************************************
            $result = $pessoaFisica->insert($pdo);
//*****************************************
            if ($result != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($result);
                $pdo->rollBack();
                return;
            }
            $this->setId_pessoa_fisica($pdo->lastInsertId('ses_pessoa_fisica_id_pessoa_fisica_seq'));

            if (Log::SalvaLogI('ses_pessoa_fisica', $this->getId_pessoa_fisica(), $pdo)) {
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
            return false;
        }
    }

    /**
     * @param $pdo
     * @return type|void
     */
    public function cadastrarCompetencia($pdo, $escolaridade = null) {
        try {

            $pessoaFisica = new DaoSesPessoaFisica();
            $pessoaFisica->setId_escolaridade_formacao_competencia($this->id_escolaridade_formacao_competencia);
            $pessoaFisica->setId_pessoa_fisica($this->id_pessoa_fisica);

            $formacao = new Formacao();
            $formacao->setId_formacao($this->id_escolaridade_formacao_competencia);
            $resultado = $formacao->retornarFormacao($pdo);

            if ($resultado['id_escolaridade'] != $escolaridade){
                return Metodos::retornoAjax('Erro', 'alert', 'Curso Não Corresponde ao Nível de Escolaridade.');
            }
//          ****************************************************************************
            $result = $pessoaFisica->insertCompetencia($pdo);
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

    public function retornaCompetencia($dadosPessoa) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pessoaFisica = new DaoSesPessoaFisica();
            $pessoaFisica->setId_pessoa_fisica($dadosPessoa['id_pessoa_fisica']);
            $rs = $pessoaFisica->retornaCompetencia($pdo);
//          ****************************************************************************
            $disabled = "";
            //$disabled = $dadosPessoa['contrato'] == 1? "disabled=''":"";
            //**************************************************************************
            if ($rs != FALSE) {
                foreach ($rs as $linha) {
                    echo "  <tr class='warning competenciaLinha' idPf= '" . $dadosPessoa['id_pessoa_fisica'] . "'>
                                <td class='text-center escolaridade' idEscolaridadeFormacao='" . $linha['id_escolaridade_formacao'] . "'>" . $linha['nm_escolaridade_formacao'] . "</td>\n\
                                <td class='text-center'>" . $linha['nm_escolaridade'] . "</td>\n\
                                <td class='text-center'><button type='button' title='Remover' class='excluirLinha' value= " . $linha['id_competencia'] . " $disabled><i class='fa fa-remove text-danger'></i></button></td>\n\
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

    public function retornaPessoaFisica($pdo) {
        try {
            $pessoaFisica = new DaoSesPessoaFisica();
            if (empty($this->nr_cpf)) {
                $pessoaFisica->setId_pessoa_fisica($this->id_pessoa_fisica);
            } else {
                $pessoaFisica->setNr_cpf($this->nr_cpf);
            }
            $rs = $pessoaFisica->retornaPessoaFisica($pdo);

            if ($rs != FALSE) {
                if ($this->msg != "contrato") {
                    $retorno[] = array("id_pessoa" => $rs["id_pessoa"],
                        "id_pessoa_fisica" => $rs["id_pessoa_fisica"],
                        "tp_sexo" => $rs["tp_sexo"],
                        "nm_civil" => $rs["nm_pessoa"],
                        "nr_cpf" => $rs["nr_cpf"],
                        "nr_rg" => $rs["nr_rg"],
                        "ds_orgao_expedidor" => $rs["ds_orgao_expedidor"],
                        "ds_habilidade" => $rs["ds_habilidade"],
                        "id_estado_orgao_expedidor" => $rs["id_estado_orgao_expedidor"],
                        "id_estado_civil" => $rs["id_estado_civil"],
                        "nm_mae" => $rs["nm_mae"],
                        "nm_pai" => $rs["nm_pai"],
                        "dt_nascimento" => $rs["dt_nascimento"] == "" ? $rs["dt_nascimento"] : date("d/m/Y", strtotime($rs["dt_nascimento"])),
                        "nr_cns" => $rs["nr_cns"],
                        "id_escolaridade" => $rs["id_escolaridade"],
                        "st_ativo" => $rs["st_ativo"],
                    );
                    return json_encode($retorno);
                } else {

                    return $rs;
                }
            }
            return FALSE;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPf($pdo) {

        try {

            $pessoaFisica = new DaoSesPessoaFisica();
            $pessoaFisica->setId_pessoa($this->id_pessoa);

            $rs = $pessoaFisica->BuscaPf($pdo);
            if ($rs != FALSE) {
                return $rs;
            }
            return FALSE;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarPessoaFisica($pdo) {
        try {
            $sucesso = false;
//**************************************
            $pessoaFisica = new DaoSesPessoaFisica();
            $pessoaFisica->setId_pessoa_fisica($this->id_pessoa_fisica);
            $pessoaFisica->setDs_habilidade($this->ds_habilidade);
            $pessoaFisica->setDs_orgao_expedidor($this->ds_orgao_expedidor);
            $pessoaFisica->setDt_nascimento($this->dt_nascimento);
            $pessoaFisica->setId_escolaridade_formacao($this->id_escolaridade_formacao);
            $pessoaFisica->setId_estado_civil($this->id_estado_civil);
            $pessoaFisica->setId_estado_expedidor($this->id_estado_expedidor);
            $pessoaFisica->setId_pessoa($this->id_pessoa);
            $pessoaFisica->setNm_civil(ucwords(strtolower($this->nm_civil)));
            $pessoaFisica->setNm_mae($this->nm_mae);
            $pessoaFisica->setNm_pai($this->nm_pai);
            $pessoaFisica->setNr_cns($this->nr_cns);
            $pessoaFisica->setNr_cpf($this->nr_cpf);
            $pessoaFisica->setNr_rg($this->nr_rg);
            $pessoaFisica->setTp_sexo($this->tp_sexo);

//***********************************************************************
            $validaCpf = $pessoaFisica->validarCpf($pdo, $this->nr_cpf);
//******************************************
            if ($validaCpf) {
                $this->setSuccess(false);
                $this->setMsg(STR_CPF_EXISTE);
                $pdo->rollBack();
                return;
            }
//************************************************************************
            $dtNascimento = strtotime(Metodos::ConverteDataING($this->dt_nascimento));
            $dtAtual =strtotime(date("d-m-Y"));
            if ($dtNascimento >= $dtAtual) {
                $this->setSuccess(false);
                $this->setMsg('Data de Nascimento é Maior ou Igual a Data Atual.');
                $pdo->rollBack();
                return;
            }
//*************************************************************************
            $busca = $pessoaFisica->retornaPessoaFisica($pdo);
//print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &4 ");
            if (!$busca) {

                $this->setSuccess(false);
                $this->setMsg("Erro ao Buscar Pessoa Física");
                $pdo->rollBack();
                return;
            }
//*****************************************
            $result = $pessoaFisica->update($pdo);
//*****************************************
            if ($result != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($result);
                $pdo->rollBack();
                return;
            }

            if (Log::SalvaLogU('ses_pessoa_fisica', $this->getId_pessoa_fisica(), $busca, $pdo)) {
                $this->setSuccess(TRUE);
                return;
            } else {
                $this->setSuccess(false);
                $this->setMsg("ERRO de LOG em UPDATE de PESSOA FISICA");
                $pdo->rollBack();
                return;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerCompetencia($idCompetencia) {
        try {
            $retorno = "";
//***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pessoaFisica = new DaoSesPessoaFisica();
            $pessoaFisica->setId_competencia($idCompetencia);
//************************************************************************************
            $busca = $pessoaFisica->buscaCompetencia($pdo);
            if ($busca != FALSE) {
                if (!Log::SalvaLogD('ses_competencia', $pessoaFisica->getId_competencia(), $pdo)) {
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                }
            }
//************************************************************************************
            $rs = $pessoaFisica->removerCompetencia($pdo);

            return $retorno;
//***********************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//***********************************************************************************************
    public function removerPessoaFisica() {
        try {
            //***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $pessoaFisica = new DaoSesPessoaFisica();
            $pessoaFisica->setId_pessoa_fisica($this->id_pessoa_fisica);
            //************************************************************************************
            $competencias = $pessoaFisica->retornaCompetencia($pdo);
            if ($competencias != FALSE) {
                foreach ($competencias as $linha) {
                    $pessoaFisica->setId_competencia($linha['id_competencia']);
                    $buscaCompetencia = $pessoaFisica->buscaCompetencia($pdo);
                    if ($buscaCompetencia != FALSE) {
                        if (!Log::SalvaLogD('ses_competencia', $pessoaFisica->getId_competencia(), $pdo)) {
                            $pdo->rollBack();
                            return retornoAjax("Erro", "alert", "Erro ao Cadastrar Log de Competência");
                        }
                    }
                }
            }
            $removercompetencia = $pessoaFisica->removerCompetencias($pdo);
            //**************************************************************************************************
            $buscaPessoaFisica = $pessoaFisica->retornaPessoaFisica($pdo);
            if ($buscaPessoaFisica != FALSE) {
                if (!Log::SalvaLogD('ses_pessoa_fisica', $pessoaFisica->getId_pessoa_fisica(), $pdo)) {
                    $pdo->rollBack();
                    return retornoAjax("Erro", "alert", "Erro ao Cadastrar Log de Pessoa Fisica");
                }
            }
            //***************************************************************************************
            $rs = $pessoaFisica->deletePessoaFisica($pdo);
            if ($rs != "Sucesso") {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $rs);
            }
            //***************remove pessoa*********************************************************
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($this->id_pessoa);
            $rs1 = $pessoa->removerPessoa($pdo);
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
    public function mudarStatusPessoaFisica() {
        try {
            //***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $pessoaFisica = new DaoSesPessoaFisica();
            $st_ativo = '';
            if ($this->st_ativo == '0') {
                $st_ativo = '1';
            }
            if ($this->st_ativo == '1') {
                $st_ativo = '0';
            }
            $pessoaFisica->setId_pessoa_fisica($this->id_pessoa_fisica);
            $pessoaFisica->setSt_ativo($st_ativo);
            $rs = $pessoaFisica->updateStatusPessoaFisica($pdo);
            if ($rs != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $rs);
                $pdo->rollBack();
            }

//***********************************************************************
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($this->id_pessoa);
            $pessoa->setSt_ativo($st_ativo);
            $rs1 = $pessoa->mudarStatusPessoa($pdo);
            if ($pessoa->getSuccess()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Realizado Com Sucesso");
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", $pessoa->getMsg());
            }

            return $retorno;
//***********************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTrPessoaFisica($nome, $cpf) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesPessoaFisica;
            $filtro = "";
//*********************************************************************
            $filter = array();
            if (!empty($nome)) {
                $filter[] = "P.nm_pessoa ilike '%$nome%'";
            }
            if (!empty($cpf)) {
                $filter[] = "PF.nr_cpf = '$cpf'";
            }
            if (count($filter) > 0) {
                $filtro = " and " . implode(' and ', $filter);
            }
            if ($filtro == "") {
                return false;
            }
//********************************************************
            $result = $rh->retornaTrPessoaFisica($pdo, $filtro);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $cpf2 = Metodos::formataCpf($v['nr_cpf']);
//******************************************************************
                    $idPessoa = $v['id_pessoa'];
                    $idPessoaFj = $v['id_pessoa_fisica'];
                    $retorno .= "<tr>";
//****************************************************************
                    $icone = "";
                    $title = "";
                    if ($v['st_ativo'] == '0') {
                        $icone = "<i class='fa fa-user-times text-default' aria-hidden='true'></i>";
                        $title = "title='Ativar Pessoa'";
                    }
                    if ($v['st_ativo'] == '1') {
                        $icone = "<i class='fa fa-user text-success' aria-hidden='true'></i>";
                        $title = "title='Inativar Pessoa'";
                    }
//*************************************************************
                    $retorno .= "   <td>" . $v['nm_pessoa'] . "</td>
                                    <td>" . $cpf2 . "</td>
                                    <td>" . $v['nm_sigla'] . " - " . $v['nm_cidade'] . "</td>
                                    <td>" . $v['ds_logradouro'] . "</td>   
                                    <td>" . $v['ds_bairro'] . "</td>
                                    <td>" . ($v['nr_telefone_residencial'] === NULL ? "" : Metodos::formataTelefone($v['nr_telefone_residencial'])) . "</td>
                                    <td>" . ($v['nr_telefone_celular'] === NULL ? "" : Metodos::formataCelular($v['nr_telefone_celular'])) . "</td>
                                    <td>" . $v['nm_email'] . "</td>
                                    <td style='text-align: center;'>                           
                                        <button type='button' class='btn btn-default btn-edit btn-xs'                               
                                              title='Editar' nome='" . $v['nm_pessoa'] . "' value='1-" . $idPessoaFj . "' >
                                               <i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>                                
                                        </button> 
                                        <button type='button' class='btn btn-default btn-remover btn-xs' title='Remover' value='1-" . $idPessoa . "-" . $idPessoaFj . "'>
                                            <i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>
                                        </button>
                                        <button type='button' class='btn btn-default btn-redefinir btn-xs' title='Redefinir Senha' value='" . $idPessoa . "'>
                                            <i class='fa fa-key fa-lg text-warning' aria-hidden='true'></i>
                                        </button>
                                        <button type='button' class='btn btn-default btn-inativar btn-xs' $title value='1-" . $idPessoa . "-" . $idPessoaFj . "-" . $v['st_ativo'] . "'>
                                            $icone
                                        </button>
                                    </td>
                                 </tr>";
//        $retorno .= "</tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function listaPessoaFisica($nome) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesPessoaFisica;
            $filtro = "";
//*********************************************************************
            $filter = array();
            if (!empty($nome)) {
                $filter[] = "P.nm_pessoa ilike '%$nome%'";
            }
            if (count($filter) > 0) {
                $filtro = " and " . implode(' and ', $filter);
            }
            if ($filtro == "") {
                return false;
            }
//********************************************************
            $result = $rh->retornaTrPessoaFisicaAtivos($pdo, $filtro);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $cpf2 = Metodos::formataCpf($v['nr_cpf']);
                    //******************************************************************
                    $idPessoa = $v['id_pessoa'];
                    $idPessoaF = $v['id_pessoa_fisica'];
                    //******************************************************************
                    $retorno .= "<tr class='pessoa' idPessoa='$idPessoaF' idPessoa2='$idPessoa' style='cursor:pointer;'>";
                    $retorno .= "   <td>" . $v['nm_pessoa'] . "</td>
                                    <td>" . $cpf2 . "</td>
                                 </tr>";
//        $retorno .= "</tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionEc($id) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesPessoaFisica();
            $result = $cidade->listaEstadoCivil($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($v['id_estado_civil'] == $id) {
                        $retorno .= "<option selected value = '" . $v['id_estado_civil'] . "'>" . $v['nm_estado_civil'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_estado_civil'] . "'>" . $v['nm_estado_civil'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaAniversario() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $niver = new DaoSesPessoaFisica();
            $niver->setId_pessoa_fisica($this->id_pessoa_fisica);
            $niver->setDt_nascimento($this->dt_nascimento);
            $result = $niver->buscaAniversario($pdo);
            if (!$result) {
                return $retorno;
            } else {
         
                
                $retorno = '<div class="col-lg-8 col-lg-offset-2">
                                
                                    <div class="panel panel-body text-center">
                                        <div class="panel-heading">
                                        <h3 class="text-danger">Feliz Aniversário!</h3> 
                                        </div>
                                        <div class="panel-body">
                                                Você pensava que a gente ia esquecer seu dia, que iríamos permitir que ele passasse em branco. <br>
                                                Mas isso nunca vai acontecer. Jamais! <br>
                                                Desejamos que você tenha um dia maravilhoso, que sinta paz e harmonia no coração <br>junto de todas as pessoas que você gosta.<br>
                                                PARABÉNS!
                                        </div>
                                    </div>
                                </div>';
            }
//                    
//                                                <button class="btn btn-danger">
//                                                    <i class="fa fa-close"></i>
//                                                </button>
//                                           
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionEstadoCivilPessoa() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $estadoCivil = new DaoSesPessoaFisica();
            $estadoCivil->setId_pessoa_fisica($this->id_pessoa_fisica);
            $result = $estadoCivil->buscaEstadoCivilPorPessoa($pdo);
//            print_r($result);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_estado_civil'] . "'>" . $v['nm_estado_civil'] . "</option>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

//************************** temporario ate ser criado a classe de pessoa juridica**************************************
    public function retornaOptionPj($id) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesPessoaFisica();
            $result = $cidade->listaPessoaJuridica($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($v['id_pessoa_juridica'] == $id) {
                        $retorno .= "<option selected value = '" . $v['id_pessoa_juridica'] . "'>" . $v['nm_pessoa'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_pessoa_juridica'] . "'>" . $v['nm_pessoa'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

//************************************************************************************************************************
    public function retornaOptionPf($id) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesPessoaFisica();
            $result = $cidade->retornaPessoaFisicaOption($pdo);
            $retorno .= "<option selected value = '0'>Selecione Pessoa Fisica</option>";
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($v['id_pessoa'] == $id) {
                        $retorno .= "<option selected value = '" . $v['id_pessoa'] . "'>" . $v['nr_cpf'] ." - ". $v['nm_pessoa'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_pessoa'] . "'>" . $v['nr_cpf'] ." - ". $v['nm_pessoa'] . "</option>";
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
