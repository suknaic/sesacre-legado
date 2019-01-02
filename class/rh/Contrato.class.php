<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesContrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/perfil_pessoa/PerfilPessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesContrato.class.php";

class Contrato {

    //**************************************************
    private $id_contrato = null;
    private $nr_matricula = null;
    private $dt_admissao = null;
    private $nr_carga_horaria = null;
    private $dt_demissao = null;
    private $id_pessoa_fisica = null;
    private $id_vinculo = null;
    private $id_pessoa_juridica = null;
    private $id_cargo = null;
    private $st_ativo = null;
    private $dt_historico = null;

//*******************************************************************************
    function getDt_historico() {
        return $this->dt_historico;
    }

    function setDt_historico($dt_historico) {
        $this->dt_historico = $dt_historico;
    }

    function getId_contrato() {
        return $this->id_contrato;
    }

    function getNr_matricula() {
        return $this->nr_matricula;
    }

    function getDt_admissao() {
        return $this->dt_admissao;
    }

    function getNr_carga_horaria() {
        return $this->nr_carga_horaria;
    }

    function getDt_demissao() {
        return $this->dt_demissao;
    }

    function getId_pessoa_fisica() {
        return $this->id_pessoa_fisica;
    }

    function getId_vinculo() {
        return $this->id_vinculo;
    }

    function getId_pessoa_juridica() {
        return $this->id_pessoa_juridica;
    }

    function getId_cargo() {
        return $this->id_cargo;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_contrato($id_contrato) {
        $this->id_contrato = $id_contrato;
    }

    function setNr_matricula($nr_matricula) {
        $this->nr_matricula = $nr_matricula;
    }

    function setDt_admissao($dt_admissao) {
        $this->dt_admissao = $dt_admissao;
    }

    function setNr_carga_horaria($nr_carga_horaria) {
        $this->nr_carga_horaria = $nr_carga_horaria;
    }

    function setDt_demissao($dt_demissao) {
        $this->dt_demissao = $dt_demissao;
    }

    function setId_pessoa_fisica($id_pessoa_fisica) {
        $this->id_pessoa_fisica = $id_pessoa_fisica;
    }

    function setId_vinculo($id_vinculo) {
        $this->id_vinculo = $id_vinculo;
    }

    function setId_pessoa_juridica($id_pessoa_juridica) {
        $this->id_pessoa_juridica = $id_pessoa_juridica;
    }

    function setId_cargo($id_cargo) {
        $this->id_cargo = $id_cargo;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

//*******************************************************************************
    public function cadastrarContrato($dadosPessoa, $dadosPessoaFisica, $dadosCompetencia, $dadosContrato, $dadosContratoLotacao) {
        try {
            $sucesso = false;
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            //********************* Valida E-mail e verifica se é institucional *****************
            if (Metodos::validaEmail($dadosPessoa['email'])){
                $email = strstr($dadosPessoa['email'], 'ac.gov.br');
                if ($email != 'ac.gov.br') {
                    $pdo->rollBack();
                    return Metodos::retornoAjax('Erro', 'alert','Informe o E-mail Institucional do Domínio <strong>ac.gov.br</strong>.');
                }
            } else {
                return Metodos::retornoAjax('Erro', 'alert',"O E-mail Informado é Inválido.");
            }
            //***********************************************************************************

            //******************* Valida Data de Admisão, se a mesma é maior que a data atual ************************
            $dtAdm = strtotime(date(str_replace('/', '-', $dadosContrato['dtAdmissao'])));
            $dtAtual = strtotime(date("d-m-Y"));
            if ($dtAdm > $dtAtual) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', 'Data de Admissão Deve Ser Menor ou Igual a Data Atual.');
            }
            //********************************************************************************************************

            //**************************** Pessoa ********************************************************************
            $pessoa = new Pessoa();
            $telefoneRes = Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_residencial']);
            $telefoneCel = Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_celular']);
            $pessoa->setNm_email(trim($dadosPessoa['email']));
            $pessoa->setDs_bairro(trim($dadosPessoa['bairro']));
            $pessoa->setDs_complemento(trim($dadosPessoa['complemento']));
            $pessoa->setNrNumero(trim($dadosPessoa['numero']));
            $pessoa->setDs_logradouro(trim($dadosPessoa['logradouro']));
            $pessoa->setDs_observacao(trim($dadosPessoa['obs']));
            $pessoa->setId_cidade($dadosPessoa['cidade']);
            $pessoa->setId_naturalidade($dadosPessoa['naturalidade']);
            $pessoa->setNm_pessoa(trim($dadosPessoa['nomeSocial'] === '' ? $dadosPessoaFisica['nomeCivil'] : $dadosPessoa['nomeSocial']));
            $pessoa->setNm_senha(trim($dadosPessoa['senha']));
            $pessoa->setNr_cep($dadosPessoa['cep']);
            $pessoa->setNr_elefone_residencial($telefoneRes);
            $pessoa->setNr_telefone_celular($telefoneCel);
            $pessoa->cadastrarPessoa($pdo);
            if ($pessoa->getSuccess()) {
                $idPessoa = $pessoa->getId_pessoa();
            } else {
                return Metodos::retornoAjax("Erro", "alert", $pessoa->getMsg());
            }

            //************************************************* Pessoa Fisica *******************************************
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->setId_pessoa($idPessoa);
            $pessoaFisica->setTp_sexo(trim($dadosPessoaFisica['tpSexo']));
            $pessoaFisica->setNm_civil(trim($dadosPessoaFisica['nomeCivil']));
            $pessoaFisica->setNr_cpf(trim($dadosPessoaFisica['cpf']));
            $pessoaFisica->setNr_rg(trim($dadosPessoaFisica['rg']));
            $pessoaFisica->setDs_orgao_expedidor(trim(strtoupper($dadosPessoaFisica['orgaoExpedidor'])));
            $pessoaFisica->setDs_habilidade(trim($dadosPessoaFisica['habilidade']));
            $pessoaFisica->setId_estado_expedidor(($dadosPessoaFisica['orgaoExpedidorEst']));
            $pessoaFisica->setId_estado_civil(($dadosPessoaFisica['estadoCivil']));
            $pessoaFisica->setNm_pai(trim($dadosPessoaFisica['pai']));
            $pessoaFisica->setNm_mae(trim($dadosPessoaFisica['mae']));
            $pessoaFisica->setDt_nascimento($dadosPessoaFisica['dtNascimento']);
            $pessoaFisica->setNr_cns(str_replace(" ", "", trim($dadosPessoaFisica['cns'])));
            $pessoaFisica->setId_escolaridade_formacao(($dadosPessoaFisica['escolaridade']));
            $pessoaFisica->cadastrarPessoaFisica($pdo);
            if ($pessoaFisica->getSuccess()) {
                $idPessoaFisica = $pessoaFisica->getId_pessoa_fisica();
            } else {
                return Metodos::retornoAjax("Erro", "alert", $pessoaFisica->getMsg());
            }
            //**********************************************************************************************************

            //********************************************** Competencias **********************************************
            if (count($dadosCompetencia) > 0) {
                foreach ($dadosCompetencia as $linha => $v) {
                    $pessoaFisica->setId_escolaridade_formacao_competencia($v['id_escolaridade_formacao']);
                    $rs = $pessoaFisica->cadastrarCompetencia($pdo, $dadosPessoaFisica['escolaridade']);
                    if ($rs != "Sucesso") {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $rs);
                    }
                }
            }
            //**********************************************************************************************************

            //*********************************************** Contratos ************************************************
            $contrato = new DaoSesContrato();
            $contrato->setSt_ativo('1');
            //********************************************
            if (!empty($dadosContrato['dtDemissao'])) {
                $data2 = Metodos::ConverteDataING($dadosContrato['dtDemissao']);
                $data = new DateTime();
                $data = $data->format('Y-m-d');
                // print_r($data);
                if ($data > $data2) {
                    $contrato->setSt_ativo('0');
                }
            }
            //*********************************************

            //**************************** Carga Horaria dos Contratos permitidas são:20,24,30 e 44 ********************
            $ch = $dadosContrato['nrCargaHoraria'];
            if ($ch == 20 || $ch == 24 || $ch == 30 || $ch == 40 || $ch == 44) {
                $cadatraContrato = true;
            } else {
                $cadatraContrato = false;
            }

            if (!$cadatraContrato) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', 'As Cargas Horárias Permitidas para Contratos são: 20,24,30,40 e 44.');
            }
            //**********************************************************************************************************

            //******************************** Verifica a existencia do hifen na matricula *****************************
            $matricula = $dadosContrato['nrMatricula'];
            if (strpos($matricula, '-') == false) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', 'A matrícula informada é inválida.');
            }
            //**********************************************************************************************************

            //*********************************** Valida data de admissão e demissão ***********************************
            $dtAd = explode('/', $dadosContrato['dtAdmissao']);
            $dAd = $dtAd[0];
            $mAd = $dtAd[1];
            $yAd = $dtAd[2];
            if (!checkdate($mAd, $dAd, $yAd)) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', 'A data de admissão informada é inválida.');
            }

            if (!empty($dadosContrato['dtDemissao'])) {
                $dtDm = explode('/', $dadosContrato['dtDemissao']);
                $dDm = $dtDm[0];
                $mDm = $dtDm[1];
                $yDm = $dtDm[2];
                if (!checkdate($mDm, $dDm, $yDm)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax('Erro', 'alert', 'A data de demissão informada é inválida.');
                }
            }
            //**********************************************************************************************************

            $contrato->setDt_admissao(Metodos::ConverteDataING($dadosContrato['dtAdmissao']));
            $contrato->setDt_demissao($dadosContrato['dtDemissao'] == '' || $dadosContrato['dtDemissao'] == null ? null:Metodos::ConverteDataING($dadosContrato['dtDemissao']));
            $contrato->setId_cargo($dadosContrato['idCargo']);
            $contrato->setId_pessoa_fisica($idPessoaFisica);
            $contrato->setId_pessoa_juridica($dadosContrato['pessoaJuridica']);
            $contrato->setId_vinculo($dadosContrato['vinculo']);
            $contrato->setNr_carga_horaria($dadosContrato['nrCargaHoraria']);
            $contrato->setNr_matricula($dadosContrato['nrMatricula']);

            $rs = $contrato->insert($pdo);

            if ($rs != "Sucesso") {
                $sucesso = false;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $rs);
            }
            $contrato->setId_contrato($pdo->lastInsertId('ses_contrato_id_contrato_seq'));
            //*********************************Contrato / Lotação*************************************************
            if (count($dadosContratoLotacao) > 0) {
                foreach ($dadosContratoLotacao as $linha => $v) {

                    $contrato->setCarga_horaria_lotacao($v['chLotacao']);
                    $contrato->setId_lotacao($v['idLotacao']);
                    $contrato->setId_funcao($v['idFuncao']);
                    $contrato->setDt_inicio($v['dt_inicio']);
                    $contrato->setDt_fim($v['dt_fim']);

                    //******************************** Valida data inicio e fim do contrato ****************************
                    $dtIni = explode('/', $v['dt_inicio']);
                    $dIni = $dtIni[0];
                    $mIni = $dtIni[1];
                    $yIni = $dtIni[2];
                    if (!checkdate($mIni, $dIni, $yIni)) {
                        return Metodos::retornoAjax('Erro', 'alert', 'A data de início do contrato é inválida.');
                    }

                    if (!empty($v['dt_fim'])) {
                        $dtFim = explode('/', $v['dt_fim']);
                        $dFim = $dtFim[0];
                        $mFim = $dtFim[1];
                        $yFim = $dtFim[2];
                        if (!checkdate($mFim, $dFim, $yFim)) {
                            return Metodos::retornoAjax('Erro', 'alert', 'A data de fim do contrato é inválida.');
                        }
                    }
                    //**************************************************************************************************

                    $rs = $contrato->insertContratoLotacao($pdo);
                    if ($rs != "Sucesso") {
                        $sucesso = false;
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $rs);
                    }
                    $idContratoLot = $pdo->lastInsertId('ses_contrato_lotacao_id_contrato_lotacao_seq');
                    if (!(Log::SalvaLogI('ses_contrato_lotacao', $idContratoLot, $pdo))) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar Log de Contrato Lotação");
                    }
                    //*********************histórico*************************************
                    $data = date('Y-m-d H:i');
                    $contrato->setDs_observacao("Cadastro do Contrato");
                    $contrato->setId_contrato_situacao(NULL);
                    $contrato->setDt_historico($data);
                    $rs1 = $contrato->insertContratoHistorico($pdo);
                    if ($rs1 != "Sucesso") {
                        $sucesso = false;
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $rs1);
                    }
                    $idContratoHist = $pdo->lastInsertId('ses_contrato_historico_id_contrato_historico_seq');
                    if (!(Log::SalvaLogI('ses_contrato_historico', $idContratoHist, $pdo))) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar Log de Contrato Histórico");
                    }
                    $sucesso = true;
                }
            }
            //**********************************************************************************************************
            //************************ Definindo o perfil(CHAMADO) padrão para o funcionário ***************************
            if ($sucesso) {
//************* Ativar código quando as pendencias dos módulos do RH e Chamados estiverem prontos ***************
//                $perfilPessoa = new PerfilPessoa();
//                $perfilPessoa->setIdPerfil();
//                $perfilPessoa->setIdPessoa($idPessoa);
//
//                $inseriPerfil = $perfilPessoa->incluirPessoaPerfil($pdo);
//                if ($inseriPerfil) {
//                    
//                } else {
//                    $pdo->rollBack();
//                    return Metodos::retornoAjax('Erro', 'console', $inseriPerfil);
//                }
// *************************************************************************************************
                if (Log::SalvaLogI('ses_contrato', $contrato->getId_contrato(), $pdo)) {
                    $fim = true;
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                if ($fim) {
                    $pdo->commit();
                    return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
            }
            //************************************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************
    public function editarContrato($dadosPessoa, $dadosPessoaFisica, $dadosCompetencia, $dadosContrato, $dadosContratoLotacao) {
        try {
            $sucesso = false;
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //************************ Valida Data de Nascimento, se é maior que a Data Atual **************************
            $dtNasc = strtotime($dadosPessoaFisica['dtNascimento']);
            $dtAtual = strtotime(date("d-m-Y"));
            if ($dtNasc > $dtAtual) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', 'Data de Nascimento Não Pode Ser Maior que a Data Atual.');
            }
            //**********************************************************************************************************

            //******************* Valida Data de Admisão, se a mesma é maior que a data atual **************************
            $dtAdm = strtotime($dadosContrato['dtAdmissao']);
            $dtAtual = strtotime(date("d-m-Y"));
            if ($dtAdm > $dtAtual) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', 'Data de Admissão Deve Ser Menor ou Igual a Data Atual.');
            }
            //********************************************************************************************************

            //**************************** Pessoa ********************************************************************
            $telefoneRes = Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_residencial']);
            $telefoneCel = Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_celular']);
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($dadosPessoa['idPessoa']);
            $pessoa->setNm_email(trim($dadosPessoa['email']));
            $pessoa->setDs_bairro(trim($dadosPessoa['bairro']));
            $pessoa->setDs_complemento(trim($dadosPessoa['complemento']));
            $pessoa->setDs_logradouro(trim($dadosPessoa['logradouro']));
            $pessoa->setDs_observacao(trim($dadosPessoa['obs']));
            $pessoa->setId_cidade($dadosPessoa['cidade']);
            $pessoa->setId_naturalidade($dadosPessoa['naturalidade']);
            $pessoa->setNm_pessoa(trim($dadosPessoa['nomeSocial'] === '' ? $dadosPessoaFisica['nomeCivil'] : $dadosPessoa['nomeSocial']));
            $pessoa->setNr_cep($dadosPessoa['cep']);
            $pessoa->setNr_elefone_residencial($telefoneRes);
            $pessoa->setNr_telefone_celular($telefoneCel);
            //********************************
            $pessoa->editarPessoa($pdo);
            //********************************
            if ($pessoa->getSuccess() == false) {
                return Metodos::retornoAjax("Erro", "alert", $pessoa->getMsg());
            }

            //******************************************* Pessoa Fisica*************************************************
            $pessoaFisica = new pessoaFisica();
            //**********************************************************************************************************

            $pessoaFisica->setId_pessoa($dadosPessoa['idPessoa']);
            $pessoaFisica->setId_pessoa_fisica($dadosPessoaFisica['idPessoaFisica']);
            $pessoaFisica->setTp_sexo(trim($dadosPessoaFisica['tpSexo']));
            $pessoaFisica->setNm_civil(trim($dadosPessoaFisica['nomeCivil']));
            $pessoaFisica->setNr_cpf(trim($dadosPessoaFisica['cpf']));
            $pessoaFisica->setNr_rg(trim($dadosPessoaFisica['rg']));
            $pessoaFisica->setDs_orgao_expedidor(trim(strtoupper($dadosPessoaFisica['orgaoExpedidor'])));
            $pessoaFisica->setDs_habilidade(trim($dadosPessoaFisica['habilidade']));
            $pessoaFisica->setId_estado_expedidor(($dadosPessoaFisica['orgaoExpedidorEst']));
            $pessoaFisica->setId_estado_civil(($dadosPessoaFisica['estadoCivil']));
            $pessoaFisica->setNm_pai(trim($dadosPessoaFisica['pai']));
            $pessoaFisica->setNm_mae(trim($dadosPessoaFisica['mae']));
            $pessoaFisica->setDt_nascimento(($dadosPessoaFisica['dtNascimento']));
            $pessoaFisica->setNr_cns(trim($dadosPessoaFisica['cns']));
            $pessoaFisica->setId_escolaridade_formacao(($dadosPessoaFisica['escolaridade']));
            //******************************************
            $pessoaFisica->editarPessoaFisica($pdo);
            //******************************************
            if ($pessoaFisica->getSuccess() == FALSE) {
                $retorno = Metodos::retornoAjax("Erro", "alert", $pessoaFisica->getMsg());
                return $retorno;
            }
            //*************************contratos***********************************************************************
            $contrato = new DaoSesContrato();
            $contrato->setSt_ativo('1');
            //********************************************
            if (!empty($dadosContrato['dtDemissao'])) {
                $data2 = Metodos::ConverteDataING($dadosContrato['dtDemissao']);
                $data = new DateTime();
                $data = $data->format('Y-m-d');
                if ($data > $data2) {
                    $contrato->setSt_ativo('0');
                }
            }
            //*********************************************

            //**************************** Carga Horaria dos Contratos permitidas são:20,24,30 e 44 ********************
            $ch = $dadosContrato['nrCargaHoraria'];
            if ($ch == 20 || $ch == 24 || $ch == 30 || $ch == 40 || $ch == 44) {
                $cadatraContrato = true;
            } else {
                $cadatraContrato = false;
            }

            if (!$cadatraContrato) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', 'As Cargas Horárias Permitidas para Contratos são: 20,24,30,40 e 44.');
            }
            //**********************************************************************************************************

            //******************************** Verifica a existencia do hifen na matricula *****************************
            $matricula = $dadosContrato['nrMatricula'];
            if (strpos($matricula, '-') == false) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', 'A matrícula informada é inválida.');
            }
            //**********************************************************************************************************

            //*********************************** Valida data de admissão e demissão ***********************************
            $dtAd = explode('/', $dadosContrato['dtAdmissao']);
            $dAd = $dtAd[0];
            $mAd = $dtAd[1];
            $yAd = $dtAd[2];
            if (!checkdate($mAd, $dAd, $yAd)) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', 'A data de admissão informada é inválida.');
            }

            if (!empty($dadosContrato['dtDemissao'])) {
                $dtDm = explode('/', $dadosContrato['dtDemissao']);
                $dDm = $dtDm[0];
                $mDm = $dtDm[1];
                $yDm = $dtDm[2];
                if (!checkdate($mDm, $dDm, $yDm)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax('Erro', 'alert', 'A data de demissão informada é inválida.');
                }
            }
            //**********************************************************************************************************

            $contrato->setId_contrato($dadosContrato['idContrato']);
            $contrato->setDt_admissao($dadosContrato['dtAdmissao']);
            $contrato->setDt_demissao($dadosContrato['dtDemissao']);
            $contrato->setId_cargo($dadosContrato['idCargo']);
            $contrato->setId_pessoa_fisica($pessoaFisica->getId_pessoa_fisica());
            $contrato->setId_pessoa_juridica($dadosContrato['pessoaJuridica']);
            $contrato->setId_vinculo($dadosContrato['vinculo']);
            $contrato->setNr_carga_horaria($dadosContrato['nrCargaHoraria']);
            $contrato->setNr_matricula($dadosContrato['nrMatricula']);
            //*******************************************************************
            if (empty($contrato->getId_contrato())) {
                $rs = $contrato->insert($pdo);
                if ($rs != "Sucesso") {
                    $sucesso = false;
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $rs);
                }
                $contrato->setId_contrato($pdo->lastInsertId('ses_contrato_id_contrato_seq'));
                //*********************************Contrato / Lotação***************************************************
                if (count($dadosContratoLotacao) > 0) {
                    foreach ($dadosContratoLotacao as $linha => $v) {
                        $contrato->setCarga_horaria_lotacao($v['chLotacao']);
                        $contrato->setId_lotacao($v['idLotacao']);
                        $contrato->setId_funcao($v['idFuncao']);
                        $contrato->setDt_inicio($v['dt_inicio']);
                        $contrato->setDt_fim($v['dt_fim']);

                        //************************ Valida data inicio e fim do contrato da lotação *********************
                        $dtIni = explode('/', $v['dt_inicio']);
                        $dIni = $dtIni[0];
                        $mIni = $dtIni[1];
                        $yIni = $dtIni[2];
                        if (!checkdate($mIni, $dIni, $yIni)) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax('Erro', 'alert', 'A data de início do contrato é inválida.');
                        }

                        if (!empty($v['dt_fim'])) {
                            $dtFim = explode('/', $v['dt_fim']);
                            $dFim = $dtFim[0];
                            $mFim = $dtFim[1];
                            $yFim = $dtFim[2];
                            if (!checkdate($mFim, $dFim, $yFim)) {
                                $pdo->rollBack();
                                return Metodos::retornoAjax('Erro', 'alert', 'A data de fim do contrato é inválida.');
                            }
                        }
                        //**********************************************************************************************

                        //**********************************************************************************************
                        $rs = $contrato->insertContratoLotacao($pdo);
                        if ($rs != "Sucesso") {
                            $sucesso = false;
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", $rs);
                        }
                        $idContratoLot = $pdo->lastInsertId('ses_contrato_lotacao_id_contrato_lotacao_seq');
                        if (!(Log::SalvaLogI('ses_contrato_lotacao', $idContratoLot, $pdo))) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar Log de Contrato Lotação");
                        }
                        //**********************************************************************************************

                        //*********************histórico****************************************************************
                        $data = date('Y-m-d H:i');
                        $contrato->setDs_observacao("Cadastro do Contrato");
                        $contrato->setId_contrato_situacao(NULL);
                        $contrato->setDt_historico($data);
                        $rs1 = $contrato->insertContratoHistorico($pdo);
                        if ($rs1 != "Sucesso") {
                            $sucesso = false;
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", $rs1);
                        }
                        $idContratoHist = $pdo->lastInsertId('ses_contrato_historico_id_contrato_historico_seq');
                        if (!(Log::SalvaLogI('ses_contrato_historico', $idContratoHist, $pdo))) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar Log de Contrato Histórico");
                        }
                        $sucesso = true;
                    }
                }
                //******************************************************************************
                $contrato->setId_contrato($pdo->lastInsertId('ses_contrato_id_contrato_seq'));
                //******************************************************************************
                if (Log::SalvaLogI('ses_contrato', $contrato->getId_contrato(), $pdo)) {
                    $sucesso = true;
                    $msg = STR_CADASTRO_SUCESSO;
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                }
            } else {
                //************************************* Busca dados do contrato ****************************************
                $busca = $contrato->retornaContrato($pdo);
                //******************************************************************************************************

                if (!$busca) {
                    $sucesso = FALSE;
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $busca);
                }

                //********************************* Busca Competencia Pessoa Fisica ************************************
                $competencias = $pessoaFisica->retornaCompetenciaPessoaFisica($busca['id_pessoa_fisica']);
                //******************************************************************************************************

                if ($competencias == null) {
                    //********************** Cadastra as competencias caso não possua nenhuma **************************
                    if (count($dadosCompetencia) > 0) {
                        foreach ($dadosCompetencia as $linha => $v) {
                            $pessoaFisica->setId_escolaridade_formacao_competencia($v['id_escolaridade_formacao']);
                            $cadastra = $pessoaFisica->cadastrarCompetencia($pdo, $dadosPessoaFisica['escolaridade']);
                            if ($cadastra != "Sucesso") {
                                $pdo->rollBack();
                                return $cadastra;
                            }
                        }
                    }
                    //**************************************************************************************************
                } else {
                    $telaCompetancias = array();
                    foreach ($dadosCompetencia as $comp) {
                        $telaCompetancias[] = $comp['id_escolaridade_formacao'];
                    }
                    $bancoCompetencias = array();
                    foreach ($competencias as $bdComp) {
                        $bancoCompetencias[] = $bdComp['id_escolaridade_formacao'];
                    }

                    $inserir = array_diff(array_unique($telaCompetancias), $bancoCompetencias);
                    if (count($inserir) > 0) {
                        foreach ($inserir as $idEscolaridadeFormacao) {
                            $pessoaFisica->setId_escolaridade_formacao_competencia($idEscolaridadeFormacao);
                            $cadastra = $pessoaFisica->cadastrarCompetencia($pdo, $dadosPessoaFisica['escolaridade']);
                            if ($cadastra != "Sucesso") {
                                $pdo->rollBack();
                                return $cadastra;
                            }
                        }
                    }

                    $deletar = array_diff($bancoCompetencias, $telaCompetancias);
                    if (count($deletar) > 0) {
                        foreach ($competencias as $idEscolaridadeFormacaoBanco => $banco) {
                            foreach ($deletar as $idEscolaridadeFormacaoTela => $tela) {
                                if ($banco['id_escolaridade_formacao'] == $tela) {
                                    $remover = $pessoaFisica->removerCompetencia($banco['id_competencia']);
                                    if ($remover == 'Sucesso') {
                                        unset($competencias[$idEscolaridadeFormacaoBanco]);
                                        unset($deletar[$idEscolaridadeFormacaoTela]);
                                    }
                                }
                            }
                        }
                    }
                }

                foreach ($dadosContratoLotacao as $dcLotacao) {
                    if (!empty($dcLotacao['idContratoLotacao'])) {
                        $contrato->setId_contrato_lotacao($dcLotacao['idContratoLotacao']);
                        $busca = $contrato->retornaContratoLotacao($pdo);
//                        var_dump($dcLotacao);
                        if (!empty($busca)) {
                            if (array_diff($dcLotacao, $busca[0]) > 0){
                                $contrato->setCarga_horaria_lotacao($dcLotacao['chLotacao']);
                                $contrato->setDt_inicio($dcLotacao['dt_inicio']);
                                $contrato->setDt_fim($dcLotacao['dt_fim']);

                                //************************ Valida data inicio e fim do contrato da lotação *********************
                                $dtIni = explode('-', $dcLotacao['dt_inicio']);
                                $dIni = $dtIni[2];
                                $mIni = $dtIni[1];
                                $yIni = $dtIni[0];
                                if (!checkdate($mIni, $dIni, $yIni)) {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'alert', 'A data de início da lotação é inválida.');
                                }

                                if (!empty($dcLotacao['dt_fim'])) {
                                    $dtFim = explode('-', $dcLotacao['dt_fim']);
                                    $dFim = $dtFim[2];
                                    $mFim = $dtFim[1];
                                    $yFim = $dtFim[0];
                                    if (!checkdate($mFim, $dFim, $yFim)) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'alert', 'A data de fim da lotação é inválida.');
                                    }
                                }
                                //**********************************************************************************************

                                //**********************************************************************************************
                                $rs = $contrato->updateContratoLotacao($pdo);
                                if ($rs != "Sucesso") {
                                    $sucesso = false;
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax("Erro", "console", $rs);
                                }
                                if (!(Log::SalvaLogU('ses_contrato_lotacao', $dcLotacao['idContratoLotacao'], $busca, $pdo))) {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar Log de Contrato Lotação");
                                }
                                //**********************************************************************************************
                            }
                        }
                    } else {
                        $contrato->setCarga_horaria_lotacao($dcLotacao['chLotacao']);
                        $contrato->setId_lotacao($dcLotacao['idLotacao']);
                        $contrato->setId_funcao($dcLotacao['idFuncao']);
                        $contrato->setDt_inicio($dcLotacao['dt_inicio']);
                        $contrato->setDt_fim($dcLotacao['dt_fim']);

                        //************************ Valida data inicio e fim do contrato da lotação *********************
                        $dtIni = explode('-', $dcLotacao['dt_inicio']);
                        $dIni = $dtIni[2];
                        $mIni = $dtIni[1];
                        $yIni = $dtIni[0];
                        if (!checkdate($mIni, $dIni, $yIni)) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax('Erro', 'alert', 'A data de início da lotação é inválida.');
                        }

                        if (!empty($dcLotacao['dt_fim'])) {
                            $dtFim = explode('-', $dcLotacao['dt_fim']);
                            $dFim = $dtFim[2];
                            $mFim = $dtFim[1];
                            $yFim = $dtFim[0];
                            if (!checkdate($mFim, $dFim, $yFim)) {
                                $pdo->rollBack();
                                return Metodos::retornoAjax('Erro', 'alert', 'A data de fim da lotacao é inválida.');
                            }
                        }
                        //**********************************************************************************************

                        //**********************************************************************************************
                        $rs = $contrato->insertContratoLotacao($pdo);
                        if ($rs != "Sucesso") {
                            $sucesso = false;
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", $rs);
                        }
                        $idContratoLot = $pdo->lastInsertId('ses_contrato_lotacao_id_contrato_lotacao_seq');
                        if (!(Log::SalvaLogI('ses_contrato_lotacao', $idContratoLot, $pdo))) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar Log de Contrato Lotação");
                        }
                        //**********************************************************************************************
                    }
                }

                $rs = $contrato->update($pdo);
                if ($rs != "Sucesso") {

                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $rs);
                }

                if (Log::SalvaLogU('ses_contrato', $contrato->getId_contrato(), $busca, $pdo)) {
                    $sucesso = TRUE;
                    $msg = STR_EDICAO_SUCESSO;
                } else {
                    $sucesso = FALSE;
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", "Erro Cadastro de LOG em Update Contrato");
                }
                $sucesso = TRUE;
            }

            if ($sucesso) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", $msg);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************
    public function removerContrato() {
        try {
            //***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $contrato = new DaoSesContrato();
            $contrato->setId_contrato($this->id_contrato);
            $rs = $contrato->removeContrato($pdo);
            if ($rs != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $rs);
                $pdo->rollBack();
            }
            //***********************************************************************
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            //***********************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************
    public function editarContratoLotacao($dados) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //******************************************************************
            $data = date('Y-m-d H:i');
            $contrato = new DaoSesContrato();
            $contrato->setId_contrato($dados['idContrato']);
            $contrato->setId_lotacao($dados['idLotacao']);
            $contrato->setId_funcao($dados['idFuncao']);
            $contrato->setId_contrato_lotacao($dados['idContratoLotacao']);
            $contrato->setCarga_horaria_lotacao($dados['cargaLotacao']);
            $contrato->setDt_inicio($dados['dataIni']);
            $contrato->setDt_fim($dados['dataFim']);
            $contrato->setDt_historico($data);
            //***********************************************
            $busca = $contrato->retornaContratoLotacao($pdo);
            if (!$busca) {
                $sucesso = FALSE;
                $retorno = Metodos::retornoAjax("Erro", "console", $busca);
                $pdo->rollBack();
                return $retorno;
            }



            $rs = $contrato->updateContratoLotacao($pdo);

            if ($rs != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $rs);
                $pdo->rollBack();
                return $retorno;
            }

            if (Log::SalvaLogU('ses_contrato_lotacao', $contrato->getId_contrato_lotacao(), $busca, $pdo)) {
                $sucesso = TRUE;
                $msg = "Item Atualizado com Sucesso";
            } else {
                $sucesso = FALSE;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", "Erro Cadastro de LOG em Update Contrato");
            }

            //*********************histórico*************************************

            $contrato->setDs_observacao("Atualização do Contrato Lotação");
            $contrato->setId_contrato_situacao(NULL);
            $rs1 = $contrato->insertContratoHistorico($pdo);
            if ($rs1 != "Sucesso") {
                $sucesso = false;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $rs1);
            }
            $idContratoHist = $pdo->lastInsertId('ses_contrato_historico_id_contrato_historico_seq');
            if (!(Log::SalvaLogI('ses_contrato_historico', $idContratoHist, $pdo))) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar Log de Contrato Histórico");
            }
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", $msg);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************
    public function editarContratoHistorico($dados) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //******************************************************************

            $contrato = new DaoSesContrato();
            $contrato->setId_contrato_historico($dados['idContratoHistorico']);
            $contrato->setId_contrato($dados['idContrato']);
            $contrato->setId_contrato_situacao($dados['idContratoSituacao']);
            $contrato->setDt_inicio($dados['dataIni']);
            $contrato->setDt_fim($dados['dataFim']);
            //***********************************************
            $busca = $contrato->retornaContratoHistorico($pdo);
            if (!$busca) {
                $sucesso = FALSE;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $busca);
            }

            $rs = $contrato->updateContratoHistorico($pdo);

            if ($rs != "Sucesso") {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $rs);
            }
            if (Log::SalvaLogU('ses_contrato_historico', $contrato->getId_contrato_historico(), $busca, $pdo)) {
                $sucesso = TRUE;
                $msg = "Item Atualizado com Sucesso";
            } else {
                $sucesso = FALSE;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", "Erro Cadastro de LOG em Update Contrato");
            }
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", $msg);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************
    public function cadastrarContratoLotacao($dados) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            //******************************************************************
            $contrato = new DaoSesContrato();
            $contrato->setId_contrato($dados['idContrato']);
            $contrato->setCarga_horaria_lotacao($dados['cargaLotacao']);
            $contrato->setId_lotacao($dados['idLotacao']);
            $contrato->setId_funcao($dados['idFuncao']);
            $contrato->setDt_inicio($dados['dataIni']);
            $contrato->setDt_fim($dados['dataFim']);
            $rs = $contrato->insertContratoLotacao($pdo);
            if ($rs != "Sucesso") {
                $sucesso = false;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $rs);
            }
            $idContratoLot = $pdo->lastInsertId('ses_contrato_lotacao_id_contrato_lotacao_seq');
            if (!(Log::SalvaLogI('ses_contrato_lotacao', $idContratoLot, $pdo))) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar Log de Contrato Lotação");
            }
            //*********************histórico*************************************
            $data = date('Y-m-d H:i');
            $contrato->setDs_observacao("Cadastro do Contrato");
            $contrato->setId_contrato_situacao(NULL);
            $contrato->setDt_historico($data);
            $rs1 = $contrato->insertContratoHistorico($pdo);
            if ($rs1 != "Sucesso") {
                $sucesso = false;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $rs1);
            }
            $idContratoHist = $pdo->lastInsertId('ses_contrato_historico_id_contrato_historico_seq');
            if (!(Log::SalvaLogI('ses_contrato_historico', $idContratoHist, $pdo))) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar Log de Contrato Histórico");
            }
            $sucesso = true;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************
    public function CadastraSituacao($dados) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //******************************************************************
            $data = date('Y-m-d H:i');
            $contrato = new DaoSesContrato();
            $contrato->setCarga_horaria_lotacao(NULL);
            $contrato->setId_lotacao(NULL);
            $contrato->setId_funcao(NULL);
            $contrato->setId_contrato($dados['idContrato']);
            $contrato->setId_contrato_situacao($dados['idSituacao']);
            $contrato->setDs_observacao($dados['dsObs']);
            $contrato->setDt_inicio($dados['dtInicio']);
            $contrato->setDt_fim($dados['dtFim']);
            $contrato->setDt_historico($data);
            //******************************************************************

            $rs = $contrato->insertContratoHistorico($pdo);
            if ($rs != "Sucesso") {
                $sucesso = false;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $rs);
            }
            $idContratoHist = $pdo->lastInsertId('ses_contrato_historico_id_contrato_historico_seq');
            if (!(Log::SalvaLogI('ses_contrato_historico', $idContratoHist, $pdo))) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar Log de Contrato Histórico");
            }
            $pdo->commit();
            return Metodos::retornoAjax("ok", "alert", STR_CADASTRO_SUCESSO);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //*******************************************************************************************************
    public function retornaTrPessoaFisica($nome, $cpf, $matricula, $vinculo, $lotacao, $ferias) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesContrato();
            $filtro = "";
            //***************************************************************
            $filter = array();
            if (!empty($nome)) {
                $filter[] = "unaccent(P.nm_pessoa) ilike '%$nome%' or P.nm_pessoa ilike '%$nome%'";
            }
            if (!empty($cpf)) {
                $filter[] = "PF.nr_cpf = '".Metodos::limpaCPF_CNPJ($cpf)."'";
            }
            if (!empty($matricula)) {
                $filter[] = "c.nr_matricula ilike '%$matricula%'";
            }
            if (!empty($vinculo)) {
                $filter[] = "v.id_vinculo = $vinculo";
            }
            if (!empty($lotacao)) {
                $filter[] = "l.id_lotacao = $lotacao";
            }
            //*************************************************
            if (count($filter) > 0) {
                $filtro = " and " . implode(' and ', $filter);
            } else {
                return false;
            }
            //****************************************************************
            $result = $rh->retornaTodosFuncionarios($pdo, $filtro, $ferias);

            if (!$result) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idPessoa = $v['id_pessoa'];
                    $idPessoaFisica = $v['id_pessoa_fisica'];
                    $idContrato = $v['id_contrato'];
                    $retorno .= "<tr>";
                    if ($ferias) {
                        //**************formatar mascara cpf************************
                        $cpf2 = Metodos::formataCpf($v['nr_cpf']);
                        //*****************************************
                        $retorno .= "   <td>" . $v['nm_pessoa'] . "</td>
                                        <td>" . $cpf2 . "</td>
                                        <td>" . $v['nr_matricula'] . "</td>   
                                        <td>" . $v['nm_vinculo'] . "</td>
                                        <td>" . $v['nm_cargo'] . "</td>   
                                        <td>" . $v['nm_lotacao'] . "</td>   
                                        <td style='text-align: center;'>                           
                                            <button type='button' class='btn btn-default btn-registrar btn-xs'                               
                                              title='Registrar' nome='" . $v['nm_pessoa'] . "' value='" . $idContrato . "/" . $idPessoaFisica . "' >
                                               <i class='fa fa-search-plus fa-lg text-info' aria-hidden='true'></i>                                
                                            </button> 
                                        </td>
                                 </tr>";
                    } else {
                        //************ formatar mascara do telefone ****************
                        $telefone = explode(",", $v['nr_telefone_funcional']);
                        $numeros = "";
                        foreach ($telefone as $nr) {
                            $numeros .= Metodos::formataTelefone(trim($nr)) . ", ";
                        }
                        $numeros = substr($numeros, 0, strlen($numeros) - 2);
                        //*********************************************************
                        $ativo = $v['st_ativo'] === '0' ? "<td class='text-danger text-center'>INATIVO</td>" : "<td class= 'text-center'>ATIVO</td>";
                        //*********************************************************
                        $retorno .= "   <td>" . $v['nm_pessoa'] . "</td>
                                        <td>" . $v['nr_matricula'] . "</td>   
                                        <td>" . $v['nm_vinculo'] . "</td>
                                        <td>" . $v['nm_cargo'] . "</td>   
                                        <td>" . $v['nm_lotacao'] . "</td>"
                                . $ativo .
                                "<td>" . $numeros . "</td>
                                        <td>" . $v['nm_email'] . "</td>
                                        <td style='text-align: center;'>                           
                                            <button type='button' class='btn btn-default btn-edit btn-xs'                               
                                                  title='Editar' nome='" . $v['nm_pessoa'] . "' value='" . $idContrato . "/" . $idPessoaFisica . "' >
                                                  <i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>                                
                                            </button>
                                            <button type='button' class='btn btn-default btn-perfil btn-xs' title='Configurar Perfil' value='" . $idPessoaFisica . "'>
                                                <i class='fa fa-lock fa-lg text-success' aria-hidden='true'></i>
                                            </button> 
                                            <button type='button' class='btn btn-default btn-remover btn-xs' title='Remover' value='" . $idContrato . "'>
                                                <i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>
                                            </button>
                                            <button type='button' class='btn btn-default btn-redefinir btn-xs' title='Redefinir Senha' value='" . $idPessoa . "'>
                                                <i class='fa fa-key fa-lg text-warning' aria-hidden='true'></i>
                                            </button>";

                        if ($v['st_login']) {
                            $retorno .="    <button type='button' class='btn btn-default btn-login-desativar btn-xs' title='Desativar Login' value='" . $idPessoa . "'>
                                                <i class='fa fa-power-off fa-lg text-danger' aria-hidden='true'></i>
                                            </button>";
                        } else {
                            $retorno .="    <button type='button' class='btn btn-default btn-login-ativar btn-xs' title='Ativar Login' value='" . $idPessoa . "'>
                                                <i class='fa fa-power-off fa-lg text-success' aria-hidden='true'></i>
                                            </button>";
                        }

                        $retorno .="    </td>
                                    </tr>";
                    }
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

//*******************************************************************************************************
    public function pesquisaRelatorioCompetencia($idFormacao) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesContrato();
            $filtro = "";
            //***************************************************************
            $filter = array();
            if ($idFormacao <> 0) {
                $filter[] = "ef.id_escolaridade_formacao = $idFormacao";
            }

            //*************************************************

            if (count($filter) > 0) {
                $filtro = " and " . implode(' and ', $filter);
            } else {
                return false;
            }
            //****************************************************************
            //print_r($filtro);
            $result = $rh->retornaRelatorioCompetencia($pdo, $filtro);

            return $result;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function pesquisaRelatorioVinculo($idVinculo, $idLotacao, $idCargo, $idFuncao, $dataInicio, $dataFim, $tipo) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesContrato();
            $filtro = "";
            //***************************************************************
            $filter = array();
            if ($idVinculo <> 0) {
                $filter[] = "v.id_vinculo = $idVinculo";
            }
            if ($idLotacao <> 0) {
                $filter[] = "l.id_lotacao = $idLotacao";
            }
            if ($idCargo <> 0) {
                $filter[] = "cg.id_cargo = $idCargo";
            }
            if ($idFuncao <> 0) {
                $filter[] = "f.id_funcao = $idFuncao";
            }
            if ($dataInicio <> 0 && $dataFim <> 0) {
                $dataInicio = explode('/', $dataInicio)[2] . '-' . explode('/', $dataInicio)[1] . '-' . explode('/', $dataInicio)[0];
                $dataFim = explode('/', $dataFim)[2] . '-' . explode('/', $dataFim)[1] . '-' . explode('/', $dataFim)[0];
                $filter[] = "(c.dt_admissao between '$dataInicio' and '$dataFim')";
            }

            //*************************************************

            if (count($filter) > 0) {
                $filtro = " and " . implode(' and ', $filter);
            } else {
                return false;
            }
            //****************************************************************    
            //print_r($filtro);
            $result = $rh->retornaRelatorioVinculos($pdo, $filtro, $tipo);

            return $result;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    //********************************************************************************************************************
    public function pesquisaRelatorioSituacao($idVinculo, $idLotacao, $idSituacao, $mes, $ano, $tipo) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesContrato();
            $filtro = "";
            //***************************************************************
            $filter = array();
            if ($idVinculo <> 0) {
                $filter[] = "v.id_vinculo = $idVinculo";
            }
            if ($idLotacao <> 0) {
                $filter[] = "l.id_lotacao = $idLotacao";
            }
            if ($idSituacao <> 0) {
                $filter[] = "cs.id_contrato_situacao = $idSituacao";
            }
            if ($mes <> 0) {
                $filter[] = "(to_char(ch.dt_inicio, 'YYYY-MM') = '$ano-$mes' or to_char(ch.dt_fim, 'YYYY-MM') = '$ano-$mes')";
            } else {
                $filter[] = "to_char(ch.dt_inicio, 'YYYY') = '$ano'";
            }



            //*************************************************

            if (count($filter) > 0) {
                $filtro = " and " . implode(' and ', $filter);
            } else {
                return false;
            }
            //****************************************************************    
            //print_r($filtro);
            $result = $rh->retornaRelatorioSituacao($pdo, $filtro, $tipo);

            return $result;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    //*************************************************
    public function pesquisaGrafico($dataInicio, $dataFim, $todos, $tipo, $idVinculo, $idLotacao) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesContrato();
            $filtro = "";
            //***************************************************************
            if ($todos == 0) {
                $filter = array();
                if ($dataInicio <> 0 && $dataFim <> 0) {
                    $dataInicio = explode('/', $dataInicio)[2] . '-' . explode('/', $dataInicio)[1] . '-' . explode('/', $dataInicio)[0];
                    $dataFim = explode('/', $dataFim)[2] . '-' . explode('/', $dataFim)[1] . '-' . explode('/', $dataFim)[0];
                    $filter[] = "(c.dt_admissao between '$dataInicio' and '$dataFim')";
                }
                //*************************************************
                if (count($filter) > 0) {
                    $filtro = " and " . implode(' and ', $filter);
                } else {
                    return false;
                }
            } else {
                $filtro = "";
            }
            //********pro grafico 2************************************************
            if ($idVinculo <> 0) {
                $filtro .= " and v.id_vinculo = $idVinculo ";
            }
            //********pra tabela 3 do grafico************************************************
            if ($idLotacao <> 0) {
                $filtro .= "and l.id_lotacao = $idLotacao ";
            }
            //**************************************************
            $result = $rh->retornaGrafico($pdo, $filtro, $tipo);
            //****************************************************************    
            if ($tipo == 1) {
                if ($result != FALSE) {
                    $retorno = array();
                    foreach ($result as $value) {
                        $retorno[$value['id_vinculo']] = array(
                            "name" => $value["nm_vinculo"],
                            "y" => $value["total_vinculo"]);
                    }
                }
            }
            if ($tipo == 2) {
                if ($result != FALSE) {
                    $retorno = array();
                    foreach ($result as $value) {
                        $retorno[$value['id_lotacao']] = array(
                            "name" => $value["nm_lotacao"],
                            "y" => $value["total_lotacao"]);
                    }
                }
            }
            if ($tipo == 3) {
                if ($result != FALSE) {
                    $retorno = "";
                    if ($result != FALSE) {
                        foreach ($result as $linha) {
                            $idPessoaFisica = $linha['id_pessoa_fisica'];
                            $idContrato = $linha['id_contrato'];
                            echo "  <tr class='warning funcionarioLinha' idPessoaFisica= '" . $idPessoaFisica . "' idContrato= '" . $idContrato . "'> 
                                        <td class='pessoa' idPessoa='" . $linha['id_pessoa'] . "'>" . $linha['nm_pessoa'] . "</td>
                                        <td class='cargo' idCargo='" . $linha['id_cargo'] . "'>" . $linha['nm_cargo'] . "</td>
                                        <td class='funcao' idFuncao='" . $linha['id_funcao'] . "'>" . $linha['nm_funcao'] . "</td>
                                        <td class=' text-center dataIni' dt_inicio='" . $linha['carga_horaria_lotacao'] . "'>" . $linha['carga_horaria_lotacao'] . "</td>
                                    </tr>";
                        }
                        return $retorno;
                    } else {
                        return $result;
                    }
                }
            }
            return json_encode($retorno);
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    //*************************************************
    public function retornaOptionCargoPessoa() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cargo = new DaoSesContrato();
            $cargo->setId_pessoa_fisica($this->id_pessoa_fisica);
            $result = $cargo->buscaCargoPorPessoa($pdo);
//            print_r($result);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_cargo'] . "'>" . $v['nm_cargo'] . "</option>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionFuncaoPessoa() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $funcao = new DaoSesContrato();
            $funcao->setId_pessoa_fisica($this->id_pessoa_fisica);
            $result = $funcao->buscaFuncaoPorPessoa($pdo);
//            print_r($result);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_funcao'] . "'>" . $v['nm_funcao'] . "</option>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionVinculoPessoa() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $vinculo = new DaoSesContrato();
            $vinculo->setId_pessoa_fisica($this->id_pessoa_fisica);
            $result = $vinculo->buscaVinculoPorPessoa($pdo);
//            print_r($result);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_vinculo'] . "'>" . $v['nm_vinculo'] . "</option>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

//*******************************************************************************************************
    public function retornaContrato($idGet) {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        try {

            $idContrato = explode("/", $idGet)[0];
            $idPessoaFisica = explode("/", $idGet)[1];
            //*******************************************************************************************
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->setId_pessoa_fisica($idPessoaFisica);
            $pessoaFisica->setMsg("contrato");
            $pf = $pessoaFisica->retornaPessoaFisica($pdo);
            //*******************************************************************************************
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($pf['id_pessoa']);
            $pessoa->setMsg("contrato");
            $p = $pessoa->retornaPessoa($pdo);
            //*******************************************************************************************
            $contrato = new DaoSesContrato();
            $contrato->setId_contrato($idContrato);
            $rs = $contrato->retornaContrato($pdo);
            //*******************************************

            if ($rs != FALSE) {
                $retorno[] = array(
                    //***********************pessoa****************************************
                    "nm_social" => $p["nm_pessoa"],
                    "id_pais_naturalidade" => $p["id_pais_naturalidade"],
                    "id_estado_naturalidade" => $p["id_estado_naturalidade"],
                    "id_naturalidade" => $p["id_naturalidade"],
                    "ds_logradouro" => $p["ds_logradouro"],
                    "ds_complemento" => $p["ds_complemento"],
                    "ds_bairro" => $p["ds_bairro"],
                    "nr_cep" => $p["nr_cep"],
                    "id_pais_endereco" => $p["id_pais_endereco"],
                    "id_estado_endereco" => $p["id_estado_endereco"],
                    "id_cidade" => $p["id_cidade_endereco"],
                    "nr_telefone_residencial" => $p["nr_telefone_residencial"],
                    "nr_telefone_celular" => $p["nr_telefone_celular"],
                    "nm_email" => $p["nm_email"],
                    "ds_observacao" => $p["ds_observacao"],
                    //************************pessoaFisica***************************************
                    "id_pessoa_fisica" => $pf["id_pessoa_fisica"],
                    "id_pessoa" => $pf["id_pessoa"],
                    "tp_sexo" => $pf["tp_sexo"],
                    "nm_civil" => $pf["nm_civil"],
                    "nr_cpf" => $pf["nr_cpf"],
                    "nr_rg" => $pf["nr_rg"],
                    "ds_orgao_expedidor" => $pf["ds_orgao_expedidor"],
                    "id_estado_orgao_expedidor" => $pf["id_estado_orgao_expedidor"],
                    "ds_habilidade" => $pf["ds_habilidade"],
                    "id_estado_civil" => $pf["id_estado_civil"],
                    "nm_mae" => $pf["nm_mae"],
                    "nm_pai" => $pf["nm_pai"],
                    "dt_nascimento" => $pf["dt_nascimento"] == "" ? $pf["dt_nascimento"] : date("d/m/Y", strtotime($pf["dt_nascimento"])),
                    "nr_cns" => $pf["nr_cns"],
                    "id_escolaridade" => $pf["id_escolaridade"],
                    "st_ativo" => $pf["st_ativo"],
                    //************************contrato****************************************
                    "id_contrato" => $rs["id_contrato"],
                    "id_vinculo" => $rs["id_vinculo"],
                    "id_pessoa_juridica" => $rs["id_pessoa_juridica"],
                    "dt_admissao" => $rs["dt_admissao"] == "" ? $rs["dt_admissao"] : date("d/m/Y", strtotime($rs["dt_admissao"])),
                    "dt_demissao" => $rs["dt_demissao"] == "" ? $rs["dt_demissao"] : date("d/m/Y", strtotime($rs["dt_demissao"])),
                    "nr_carga_horaria" => $rs["nr_carga_horaria"],
                    "nr_matricula" => $rs["nr_matricula"],
                    "id_cargo" => $rs["id_cargo"]
                );
            }
            return json_encode($retorno);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************
    public function retornaPessoaFisica($cpf) {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        try {

            //*******************************************************************************************
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->setNr_cpf($cpf);
            $pessoaFisica->setMsg("contrato");
            $pf = $pessoaFisica->retornaPessoaFisica($pdo);
            if ($pf == FALSE) {
                return FALSE;
            }
            //*******************************************************************************************
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($pf['id_pessoa']);
            $pessoa->setMsg("contrato");
            $p = $pessoa->retornaPessoa($pdo);
            //*******************************************************************************************
            $contrato = new DaoSesContrato();
            $contrato->setId_pessoa_fisica($pf['id_pessoa_fisica']);
            $c = $contrato->retornaContrato($pdo);
            $contratos = 0;
            $dataAtual = date('d/m/Y');
            if (empty($c)) {
                $matricula = "";
            } else {
                $matricula = $c[0]['nr_matricula'];
                $contratos = count($c);
            }
            //*******************************************
            //if ($rs != FALSE) {
            $retorno[] = array(//***********************pessoa****************************************
                "nm_social" => $p["nm_pessoa"],
                "id_naturalidade" => $p["id_naturalidade"],
                "id_estado_naturalidade" => $p["id_estado_naturalidade"],
                "id_pais_naturalidade" => $p["id_pais_naturalidade"],
                "ds_logradouro" => $p["ds_logradouro"],
                "ds_complemento" => $p["ds_complemento"],
                "ds_bairro" => $p["ds_bairro"],
                "nr_cep" => $p["nr_cep"],
                "id_cidade_endereco" => $p["id_cidade_endereco"],
                "id_estado_endereco" => $p["id_estado_endereco"],
                "id_pais_endereco" => $p["id_pais_endereco"],
                "nr_telefone_residencial" => $p["nr_telefone_residencial"],
                "nr_telefone_celular" => $p["nr_telefone_celular"],
                "nm_email" => $p["nm_email"],
                "ds_observacao" => $p["ds_observacao"],
                //************************pessoaFisica***************************************
                "id_pessoa_fisica" => $pf["id_pessoa_fisica"],
                "id_pessoa" => $pf["id_pessoa"],
                "tp_sexo" => $pf["tp_sexo"],
                "nm_civil" => $pf["nm_civil"],
                "nr_cpf" => $pf["nr_cpf"],
                "nr_rg" => $pf["nr_rg"],
                "ds_orgao_expedidor" => $pf["ds_orgao_expedidor"],
                "id_estado_orgao_expedidor" => $pf["id_estado_orgao_expedidor"],
                "ds_habilidade" => $pf["ds_habilidade"],
                "id_estado_civil" => $pf["id_estado_civil"],
                "nm_mae" => $pf["nm_mae"],
                "nm_pai" => $pf["nm_pai"],
                "dt_nascimento" => $pf["dt_nascimento"] == "" ? $pf["dt_nascimento"] : date("d/m/Y", strtotime($pf["dt_nascimento"])),
                "nr_cns" => $pf["nr_cns"],
                "id_escolaridade" => $pf["id_escolaridade"],
                "st_ativo" => $pf["st_ativo"],
                //************************contrato****************************************
                "nr_matricula" => $matricula,
                "dataAtual" => $dataAtual,
                "nr_contratos" => $contratos,
            );
            //}
            return json_encode($retorno);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************
    public function retornaHistorico($idContrato) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $contrato = new DaoSesContrato();
            $contrato->setId_contrato($idContrato);
            $rs = $contrato->retornarHistorico($pdo);
//          ****************************************************************************
            if ($rs != FALSE) {
                foreach ($rs as $linha) {
                    echo "<tr class='warning historicoLinha' idCont= '" . $idContrato . "'> 
                                <td class='vinculo' idVinculo='" . $linha['id_vinculo'] . "'>" . $linha['nm_vinculo'] . "</td>
                                <td class='cargo' idCargo='" . $linha['id_cargo'] . "'>" . $linha['nm_cargo'] . "</td>
                                <td class='situacao' idSituacao='" . $linha['id_contrato_situacao'] . "'>" . $linha['nm_contrato_situacao'] . "</td>
                                <td class='dataIni' dt_inicio='" . $linha['dt_inicio'] . "'>" . $linha['dt_inicio'] . "</td>
                                <td class='dataFim' dt_fim='" . $linha['dt_fim'] . "'>" . $linha['dt_fim'] . "</td>
                                <td class='dataFim'>" . $linha['ds_observacao'] . "</td>
                                <td style='text-align: center;'>
                                    <button type='button' title='editar' class='editarLinha' value=" . $linha['id_contrato_historico'] . "><i class='fa fa-pencil text-success'></i></button>
                                    <button type='button' title='Remover' class='excluirLinha' value=" . $linha['id_contrato_historico'] . "><i class='fa fa-remove text-danger'></i></button>
                                </td>
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

//************************************************************************************************************************
    public function retornaLotacaoFuncao($idContrato) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $contrato = new DaoSesContrato();
            $contrato->setId_contrato($idContrato);
            $rs = $contrato->retornaLotacaoFuncao($pdo);
            //****************************************************************************
            if ($rs != FALSE) {
                foreach ($rs as $linha) {

                    echo "<tr class='warning lotacaoLinha' dataAtual='" . date('d/m/Y') . "' idCont= '" . $idContrato . "'> 
                                <td class='text-center lotacao' idLotacao='" . $linha['id_lotacao'] . "'>" . $linha['nm_lotacao'] . "</td>
                                <td class='text-center funcao' idFuncao='" . $linha['id_funcao'] . "'>" . $linha['nm_funcao'] . "</td>
                                <td class='text-center cargaLotacao'ch='" . $linha['carga_horaria_lotacao'] . "'>" . $linha['carga_horaria_lotacao'] . "</td>
                                <td class='text-center dataIni' dt_inicio='" . $linha['dt_inicio'] . "'>" . $linha['dt_inicio'] . "</td>
                                <td class='text-center dataFim' dt_fim='" . $linha['dt_fim'] . "'>" . $linha['dt_fim'] . "</td>
                                <td class='text-center'>
                                    <button type='button' title='editar' class='editarLinhaLotacao' value=" . $linha['id_contrato_lotacao'] . "><i class='fa fa-pencil text-success'></i></button>
                                    <button type='button' title='Remover' class='excluirLinhaLotacao' value=" . $linha['id_contrato_lotacao'] . "><i class='fa fa-remove text-danger'></i></button>
                                </td>
                        </tr>";
                }
            } else {
                return $rs;
            }

        //****************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************

    public function removerContratoHistorico($idContratoHistorico) {
        try {
            $retorno = "";
            //***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $contratoHistorico = new DaoSesContrato();
            $contratoHistorico->setId_contrato_historico($idContratoHistorico);
            //************************************************************************************
            $busca = $contratoHistorico->retornaContratoHistorico($pdo);
            if ($busca != FALSE) {
                if (!Log::SalvaLogD('ses_contrato_historico', $contratoHistorico->getId_contrato_historico(), $pdo)) {
                    $pdo->rollBack();
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                }
            }
            //************************************************************************************
            $rs = $contratoHistorico->removerContratoHistorico($pdo);
            if ($rs != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "alert", $rs);
            } else {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "alert", STR_REMOCAO_SUCESSO);
            }

            return $retorno;
            //***********************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************

    public function removerContratoLotacao($idContratoLotacao) {
        try {
            $retorno = "";
            //***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $contratoLotacao = new DaoSesContrato();
            $contratoLotacao->setId_contrato_lotacao($idContratoLotacao);
            //************************************************************************************
            $busca = $contratoLotacao->buscaLotacaoFuncao($pdo);
            if ($busca != FALSE) {
                if (!Log::SalvaLogD('ses_contrato_lotacao', $contratoLotacao->getId_contrato_lotacao(), $pdo)) {
                    $pdo->rollBack();
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                }
            }
            //************************************************************************************
            $rs = $contratoLotacao->removerContratoLotacao($pdo);
            if ($rs != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "alert", $rs);
            } else {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "alert", STR_REMOCAO_SUCESSO);
            }

            return $retorno;
            //***********************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//************************************************************************************************************************
    public function retornaOptionSituacao($id) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $situacao = new DaoSesContrato();

            $result = $situacao->retornaSituacao($pdo);

            if (!$result) {
                return $retorno;
            } else {
                $tipo = $result[0]['tp_situacao'];
                $retorno .= "<optgroup label='" . ($result[0]['tp_situacao'] == 'A' ? 'AFASTAMENTOS' : "") . "'>";
//                print_r($id);
                foreach ($result as $v) {
                    if ($id == $v['id_contrato_situacao']) {
                        if ($tipo == $v['tp_situacao']) {
                            $retorno .= "<option selected value = '" . $v['id_contrato_situacao'] . "'>" . $v['nm_contrato_situacao'] . "</option>";
                        } else {
                            $retorno .= "</optgroup>";
                            $retorno .= "<optgroup label='" . ($v['tp_situacao'] == 'C' ? 'CONCESSÕES' : ($v['tp_situacao'] == 'F' ? 'FÉRIAS' : ($v['tp_situacao'] == 'I' ? 'INATIVOS' : 'LICENÇAS'))) . "'>";
                            $retorno .= "<option selected value = '" . $v['id_contrato_situacao'] . "'>" . $v['nm_contrato_situacao'] . "</option>";
                            $tipo = $v['tp_situacao'];
                        }
                    } else {
                        if ($tipo == $v['tp_situacao']) {
                            $retorno .= "<option value = '" . $v['id_contrato_situacao'] . "'>" . $v['nm_contrato_situacao'] . "</option>";
                        } else {
                            $retorno .= "</optgroup>";
                            $retorno .= "<optgroup label='" . ($v['tp_situacao'] == 'C' ? 'CONCESSÕES' : ($v['tp_situacao'] == 'F' ? 'FÉRIAS' : ($v['tp_situacao'] == 'I' ? 'INATIVOS' : 'LICENÇAS'))) . "'>";
                            $retorno .= "<option value = '" . $v['id_contrato_situacao'] . "'>" . $v['nm_contrato_situacao'] . "</option>";
                            $tipo = $v['tp_situacao'];
                        }
                    }
                }
                $retorno .= "</optgroup>";
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionPessoaContrato(PDO $pdo = null, int $idPessoa = 0) {
//        $retorno = "<option value='0'>Selecione Uma Pessoa</option>";
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $cargo = new DaoSesContrato();
            $result = $cargo->retornaTodasPessoas($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($idPessoa == $v['id_pessoa']) {
                        $retorno .= "<option value = '" . $v['id_pessoa'] . "' selected>" . $v['nm_pessoa'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_pessoa'] . "'>" . $v['nm_pessoa'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionUsuarioContrato(PDO $pdo = null, int $idUsuario = 0) {
//        $retorno = "<option value='0'>Selecione um Usuário</option>";
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $cargo = new DaoSesContrato();
            $result = $cargo->retornaTodasPessoas($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($idUsuario == $v['id_pessoa']) {
                        $retorno .= "<option value = '" . $v['id_pessoa'] . "' selected>" . $v['nm_pessoa'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_pessoa'] . "'>" . $v['nm_pessoa'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionPessoaChamado(PDO $pdo = null, int $idPessoa = 0) {
//        $retorno = "<option value='0'>Selecione uma pessoa</option>";
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $cargo = new DaoSesContrato();
            $result = $cargo->retornaTodasPessoas($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($idPessoa == $v['id_pessoa']) {
                        $retorno .= "<option value = '" . $v['id_pessoa'] . "' selected>" . $v['nm_pessoa'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_pessoa'] . "'>" . $v['nm_pessoa'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionAnoSituacao($id = 0) {
//        $retorno = "<option value='0'>Selecione uma pessoa</option>";
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $cargo = new DaoSesContrato();
            $result = $cargo->retornaAnoSituacao($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($id == $v['ano']) {
                        $retorno .= "<option value = '" . $v['ano'] . "' selected>" . $v['ano'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['ano'] . "'>" . $v['ano'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaListaTodasPessoas(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $cargo = new DaoSesContrato();
            $result = $cargo->retornaTodasPessoas($pdo);
            return json_encode($result);
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaLotacaoUsuarioCentral($pdo = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoSesContrato = new DaoSesContrato();
            $daoSesContrato->setId_pessoa_fisica($this->id_pessoa_fisica);
            $result = '';
            $result = $daoSesContrato->retornaLotacaoCentral($pdo);
            $retorno = '';
            if (!empty($result)) {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_lotacao'] . "'>" . $v['nm_lotacao'] . "</option>";
                }
            }


            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function optionsFuncoesContrato(PDO $pdo = null, int $idPessoaFisica = 0, int $idFuncao = 0) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoSesContrato = new DaoSesContrato();
            $daoSesContrato->setId_pessoa_fisica($idPessoaFisica);
            $retorno = '';
            $resultado = $daoSesContrato->retornaPessoaFuncoes($pdo);

            if (!empty($resultado)) {
                foreach ($resultado as $linha) {
                    if ($idFuncao == $linha['id_funcao']) {
                        $retorno .= "<option value = '" . $linha['id_funcao'] . "' selected>" . $linha['nm_funcao'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $linha['id_funcao'] . "'>" . $linha['nm_funcao'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }

    public function retornaQtContratoPessoa($cpf = null) {
        try {
            if (empty($cpf)) {
                return;
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoSesContrato = new DaoSesContrato();
            $qt = $daoSesContrato->retornaQtContratoPessoa($pdo, $cpf);

            if (is_array($qt)) {
                return $qt['qtcontrato'];
            } else {
                return 'Erro';
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax('Erro', 'console', $ex);
        }
    }
}

?>
