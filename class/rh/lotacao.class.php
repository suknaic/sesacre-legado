<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesLotacao.class.php";

class Lotacao {

    private $id_lotacao = null;
    private $id_pai = null;
    private $id_lotacao_categoria = null;
    private $nm_lotacao = null;
    private $nr_cnpj = null;
    private $id_cidade = null;
    private $ds_logradouro = null;
    private $ds_bairro = null;
    private $nr_cep = null;
    private $nm_email = null;
    private $nr_telefone = null;
    private $mp_latitude = null;
    private $mp_longitute = null;
    private $st_ativo = null;
    private $nmPessoa = null;
    private $nmCidade = null;
    private $sucesso = null;
    private $msgRetorno = null;
    private $id_pessoa = null;
    private $id_pessoa_juridica = null;
    private $st_principal = null;
    private $id_telefone = null;

//*****************************************
    function getId_telefone() {
        return $this->id_telefone;
    }

    function setId_telefone($id_telefone) {
        $this->id_telefone = $id_telefone;
    }

    function getSt_principal() {
        return $this->st_principal;
    }

    function setSt_principal($st_principal) {
        $this->st_principal = $st_principal;
    }

    function getSucesso() {
        return $this->sucesso;
    }

    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function getId_pessoa_juridica() {
        return $this->id_pessoa_juridica;
    }

    function setSucesso($sucesso) {
        $this->sucesso = $sucesso;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setId_pessoa_juridica($id_pessoa_juridica) {
        $this->id_pessoa_juridica = $id_pessoa_juridica;
    }

    function getId_lotacao() {
        return $this->id_lotacao;
    }

    function getId_pai() {
        return $this->id_pai;
    }

    function getId_lotacao_categoria() {
        return $this->id_lotacao_categoria;
    }

    function getNm_lotacao() {
        return $this->nm_lotacao;
    }

    function getNr_cnpj() {
        return $this->nr_cnpj;
    }

    function getId_cidade() {
        return $this->id_cidade;
    }

    function getDs_logradouro() {
        return $this->ds_logradouro;
    }

    function getDs_bairro() {
        return $this->ds_bairro;
    }

    function getNr_cep() {
        return $this->nr_cep;
    }

    function getNm_email() {
        return $this->nm_email;
    }

    function getNr_telefone() {
        return $this->nr_telefone;
    }

    function getMp_latitude() {
        return $this->mp_latitude;
    }

    function getMp_longitute() {
        return $this->mp_longitute;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_lotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;
    }

    function setId_pai($id_pai) {
        $this->id_pai = $id_pai;
    }

    function setId_lotacao_categoria($id_lotacao_categoria) {
        $this->id_lotacao_categoria = $id_lotacao_categoria;
    }

    function setNm_lotacao($nm_lotacao) {
        $this->nm_lotacao = $nm_lotacao;
    }

    function setNr_cnpj($nr_cnpj) {
        $this->nr_cnpj = $nr_cnpj;
    }

    function setId_cidade($id_cidade) {
        $this->id_cidade = $id_cidade;
    }

    function setDs_logradouro($ds_logradouro) {
        $this->ds_logradouro = $ds_logradouro;
    }

    function setDs_bairro($ds_bairro) {
        $this->ds_bairro = $ds_bairro;
    }

    function setNr_cep($nr_cep) {
        $this->nr_cep = $nr_cep;
    }

    function setNm_email($nm_email) {
        $this->nm_email = $nm_email;
    }

    function setNr_telefone($nr_telefone) {
        $this->nr_telefone = $nr_telefone;
    }

    function setMp_latitude($mp_latitude) {
        $this->mp_latitude = $mp_latitude;
    }

    function setMp_longitute($mp_longitute) {
        $this->mp_longitute = $mp_longitute;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    function getNmPessoa() {
        return $this->nmPessoa;
    }

    function getNmCidade() {
        return $this->nmCidade;
    }

    function setNmPessoa($nmPessoa) {
        $this->nmPessoa = $nmPessoa;
        return $this;
    }

    function setNmCidade($nmCidade) {
        $this->nmCidade = $nmCidade;
        return $this;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {

        return $this->sucesso;
    }

    function setMsgRetornoRetorno($msgRetorno) {
        $this->msgRetorno = $msgRetorno;
    }

//*******************************************************************************
    public function cadastrarLotacao($getTelefone) {
        try {
            $sucesso = false;
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //**************************** lotação ********************************************************************
            $lotacao = new DaoSesLotacao();
            $lotacao->setId_pai($this->id_pai == '0' ? null: $this->id_pai);
            $lotacao->setId_lotacao_categoria($this->id_lotacao_categoria);
            $lotacao->setNm_lotacao($this->nm_lotacao);
            $lotacao->setNr_cnpj($this->nr_cnpj);
            $lotacao->setDs_logradouro($this->ds_logradouro);
            $lotacao->setDs_bairro($this->ds_bairro);
            $lotacao->setNr_cep($this->nr_cep);
            $lotacao->setNm_email($this->nm_email);
            $lotacao->setMp_latitude($this->mp_latitude);
            $lotacao->setMp_longitute($this->mp_longitute);
            $lotacao->setId_pessoa(empty($this->id_pessoa) ? null:$this->id_pessoa);
            $lotacao->setId_pessoa_juridica(empty($this->id_pessoa_juridica) ? null:$this->id_pessoa_juridica);
            $lotacao->setId_cidade($this->id_cidade);

            $verifica = $lotacao->verificarExistenciaLotacao($pdo);
            if ($verifica['nm_lotacao'] == $this->nm_lotacao && $verifica['id_pai'] == $this->id_pai) {
                return Metodos::retornoAjax('Erro', 'alert', 'Registro Com Mesmo Nome e Lotação Pai Já Existem.');
            }

            $result = $lotacao->insert($pdo);
            //*****************************************
            if ($result != "Sucesso") {
                $sucesso = false;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $result);
            }

            $this->setId_lotacao($pdo->lastInsertId('ses_lotacao_id_lotacao_seq'));

            if (Log::SalvaLogI('ses_lotacao', $this->getId_lotacao(), $pdo)) {
                $sucesso = TRUE;
            } else {
                $sucesso = false;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            //*****************************Telefone********************************************************
            if (count($getTelefone) > 0) {
                foreach ($getTelefone as $linha => $v) {
                    $nr = Metodos::removeMascaraCel_Tel($v['telefone']);
                    $lotacao->setNr_telefone($nr);
                    $lotacao->setSt_principal($v['principal']);
                    $lotacao->setId_lotacao($this->getId_lotacao());
                    $rs = $lotacao->cadastrarTelefone($pdo);
                    if ($rs != "Sucesso") {
                        $retorno = Metodos::retornoAjax("Erro", "console", $rs);
                        $pdo->rollBack();
                        return $retorno;
                    }
                    $idTelefone = $pdo->lastInsertId('ses_telefone_id_telefone_seq');
                    if (!(Log::SalvaLogI('ses_telefone', $idTelefone, $pdo))) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $idTelefone);
                        return $retorno;
                    }
                }
            }
            //*******************************************************************************************
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarLotacao() {
        try {
            $sucesso = false;
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //**************************** lotação ********************************************************************
            $lotacao = new DaoSesLotacao();
            $lotacao->setId_lotacao($this->id_lotacao);
            $lotacao->setId_pai($this->id_pai == '0' ? null: $this->id_pai);
            $lotacao->setId_lotacao_categoria($this->id_lotacao_categoria);
            $lotacao->setNm_lotacao($this->nm_lotacao);
            $lotacao->setNr_cnpj($this->nr_cnpj);
            $lotacao->setDs_logradouro($this->ds_logradouro);
            $lotacao->setDs_bairro($this->ds_bairro);
            $lotacao->setNr_cep($this->nr_cep);
            $lotacao->setNm_email($this->nm_email);
            $lotacao->setMp_latitude($this->mp_latitude);
            $lotacao->setMp_longitute($this->mp_longitute);
            $lotacao->setId_pessoa(empty($this->id_pessoa) ? null:$this->id_pessoa);
            $lotacao->setId_pessoa_juridica(empty($this->id_pessoa_juridica) ? null:$this->id_pessoa_juridica);
            $lotacao->setId_cidade($this->id_cidade);

            $busca = $lotacao->retornaLotacao($pdo);
            if (!$busca) {
                $sucesso = false;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $busca);
            }

            //********* Verifica Existencia do Nome da Lotacao **********
            if ($this->nm_lotacao != $busca['nm_lotacao']) {
                if ($lotacao->verificarExistenciaLotacaoNome($pdo)) {
                    $sucesso = false;
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE.'(<strong>Lotação Com Mesmo Nome.</strong>)');
                }
            }
            //***********************************************************

            //*****************************************
            $result = $lotacao->update($pdo);
            //*****************************************

            if ($result != "Sucesso") {
                $sucesso = false;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $result);
            }

            if (Log::SalvaLogU('ses_lotacao', $this->getId_lotacao(), $busca, $pdo)) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
            } else {
                $sucesso = false;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao Cadastrar Log de Lotação");
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaLotacaoPorPessoa($id) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $lotacaoDao = new DaoSesLotacao();
            $lotacaoDao->setId_pessoa($id);
            //*********************************************
            $rs = $lotacaoDao->buscaLotacaoPorPessoa($pdo);
            //*********************fazendo************************
            if ($rs != FALSE) {
                $this->sucesso = true;
                $this->msgRetorno = $rs;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", "Nenhuma lotação encontrada.");
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaLotacao($get) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $lotacaoDao = new DaoSesLotacao();
            $lotacaoDao->setId_lotacao($get);
            //*********************************************
            $rs = $lotacaoDao->retornaLotacao($pdo);
            //*********************fazendo************************
            if ($rs != FALSE) {
                $retorno[] = array("id_lotacao" => $rs["id_lotacao"],
                    "id_pai" => $rs["id_pai"],
                    "id_lotacao_categoria" => $rs["id_lotacao_categoria"],
                    "nm_lotacao" => $rs["nm_lotacao"],
                    "ds_logradouro" => $rs["ds_logradouro"],
                    "ds_bairro" => $rs["ds_bairro"],
                    "nr_cnpj" => $rs["nr_cnpj"],
                    "nr_cep" => $rs["nr_cep"],
                    "id_cidade" => $rs["id_cidade"],
                    "nm_email" => $rs["nm_email"],
                    "mp_latitude" => $rs["mp_latitude"],
                    "mp_longitude" => $rs["mp_longitude"],
                    "id_pessoa" => $rs["id_pessoa"],
                    "id_pessoa_juridica" => $rs["id_pessoa_juridica"],
                    "st_ativo" => $rs["st_ativo"],
                    "id_estado" => $rs["id_estado"],
                    "id_pais" => $rs["id_pais"],
                    "nm_pessoa" => $rs["nm_pessoa"],
                    "nm_pessoa_juridica" => $rs["nm_pessoa_juridica"],
                );
                return json_encode($retorno);
            }
            return FALSE;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function inserirTelefone() {
        try {

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $lotacao = new DaoSesLotacao();
            $lotacao->setId_lotacao($this->id_lotacao);
            $lotacao->setNr_telefone($this->nr_telefone);
            $lotacao->setSt_principal($this->st_principal);

//          ****************************************************************************
            $rs = $lotacao->cadastrarTelefone($pdo);
            if ($rs != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $rs);
                $pdo->rollBack();
                return $retorno;
            }
            $idTelefone = $pdo->lastInsertId('ses_telefone_id_telefone_seq');
            if (!(Log::SalvaLogI('ses_telefone', $idTelefone, $pdo))) {
                $retorno = Metodos::retornoAjax("Erro", "console", $idTelefone);
                return $retorno;
            }
            // return $result;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function returnTelefones($idLotacao) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $lotacao = new DaoSesLotacao();
            $lotacao->setId_lotacao($idLotacao);
            $rs = $lotacao->buscaTelefonePorLotacao($pdo);
            if ($rs['nr_telefone'] == NULL) {
                return false;
            }
            echo Metodos::formataTelefone($rs['nr_telefone']);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTelefones($idLotacao) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $lotacao = new DaoSesLotacao();
            $lotacao->setId_lotacao($idLotacao);
            $rs = $lotacao->listaTelefones($pdo);

//          ****************************************************************************


            if ($rs != FALSE) {
                foreach ($rs as $linha) {
                    $nrTelefone = Metodos::formataTelefone($linha['nr_telefone']);
                    if ($linha['st_principal'] == 0) {
                        $principal = "";
                        $value = 0;
                    }
                    if ($linha['st_principal'] == 1) {
                        $principal = "<i class='fa fa-check-circle fa-2x text-primary'></i>";
                        $value = 1;
                    }

                    echo "  <tr class='warning telefoneLinha' idLotacao= '" . $idLotacao . "'>
                                <td class='text-center telefone'>" . $nrTelefone . "</td>\n\
                                <td class='text-center prinicipal' st_principal = '" . $value . "'>" . $principal . "</td>\n\
                                <td class='text-center'><button type='button' title='Remover' class='excluirLinha' value= " . $linha['id_telefone'] . "><i class='fa fa-remove text-danger'></i></button></td>\n\
                            </tr>";
                }
            } else {
                return $rs;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//****************************************************************************
    public function excluirTelefone() {
        try {
            $retorno = "";
            //***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $telefone = new DaoSesLotacao();
            $telefone->setId_telefone($this->id_telefone);
            //************************************************************************************
            $busca = $telefone->buscaTelefone($pdo);

            if ($busca != FALSE) {
                if (!Log::SalvaLogD('ses_telefone', $telefone->getId_telefone(), $pdo)) {
                    $pdo->rollBack();
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                }
            }
            //************************************************************************************
            $rs = $telefone->removerTelefone($pdo);

            if ($rs != "Sucesso") {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "alert", $rs);
            } else {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "alert", STR_REMOCAO_SUCESSO);
            }

            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function desativarLotacao() {
        try {
            //***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $lotacao = new DaoSesLotacao();
            $lotacao->setId_lotacao($this->id_lotacao);

            $busca = $lotacao->retornaLotacao($pdo);
            if (!$busca) {
                return Metodos::retornoAjax('Erro', 'alert', 'Registro Não Encontrado.');
            }

            $rs = $lotacao->desativarLotacao($pdo);
            if (!$rs) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $rs);
            }
            //***********************************************************************
            if (LOG::SalvaLogU('ses_lotacao', $this->id_lotacao, $busca, $pdo)) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
            }
            //***********************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function ativarLotacao() {
        try {
            //***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $lotacao = new DaoSesLotacao();
            $lotacao->setId_lotacao($this->id_lotacao);

            $busca = $lotacao->retornaLotacao($pdo);
            if (!$busca) {
                return Metodos::retornoAjax('Erro', 'alert', STR_NAO_ENCONTRADO);
            }

            $rs = $lotacao->ativarLotacao($pdo);
            if (!$rs) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $rs);
            }
            //***********************************************************************
            if (LOG::SalvaLogU('ses_lotacao', $this->id_lotacao, $busca, $pdo)) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
            }
            //***********************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /**
     * Retorna Option Com todas as Lotações
     * @param PDO $pdo
     * @return string
     */
    public function retornaOptionLotacao(PDO $pdo = null, int $idLotacao = 0) {
        $retorno = "";
        try {
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $lotacao = new DaoSesLotacao();
            $result = $lotacao->retornaTodasLotacoes($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($idLotacao == $v['id_lotacao']) {
                        $retorno .= "<option value = '" . $v['id_lotacao'] . "' selected>" . $v['nm_lotacao'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_lotacao'] . "'>" . $v['nm_lotacao'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionLotacaoPessoa(int $idLotacao = 0) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $lotacao = new DaoSesLotacao();
            $lotacao->setId_pessoa($this->id_pessoa);
            $result = $lotacao->buscaLotacaoPorPessoa($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($idLotacao > 0 && $idLotacao == $v['id_lotacao']) {
                        $retorno .= "<option value = '" . $v['id_lotacao'] . "' selected>" . $v['nm_lotacao'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_lotacao'] . "'>" . $v['nm_lotacao'] . "</option>";
                    }
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    //*******************************************************************************************************
    public function retornaOptionCategoriaLotacao(PDO $pdo = null, $id = null) {
        $retorno = "";
        try {
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $lotacao = new DaoSesLotacao();
            $result = $lotacao->retornaCategoriasLotacao($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($v['id_lotacao_categoria'] == $id) {
                        $retorno .= "<option selected value = '" . $v['id_lotacao_categoria'] . "'>" . $v['nm_lotacao_categoria'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_lotacao_categoria'] . "'>" . $v['nm_lotacao_categoria'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaTrLotacao($nome, $categoria, $lotacaoPai) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesLotacao();
            $filtro = "";
            //*****************************************************************
            $filter = array();
            if (!empty($nome)) {
                $filter[] = "l.nm_lotacao ilike '%$nome%'";
            }
            if (!empty($categoria)) {
                $filter[] = "lc.id_lotacao_categoria = $categoria";
            }
            if (!empty($lotacaoPai)) {
                $filter[] = "pa.id_lotacao = $lotacaoPai";
            }

            if (count($filter) > 0) {
                $filtro = " and " . implode(' and ', $filter);
            }
            //******************************************************************
            $result = $rh->retornaLotacoes($pdo, $filtro);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    //************ formatar mascara do telefone ****************
                    $telefone = explode(",", $v['nr_telefone']);
                    $numeros = "";
                    foreach ($telefone as $nr) {
                        $numeros .= Metodos::formataTelefone(trim($nr)) . ", ";
                    }
                    $numeros = substr($numeros, 0, strlen($numeros) - 2);
                    //**********************************************************
                    $idlotacao = $v['id_lotacao'];
                    $retorno .= "<tr>";
                    $retorno .= "   <td>" . $v['nm_lotacao'] . "</td>
                                        <td>" . $v['nm_sigla'] . " - " . $v['nm_cidade'] . "</td>
                                        <td>" . $v['ds_logradouro'] . "</td>   
                                        <td>" . $v['ds_bairro'] . "</td>
                                        <td>" . $v['responsavel'] . "</td>   
                                        <td>" . $numeros . "</td> 
                                        <td>" . $v['pai'] . "</td>
                                        <td style='text-align: center;'>                           
                                            <button type='button' class='btn btn-default btn-edit btn-xs'                               
                                                  title='Editar' nome='" . $v['nm_lotacao'] . "' value='" . $idlotacao . "' >
                                                  <i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>                                
                                            </button>";
                    if ($v['st_ativo'] == '0') {
                        $retorno.= "        <button type='button' class='btn btn-default btn-ativar btn-xs' title='Ativar' nome='" . $v['nm_lotacao'] . "' value='" . $idlotacao . "' >
                                                <i class='ion-checkmark-round fa-lg text-success' aria-hidden='true'></i>                                
                                            </button>";
                    } else {
                        $retorno.= "        <button type='button' class='btn btn-default btn-desativar btn-xs' title='Desativar' nome='" . $v['nm_lotacao'] . "' value='" . $idlotacao . "' >
                                                <i class='ion-close-round fa-lg text-danger' aria-hidden='true'></i>                                
                                            </button>";
                    }
//                    $retorno.=          "   <button type='button' class='btn btn-default btn-remover btn-xs' title='Remover' nome='" . $v['nm_lotacao'] . "' value='" . $idlotacao . "' >
//                                                <i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>
//                                            </button>
//                                        </td>
//                                </tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

//*******************************************************************************************************

    public function carregaNomeCidadeResponsavel($pdo = null) {
        $this->sucesso = false;
        try {

            if ($pdo == null) {

                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $dao = new DaoSesLotacao();
            $dao->setId_lotacao($this->id_lotacao);
            $dao->retornaNomeCidadeResponsavel($pdo);

            if (!$dao->Sucesso()) {
                $this->msgRetorno = $dao->getMsgRetorno();
                $this->sucesso = false;
            } else {

                $result = $dao->getMsgRetorno();
                $this->nm_lotacao = $result['nm_lotacao'];
                $this->nmCidade = $result['nm_cidade'];
                $this->nmPessoa = $result['nm_pessoa'];
                $this->sucesso = true;
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
            $this->sucesso = false;
            return;
        }
    }

    public function carregaNomeCidadeResponsavelRetornaInfo($pdo = null) {

        $this->sucesso = false;
        $retorno = "";
        try {
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $dao = new DaoSesLotacao();
            $dao->setId_lotacao($this->id_lotacao);
            $dao->retornaNomeCidadeResponsavel($pdo);


            if (!$dao->Sucesso()) {
                $this->msgRetorno = $dao->getMsgRetorno();
                $this->sucesso = false;
            } else {

                $result = $dao->getMsgRetorno();
                $this->nm_lotacao = $result['nm_lotacao'];
                $this->nmCidade = $result['nm_cidade'];
                $this->nmPessoa = $result['nm_pessoa'];
                $this->sucesso = true;

                $retorno .= "<div class='row'>";

                $retorno .= "<div class='col-sm-3'><b>Área Administrativa/Técnica/Assistencial:</b></div>";
                $retorno .= "<div class='col-sm-8'>" . $this->nm_lotacao . " - " . $this->nmCidade . "</div>";
                $retorno .= "</div>";

                $retorno .= "<div class='row'>";
                $retorno .= "<div class='col-sm-3'><b>Responsável:</b></div>";
                $retorno .= "<div class='col-sm-8'>" . $this->nmPessoa . "</div>";

//                $retorno .= "<div class='col-sm-2'><b>Unidade/Departamento/Setor:</b></div>";
//                $retorno .= "<div class='col-sm-9'>" . $this->nm_lotacao . " - " . $this->nmCidade . "</div>";
//                $retorno .= "</div>";
//
//                $retorno .= "<div class='row'>";
//                $retorno .= "<div class='col-sm-2'><b>Responsável:</b></div>";
//                $retorno .= "<div class='col-sm-9'>" . $this->nmPessoa . "</div>";

                $retorno .= "</div>";
            }

            $this->msgRetorno = $retorno;
        } catch (Exception $ex) {
            $this->msgRetorno = $exc->getMessage();
            $this->sucesso = false;
            return;
        }
    }

    public function retornaOptionLotacaoPasExiste(PDO $pdo = null) {
        $retorno = "";
        try {
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $lotacao = new DaoSesLotacao();
            $lotacao->retornaPasExiste($pdo);


            if (!$lotacao->Sucesso()) {

                return $retorno;
            } else {
                $result = $lotacao->getMsgRetorno();
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_lotacao'] . "'>" . $v['nm_lotacao'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function optionsLotacaoPorUsuarioCentral(PDO $pdo = null, $idUsuario = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $lotacao = new DaoSesLotacao();
            $lotacao->retornaLotacaoPeloIdUsuarioCentral($pdo, $idUsuario);
            $retorno = "";

            if (!$lotacao->Sucesso()) {
                return false;
            } else {
                $result = $lotacao->getMsgRetorno();
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_lotacao'] . "'>" . $v['nm_lotacao'] . "</option>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function carregaDados(PDO $pdo = null) {
        $this->sucesso = FALSE;
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoSesLotacao();
            $dao->setId_lotacao($this->id_lotacao);
            $result = $dao->retornaLotacao($pdo);

            if (!$result) {
                $this->sucesso = FALSE;
            } else {
                $this->sucesso = TRUE;
                $this->id_lotacao = $result['id_lotacao'];
                $this->nm_lotacao = $result['nm_lotacao'];
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $retorno = "";
        }
    }

}

?>
