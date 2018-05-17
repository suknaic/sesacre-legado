<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaFormSistemas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/formularios/formSistemas/FormSistemas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaFormInfraestrutura.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/formularios/formInfraestrutura/FormInfraestrutura.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaChamado.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/cargo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/funcao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vinculo/Vinculo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pais/Pais.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/escolaridade/Escolaridade.class.php";

class Chamado {

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

//-------------------------------------------------------------ChaChamado-----------------------------------------------------------------------
    private $idChamado = null;
    private $idCategoriaSecundaria = null;
    private $idPessoaSolicitante = null;
    private $idPessoaServico = null;
    private $dhAbertura = null;
    private $dsChamado = null;
    private $nrTelefoneSolicitante = null;
    private $dsFinalizado = null;
    private $dhFinalizado = null;
    private $nrAvaliacao = null;
    private $dhAvaliacao = null;
    private $dsAvaliacao = null;
    private $vlChamado = null;
    private $idStatus = null;
    private $dhAgendamento = null;
    private $idPrioridade = null;
    private $dhCancelamento = null;
    private $dsCancelamento = null;
    private $dtPrazo = null;
    private $anexos = null;

    function getIdChamado() {
        return $this->idChamado;
    }

    function getIdCategoriaSecundaria() {
        return $this->idCategoriaSecundaria;
    }

    function getIdPessoaSolicitante() {
        return $this->idPessoaSolicitante;
    }

    function getIdPessoaServico() {
        return $this->idPessoaServico;
    }

    function getDhAbertura() {
        return $this->dhAbertura;
    }

    function getDsChamado() {
        return $this->dsChamado;
    }

    function getNrTelefoneSolicitante() {
        return $this->nrTelefoneSolicitante;
    }

    function getDsFinalizado() {
        return $this->dsFinalizado;
    }

    function getDhFinalizado() {
        return $this->dhFinalizado;
    }

    function getNrAvaliacao() {
        return $this->nrAvaliacao;
    }

    function getDhAvaliacao() {
        return $this->dhAvaliacao;
    }

    function getDsAvaliacao() {
        return $this->dsAvaliacao;
    }

    function getVlChamado() {
        return $this->vlChamado;
    }

    function getIdStatus() {
        return $this->idStatus;
    }

    function getDhAgendamento() {
        return $this->dhAgendamento;
    }

    function getIdPrioridade() {
        return $this->idPrioridade;
    }

    function getDhCancelamento() {
        return $this->dhCancelamento;
    }

    function getDsCancelamento() {
        return $this->dsCancelamento;
    }

    function getDtPrazo() {
        return $this->dtPrazo;
    }

    function setIdChamado($idChamado) {
        $this->idChamado = $idChamado;
    }

    function setIdCategoriaSecundaria($idCategoriaSecundaria) {
        $this->idCategoriaSecundaria = $idCategoriaSecundaria;
    }

    function setIdPessoaSolicitante($idPessoaSolicitante) {
        $this->idPessoaSolicitante = $idPessoaSolicitante;
    }

    function setIdPessoaServico($idPessoaServico) {
        $this->idPessoaServico = $idPessoaServico;
    }

    function setDhAbertura($dhAbertura) {
        $this->dhAbertura = $dhAbertura;
    }

    function setDsChamado($dsChamado) {
        $this->dsChamado = $dsChamado;
    }

    function setNrTelefoneSolicitante($nrTelefoneSolicitante) {
        $this->nrTelefoneSolicitante = $nrTelefoneSolicitante;
    }

    function setDsFinalizado($dsFinalizado) {
        $this->dsFinalizado = $dsFinalizado;
    }

    function setDhFinalizado($dhFinalizado) {
        $this->dhFinalizado = $dhFinalizado;
    }

    function setNrAvaliacao($nrAvaliacao) {
        $this->nrAvaliacao = $nrAvaliacao;
    }

    function setDhAvaliacao($dhAvaliacao) {
        $this->dhAvaliacao = $dhAvaliacao;
    }

    function setDsAvaliacao($dsAvaliacao) {
        $this->dsAvaliacao = $dsAvaliacao;
    }

    function setVlChamado($vlChamado) {
        $this->vlChamado = $vlChamado;
    }

    function setIdStatus($idStatus) {
        $this->idStatus = $idStatus;
    }

    function setDhAgendamento($dhAgendamento) {
        $this->dhAgendamento = $dhAgendamento;
    }

    function setIdPrioridade($idPrioridade) {
        $this->idPrioridade = $idPrioridade;
    }

    function setDhCancelamento($dhCancelamento) {
        $this->dhCancelamento = $dhCancelamento;
    }

    function setDsCancelamento($dsCancelamento) {
        $this->dsCancelamento = $dsCancelamento;
    }

    function setDtPrazo($dtPrazo) {
        $this->dtPrazo = $dtPrazo;
    }

    function getAnexos() {
        return $this->anexos;
    }

    function setAnexos($anexos) {
        $this->anexos = $anexos;
    }

    public function salvarChamado($dadosFormSistema, $dadosFormInfraestrutura) {
        try {
            $sucesso = false;
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //******************************************** Chamado ********************************************
            $chamado = new DaoChaChamado();
            $chamado->setIdCategoriaSecundaria(trim($this->idCategoriaSecundaria));
            $chamado->setIdPessoaSolicitante(trim($this->idPessoaSolicitante));
            $chamado->setIdPessoaServico(trim($this->idPessoaServico));
            $chamado->setDhAbertura(trim($this->dhAbertura));
            $chamado->setDsChamado(trim($this->dsChamado));
            $chamado->setNrTelefoneSolicitante(trim($this->nrTelefoneSolicitante));
            $chamado->setDsFinalizado(trim($this->dsFinalizado));
            $chamado->setDhFinalizado(trim($this->dhFinalizado));
            $chamado->setNrAvaliacao(trim($this->nrAvaliacao));
            $chamado->setDhAvaliacao(trim($this->dhAvaliacao));
            $chamado->setDsAvaliacao(trim($this->dsAvaliacao));
            $chamado->setVlChamado(trim($this->vlChamado));
            $chamado->setIdStatus(trim($this->idStatus));
            $chamado->setDhAgendamento(trim($this->dhAgendamento));
            $chamado->setIdPrioridade(trim($this->idPrioridade));
            $chamado->setDhCancelamento(trim($this->dhCancelamento));
            $chamado->setDsCancelamento(trim($this->dsCancelamento));
            $chamado->setDtPrazo(trim($this->dtPrazo));
            $rs = $chamado->insert($pdo);

            if ($rs != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($rs);
                $pdo->rollBack();
                return;
            }

            $chamado->setIdChamado($pdo->lastInsertId('cha_chamado_id_chamado_seq'));
            if (Log::SalvaLogI('cha_chamado', $chamado->getIdChamado(), $pdo)) {
                $this->setSuccess(TRUE);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", "Erro ao Cadastrar Log de Cha_Chamado");
            }

            $idChamado = $chamado->getIdChamado();

            //******************************************** FormSistemas ********************************************
            $sis = new FormSistemas();
            $sis->setIdChamado($idChamado);
            $sis->setNmPessoa(trim($dadosFormSistema['nmPessoa']));
            $sis->setDsEmail(trim($dadosFormSistema['dsEmail']));
            $sis->setNrTelefone(trim($dadosFormSistema['nrTelefone']));
            $sis->setNrCartaoSus(trim($dadosFormSistema['nrCartaoSus']));
            $sis->setNrCpf(trim($dadosFormSistema['nrCpf']));
            $sis->setNrRg(trim($dadosFormSistema['nrRg']));
            $sis->setNrTelefoneSetor(trim($dadosFormSistema['nrTelefoneSetor']));
            $sis->setNrMatricula(trim($dadosFormSistema['nrMatricula']));
            $sis->setNmModulo(trim($dadosFormSistema['nmModulo']));
            $sis->setNrPortaria(trim($dadosFormSistema['nrPortaria']));
            $sis->setNmSetor(trim($dadosFormSistema['nmSetor']));
            $sis->setCdSetor(trim($dadosFormSistema['cdSetor']));
            $sis->setNmResponsavel(trim($dadosFormSistema['nmResponsavel']));
            $sis->setNrParticipantes(trim($dadosFormSistema['nrParticipantes']));
            $sis->setDsSenhaDesejada(trim($dadosFormSistema['dsSenhaDesejada']));
            $sis->setNmExame(trim($dadosFormSistema['nmExame']));
            $sis->setDsExameParametro(trim($dadosFormSistema['dsExameParametro']));
            $sis->setNmPermissao(trim($dadosFormSistema['nmPermissao']));
            $sis->setNmConselho(trim($dadosFormSistema['nmConselho']));
            $sis->setNrConselho(trim($dadosFormSistema['nrConselho']));
            $sis->setDtInicial(trim($dadosFormSistema['dtInicial']));
            $sis->setDtFim(trim($dadosFormSistema['dtFim']));
            $sis->setDtNascimento(trim($dadosFormSistema['dtNascimento']));
            $sis->setIdCargo(trim($dadosFormSistema['idCargo']));
            $sis->setIdFuncao(trim($dadosFormSistema['idFuncao']));
            $sis->setIdLotacao(trim($dadosFormSistema['idLotacao']));
            $sis->setIdVinculo(trim($dadosFormSistema['idVinculo']));
            $rs2 = $sis->cadastrarFormSistemas($pdo);

            if ($sis->getSuccess()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "alert", STR_CADASTRO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", $sis->getMsg());
                return $retorno;
            }

            $inf = new FormInfraestrutura();
            $inf->setIdChamado($idChamado);
            $inf->setTpLiberacao(trim($dadosFormInfraestrutura['tpLiberacao']));
            $inf->setNmPessoa(trim($dadosFormInfraestrutura['nmPessoa']));
            $inf->setIdCargo(trim($dadosFormInfraestrutura['idCargo']));
            $inf->setIdFuncao(trim($dadosFormInfraestrutura['idFuncao']));
            $inf->setIdLotacao(trim($dadosFormInfraestrutura['idLotacao']));
            $inf->setNmEmail(trim($dadosFormInfraestrutura['nmEmail']));
            $inf->setDsAndar(trim($dadosFormInfraestrutura['dsAndar']));
            $inf->setQtPontos(trim($dadosFormInfraestrutura['qtPontos']));
            $inf->setQtCabos(trim($dadosFormInfraestrutura['qtCabos']));
            $inf->setNmApp(trim($dadosFormInfraestrutura['nmApp']));
            $inf->setQtPatchCord(trim($dadosFormInfraestrutura['qtPatchCord']));
            $inf->setDsJustificativa(trim($dadosFormInfraestrutura['dsJustificativa']));
            $inf->setNrVlan(trim($dadosFormInfraestrutura['nrVlan']));
            $inf->setQtKeystone(trim($dadosFormInfraestrutura['qtKeystone']));
            $inf->setQtRj45(trim($dadosFormInfraestrutura['qtRj45']));
            $inf->setQtRack(trim($dadosFormInfraestrutura['qtRack']));
            $inf->setNmPasta(trim($dadosFormInfraestrutura['nmPasta']));
            $inf->setDsDestino(trim($dadosFormInfraestrutura['dsDestino']));
            $inf->setQtComputador(trim($dadosFormInfraestrutura['qtComputador']));
            $inf->setQtImpressora(trim($dadosFormInfraestrutura['qtImpressora']));
            $inf->setQtTelefone(trim($dadosFormInfraestrutura['qtTelefone']));
            $inf->setDsIpGateway(trim($dadosFormInfraestrutura['dsIpGateway']));
            $inf->setNrTelefone(trim($dadosFormInfraestrutura['nrTelefone']));
            $rs3 = $inf->cadastrarFormInfraestrutura($pdo);

            if ($inf->getSuccess()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "alert", STR_CADASTRO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", $inf->getMsg());
                return $retorno;
            }
        } catch (Exception $exc) {
//
        }
    }

    public function editarChamado($dadosFormSistema) {
        try {
            $sucesso = false;
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //******************************************** Chamado ********************************************
            $chamado = new DaoChaChamado();
            $chamado->setIdChamado(trim($this->idChamado));
            $chamado->setIdCategoriaSecundaria(trim($this->idCategoriaSecundaria));
            $chamado->setIdPessoaServico(trim($this->idPessoaServico));
            $chamado->setDsChamado(trim($this->dsChamado));
            $chamado->setNrTelefoneSolicitante(trim($this->nrTelefoneSolicitante));
            $chamado->setIdStatus(trim($this->idStatus));
            $chamado->setDhAgendamento(trim($this->dhAgendamento));
            $chamado->setIdPrioridade(trim($this->idPrioridade));
            $chamado->setDtPrazo(trim($this->dtPrazo));
            $rs = $chamado->update($pdo);


            if ($rs != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($rs);
                $pdo->rollBack();
                return;
            }
            print_r($rs);
            return;

            if (Log::SalvaLogU('cha_chamado', $chamado->getIdChamado(), $pdo)) {
                $this->setSuccess(TRUE);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", "Erro ao Cadastrar Log de Cha_Chamado");
            }

            $idChamado = $chamado->getIdChamado();

            //******************************************** FormSistemas ********************************************
            $sis = new FormSistemas();
            $sis->setIdChamado($idChamado);
            $sis->setNmPessoa(trim($dadosFormSistema['nmPessoa']));
            $sis->setDsEmail(trim($dadosFormSistema['dsEmail']));
            $sis->setNrTelefone(trim($dadosFormSistema['nrTelefone']));
            $sis->setNrCartaoSus(trim($dadosFormSistema['nrCartaoSus']));
            $sis->setNrCpf(trim($dadosFormSistema['nrCpf']));
            $sis->setNrRg(trim($dadosFormSistema['nrRg']));
            $sis->setNrTelefoneSetor(trim($dadosFormSistema['nrTelefoneSetor']));
            $sis->setNrMatricula(trim($dadosFormSistema['nrMatricula']));
            $sis->setNmModulo(trim($dadosFormSistema['nmModulo']));
            $sis->setNrPortaria(trim($dadosFormSistema['nrPortaria']));
            $sis->setNmSetor(trim($dadosFormSistema['nmSetor']));
            $sis->setCdSetor(trim($dadosFormSistema['cdSetor']));
            $sis->setNmResponsavel(trim($dadosFormSistema['nmResponsavel']));
            $sis->setNrParticipantes(trim($dadosFormSistema['nrParticipantes']));
            $sis->setDsSenhaDesejada(trim($dadosFormSistema['dsSenhaDesejada']));
            $sis->setNmExame(trim($dadosFormSistema['nmExame']));
            $sis->setDsExameParametro(trim($dadosFormSistema['dsExameParametro']));
            $sis->setNmPermissao(trim($dadosFormSistema['nmPermissao']));
            $sis->setNmConselho(trim($dadosFormSistema['nmConselho']));
            $sis->setNrConselho(trim($dadosFormSistema['nrConselho']));
            $sis->setDtInicial(trim($dadosFormSistema['dtInicial']));
            $sis->setDtFim(trim($dadosFormSistema['dtFim']));
            $sis->setDtNascimento(trim($dadosFormSistema['dtNascimento']));
            $sis->setIdCargo(trim($dadosFormSistema['idCargo']));
            $sis->setIdFuncao(trim($dadosFormSistema['idFuncao']));
            $sis->setIdLotacao(trim($dadosFormSistema['idLotacao']));
            $sis->setIdVinculo(trim($dadosFormSistema['idVinculo']));
            $rs2 = $sis->editarFormSistemas($pdo);

            if ($sis->getSuccess()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "alert", STR_EDICAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", $sis->getMsg());
                return $retorno;
            }
        } catch (Exception $exc) {
//
        }
    }

//    public function editarChamado($pdo) {
//        try {
//            $sucesso = false;
//            //**************************************
//            $chamado->setId_chamado($idChamado);
//            $chamado->setNm_pessoa($this->getNmPessoa());
//            $chamado->setDs_email($this->getDsEmail());
//            $chamado->setNr_telefone($this->getNrTelefone());
//            $chamado->setNr_cartao_sus($this->getNrCartaoSus());
//            $chamado->setNr_cpf($this->getNrCpf());
//            $chamado->setNr_rg($this->getNrRg());
//            $chamado->setNr_telefone_setor($this->getNrTelefoneSetor());
//            $chamado->setNr_matricula($this->getNrMatricula());
//            $chamado->setNm_modulo($this->getNmModulo());
//            $chamado->setNr_portaria($this->getNrPortaria());
//            $chamado->setNm_setor($this->getNmSetor());
//            $chamado->setCd_setor($this->getCdSetor());
//            $chamado->setNm_responsavel($this->getNmResponsavel());
//            $chamado->setNr_participantes($this->getNrParticipantes());
//            $chamado->setDs_senha_desejada($this->getDsSenhaDesejada());
//            $chamado->setNm_exame($this->getNmExame());
//            $chamado->setDs_exame_paramentro($this->getDsExameParamentro());
//            $chamado->setNm_permissao($this->getNmPermissao());
//            $chamado->setNm_conselho($this->getNmConselho());
//            $chamado->setNr_conselho($this->getNrConselho());
//            $chamado->setDt_inicial($this->getDtInicial());
//            $chamado->setDt_fim($this->getDtFim());
//            $chamado->setDt_nascimento($this->getDtNascimento());
//            $chamado->setId_cargo($this->getIdCargo());
//            $chamado->setId_funcao($this->getIdFuncao());
//            $chamado->setId_lotacao($this->getIdLotacao());
//            $chamado->setId_vinculo($this->getIdVinculo());
//            //***********************************************************************
//            //*************************************************************************
//            $busca = $chamado->retornaChamado($pdo);
//            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &4 ");
//            if (!$busca) {
//
//                $this->setSuccess(false);
//                $this->setMsg("Erro ao Buscar o Chamado");
//                $pdo->rollBack();
//                return;
//            }
//            //*****************************************
//            $result = $chamado->update($pdo);
//            //*****************************************
//            if ($result != "Sucesso") {
//                $this->setSuccess(false);
//                $this->setMsg($result);
//                $pdo->rollBack();
//                return;
//            }
//
//            if (Log::SalvaLogU('cha_form_sistemas', $this->getIdFormSistemas(), $busca, $pdo)) {
//                $this->setSuccess(TRUE);
//                return;
//            } else {
//                $this->setSuccess(false);
//                $this->setMsg("ERRO de LOG em UPDATE de CHAMADO");
//                $pdo->rollBack();
//                return;
//            }
//        } catch (Exception $exc) {
//            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
//        }
//    }

    public function removerChamado($pdo) {
        try {
            $chamado = new DaoChaChamado();
            $chamado->setIdChamado($this->idChamado);

            $buscaChamado = $chamado->retornaTodosChamados($pdo);
            if ($buscaChamado = FALSE) {
                if (!Log::SalvaLogD('cha_chamado', $chamado->getIdChamado(), $pdo)) {
                    $pdo->rollBack();
                    $this->setMsg("alert", "Erro ao Cadastrar Log de Chamado");
                    $this->setSuccess(false);
                    return;
                }
            }
            //***************************************************************************************
            $rs = $chamado->delete($pdo);
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

    public function cancela() {
        try {
            if ($this->idChamado == "") {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $cha = new DaoChaChamado();
            $cha->setIdChamado($this->idChamado);


            $busca = $cha->retornaChamado($pdo);
            $cha->verificaChamado($pdo);
            if (!$cha->getSucesso()) {
                return Metodos::retornoAjax("Erro", "alert", $cha->getMensagem());
            }
            $resultDao = $cha->cancela($pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }
//             print_r($retorno);
//            return;
            if (Log::SalvaLogU('cha_chamado', $this->getIdChamado(), $busca, $pdo)) {
                $sucesso = true;
            } else {
                $sucesso = FALSE;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cancelamento realizado com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, Contate o Administrador do Sistema.");
                $pdo->rollBack();
                return $retorno;
            }
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPessoa() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            /* @var $pdo PDO */
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($this->idPessoaSolicitante);
            $pessoa->setMsg("contrato");
            $p = $pessoa->retornaPessoa($pdo);

            //**************************************
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->setId_pessoa($this->idPessoaSolicitante);
            $pf = $pessoaFisica->retornaPf($pdo);
            //*****************************************
            $contrato = new DaoSesContrato();
            $contrato->setId_contrato($this->idPessoaSolicitante);
            $c = $contrato->retornaContrato($pdo);
            //*****************************************
            $funcao = new DaoSesFuncao();
            $funcao->setId_funcao($this->idPessoaSolicitante);
            $f = $funcao->retornaFuncoes($pdo);
            //*****************************************
//            $chamado = new DaoChaChamado();
//            $chamado->setIdChamado($this->idPessoaSolicitante);
//            $ch = $chamado->retornaFuncoes($pdo);

            if ($p != FALSE) {
                $retorno[] = array(
                    //***********************pessoa****************************************
                    "nm_pessoa" => $p['nm_pessoa'],
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
                    "id_contrato" => $c["id_contrato"],
                    "id_vinculo" => $c["id_vinculo"],
                    "id_pessoa_juridica" => $c["id_pessoa_juridica"],
                    "dt_admissao" => $c["dt_admissao"] == "" ? $c["dt_admissao"] : date("d/m/Y", strtotime($c["dt_admissao"])),
                    "dt_demissao" => $c["dt_demissao"] == "" ? $c["dt_demissao"] : date("d/m/Y", strtotime($c["dt_demissao"])),
                    "nr_carga_horaria" => $c["nr_carga_horaria"],
                    "nr_matricula" => $c["nr_matricula"],
                    "id_cargo" => $c["id_cargo"],
                        //************************Chamado****************************************
//                    "nmPessoa" => $l["id_lotacao"],
//                    "id_pai" => $l["id_pai"],
//                    "id_lotacao_categoria" => $l["id_lotacao_categoria"],
//                    "nm_lotacao" => $l["nm_lotacao"],
//                    "nr_telefone" => $l["nr_telefone"]
                );
            }
            return json_encode($retorno);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaChamadoVisualiza($idGet) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            /* @var $pdo PDO */
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($this->idPessoaSolicitante);
            $pessoa->setMsg("contrato");
            $p = $pessoa->retornaPessoa($pdo);

            //**************************************
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->setId_pessoa($this->idPessoaSolicitante);
            $pf = $pessoaFisica->retornaPf($pdo);
            //*****************************************
            $contrato = new DaoSesContrato();
            $contrato->setId_contrato($this->idPessoaSolicitante);
            $c = $contrato->retornaContrato($pdo);
            //*****************************************
            $funcao = new DaoSesFuncao();
            $funcao->setId_funcao($this->idPessoaSolicitante);
            $f = $funcao->retornaFuncoes($pdo);
            //*****************************************
            $chamado = new DaoChaChamado();
            $chamado->setIdChamado($this->idChamado);
            $ch = $chamado->retornaChamado($pdo);

            $sistema = new FormSistemas();
            $sistema->setIdFormSistemas($this->idPessoaSolicitante);
            $s = $sistema->retornaFormSistemas($pdo);
//            print_r($sistema);

            if ($ch != FALSE) {
                $retorno[] = array(
                    //************************Chamado****************************************
                    "idChamado" => $ch["id_chamado"],
                    "idCategoriaSecundaria" => $ch["id_categoria_secundaria"],
                    "idPessoaSolicitante" => $ch["id_pessoa_solicitante"],
                    "idPessoaServico" => $ch["id_pessoa_servico"],
                    "dhAbertura" => $ch["dh_abertura"],
                    "dsChamado" => $ch["ds_chamado"],
                    "nrTelefoneSolicitante" => $ch["nr_telefone_solicitante"],
                    "dsFinalizado" => $ch["ds_finalizado"],
                    "dhFinalizado" => $ch["dh_finalizado"],
                    "nrAvaliacao" => $ch["nr_avaliacao"],
                    "dhAvaliacao" => $ch["dh_avaliacao"],
                    "dsAvaliacao" => $ch["ds_avaliacao"],
                    "vlChamado" => $ch["vl_chamado"],
                    "idStatus" => $ch["id_status"],
                    "dhAgendamento" => $ch["dh_agendamento"],
                    "idPrioridade" => $ch["id_prioridade"],
                    "dhCancelamento" => $ch["dh_cancelamento"],
                    "dsCancelamento" => $ch["ds_cancelamento"],
                    "dtPrazo" => $ch["dt_prazo"],
                    //************************FormSistema****************************************
                    "idFormSistemas" => $s["id_form_sistemas"],
                    "idChamado" => $s["id_chamado"],
                    "nmPessoa" => $s["nm_pessoa"],
                    "dsEmail" => $s["ds_email"],
                    "nrTelefone" => $s["nr_telefone"],
                    "nrCartaoSus" => $s["nr_cartao_sus"],
                    "nrCpf" => $s["nr_cpf"],
                    "nrRg" => $s["nr_rg"],
                    "nrTelefoneSetor" => $s["nr_telefone_setor"],
                    "nrMatricula" => $s["nr_matricula"],
                    "nmModulo" => $s["nm_modulo"],
                    "nrPortaria" => $s["nr_portaria"],
                    "nmSetor" => $s["nm_setor"],
                    "cdSetor" => $s["cd_setor"],
                    "nmResponsavel" => $s["nm_responsavel"],
                    "nrParticipantes" => $s["nr_participantes"],
                    "dsSenhaDesejada" => $s["ds_senha_desejada"],
                    "nmExame" => $s["nm_exame"],
                    "dsExameParametro" => $s["ds_exame_parametro"],
                    "nmPermissao" => $s["nm_permissao"],
                    "nmConselho" => $s["nm_conselho"],
                    "nrConselho" => $s["nr_conselho"],
                    "dtInicial" => $s["dt_inicial"],
                    "dtFim" => $s["dt_fim"],
                    "dtNascimento" => $s["dt_nascimento"],
                    "idCargo" => $s["id_cargo"],
                    "idFuncao" => $s["id_funcao"],
                    "idLotacao" => $s["id_lotacao"],
                    "idVinculo" => $s["id_vinculo"]);
            }
            return json_encode($retorno);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTrChamado($idPessoaFisica) { //Listagem Chamado
        //print_r($idPessoaFisica);
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            /* @var $pdo PDO */
            $dao = new DaoChaChamado();
            $dao->setIdPessoaSolicitante($idPessoaFisica);
            $filtro = " ";
            //*******************************************************************************************************
            $result = $dao->retornaTodosChamados($pdo, $filtro);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idChamado = $v['id_chamado'];
                    $idFromSistema = $v['id_form_sistema'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['id_chamado'] . "</td>"
                            . "<td>" . $v['nm_solicitante'] . "</td>"
                            . "<td>" . $v['nm_lotacao'] . "</td>"
                            . "<td>" . $v['nm_categoria_tipo'] . "</td>"
                            . "<td>" . $v['nm_categoria_primaria'] . "</td>"
                            . "<td>" . $v['nm_categoria_secundaria'] . "</td>"
                            . "<td>" . $v['nm_atendimento'] . "</td>"
                            . "<td>" . $v['dh_abertura'] . "</td>"
                            . "<td>" . $v['dh_agendamento'] . "</td>"
                            . "<td>" . $v['nm_status'] . "</td>"
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"'
                            . ' title="Visualizar" nome="' . $v['nm_solicitante'] . '" '
                            . ' value=' . $idChamado . ' >
                                <i class="fa fa-mail-forward text-success" aria-hidden="true"></i>
                              </button> '
                            . '</td>'
                            . "</tr>";
                    $retorno .= "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaTrChamado1($idPessoaFisica, $idStatus) { //Listagem Chamado
        //print_r($idPessoaFisica);
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            /* @var $pdo PDO */
            $dao = new DaoChaChamado();
            $dao->setIdPessoaSolicitante($idPessoaFisica);
            $filtro = " ";
            //*******************************************************************************************************
            $filtro = " and s.id_status = '$idStatus' ";
            //******************************************************************************************************
            $result = $dao->retornaTodosChamados($pdo, $filtro);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idChamado = $v['id_chamado'];
                    $idFromSistema = $v['id_form_sistema'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['id_chamado'] . "</td>"
                            . "<td>" . $v['nm_solicitante'] . "</td>"
                            . "<td>" . $v['nm_lotacao'] . "</td>"
                            . "<td>" . $v['nm_categoria_tipo'] . "</td>"
                            . "<td>" . $v['nm_categoria_primaria'] . "</td>"
                            . "<td>" . $v['nm_categoria_secundaria'] . "</td>"
                            . "<td>" . $v['dh_abertura'] . "</td>"
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-visualiza btn-xs"'
                            . ' title="Visualizar" nome="' . $v['nm_solicitante'] . '" '
                            . ' value=' . $idChamado . ' >
                                <i class="fa fa-mail-forward text-success" aria-hidden="true"></i>
                              </button> '
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"'
                            . ' title="Editar" nome="' . $v['nm_solicitante'] . '" '
                            . ' value=' . $idChamado . ' >
                                <i class="fa fa-pencil-square-o text-primary" aria-hidden="true"></i>
                              </button> '
                            . '<button type="button" class="btn btn-default btn-cancelar btn-xs" title="Cancelar" value=' . $idChamado . "-" . $idFromSistema . ' >
                                <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                              </button>'
//                             . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idChamado . "-" . $idFromSistema . ' >
//                                <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
//                              </button>'
                            . '</td>'
                            . "</tr>";
                    $retorno .= "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaTrChamado2($idPessoaFisica, $idStatus) { //Listagem Chamado
        //print_r($idPessoaFisica);
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            /* @var $pdo PDO */
            $dao = new DaoChaChamado();
            $dao->setIdPessoaSolicitante($idPessoaFisica);
            $filtro = " ";
            //*******************************************************************************************************
            $filtro = " and s.id_status = '$idStatus' ";
            //******************************************************************************************************
            $result = $dao->retornaTodosChamados($pdo, $filtro);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idChamado = $v['id_chamado'];
                    $idFromSistema = $v['id_form_sistema'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['id_chamado'] . "</td>"
                            . "<td>" . $v['nm_solicitante'] . "</td>"
                            . "<td>" . $v['nm_lotacao'] . "</td>"
                            . "<td>" . $v['nm_categoria_tipo'] . "</td>"
                            . "<td>" . $v['nm_categoria_primaria'] . "</td>"
                            . "<td>" . $v['nm_categoria_secundaria'] . "</td>"
                            . "<td>" . $v['nm_atendimento'] . "</td>"
                            . "<td>" . $v['dh_abertura'] . "</td>"
                            . "<td>" . $v['dh_agendamento'] . "</td>"
                            . "<td>" . $v['nm_status'] . "</td>"
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"'
                            . ' title="Visualizar" nome="' . $v['nm_solicitante'] . '" '
                            . ' value=' . $idChamado . ' >
                                <i class="fa fa-mail-forward text-success" aria-hidden="true"></i>
                              </button> '
                            . '</td>'
                            . "</tr>";
                    $retorno .= "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
