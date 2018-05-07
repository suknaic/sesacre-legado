<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaFormInfraestrutura.class.php";

class FormInfraestrutura {

    private $idFormInfraestrutura = null;
    private $idChamado = null;
    private $tpLiberacao = null;
    private $nmPessoa = null;
    private $idCargo = null;
    private $idFuncao = null;
    private $idLotacao = null;
    private $nmEmail = null;
    private $dsAndar = null;
    private $qtPontos = null;
    private $qtCabos = null;
    private $nmApp = null;
    private $qtPatchCord = null;
    private $dsJustificativa = null;
    private $nrVlan = null;
    private $qtKeystone = null;
    private $qtRj45 = null;
    private $qtRack = null;
    private $nmPasta = null;
    private $dsDestino = null;
    private $qtComputador = null;
    private $qtImpressora = null;
    private $qtTelefone = null;
    private $dsIpGateway = null;
    private $idPessoaSolicitante = null;
    private $nrTelefone = null;
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
    function getIdFormInfraestrutura() {
        return $this->idFormInfraestrutura;
    }

    function getIdChamado() {
        return $this->idChamado;
    }

    function getTpLiberacao() {
        return $this->tpLiberacao;
    }

    function getNmPessoa() {
        return $this->nmPessoa;
    }

    function getIdCargo() {
        return $this->idCargo;
    }

    function getIdFuncao() {
        return $this->idFuncao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getNmEmail() {
        return $this->nmEmail;
    }

    function getDsAndar() {
        return $this->dsAndar;
    }

    function getQtPontos() {
        return $this->qtPontos;
    }

    function getQtCabos() {
        return $this->qtCabos;
    }

    function getNmApp() {
        return $this->nmApp;
    }

    function getQtPatchCord() {
        return $this->qtPatchCord;
    }

    function getDsJustificativa() {
        return $this->dsJustificativa;
    }

    function getNrVlan() {
        return $this->nrVlan;
    }

    function getQtKeystone() {
        return $this->qtKeystone;
    }

    function getQtRj45() {
        return $this->qtRj45;
    }

    function getQtRack() {
        return $this->qtRack;
    }

    function getNmPasta() {
        return $this->nmPasta;
    }

    function getDsDestino() {
        return $this->dsDestino;
    }

    function getQtComputador() {
        return $this->qtComputador;
    }

    function getQtImpressora() {
        return $this->qtImpressora;
    }

    function getQtTelefone() {
        return $this->qtTelefone;
    }

    function getDsIpGateway() {
        return $this->dsIpGateway;
    }

    function getIdPessoaSolicitante() {
        return $this->idPessoaSolicitante;
    }

    function getNrTelefone() {
        return $this->nrTelefone;
    }

    function setIdFormInfraestrutura($idFormInfraestrutura) {
        $this->idFormInfraestrutura = $idFormInfraestrutura;
    }

    function setIdChamado($idChamado) {
        $this->idChamado = $idChamado;
    }

    function setTpLiberacao($tpLiberacao) {
        $this->tpLiberacao = $tpLiberacao;
    }

    function setNmPessoa($nmPessoa) {
        $this->nmPessoa = $nmPessoa;
    }

    function setIdCargo($idCargo) {
        $this->idCargo = $idCargo;
    }

    function setIdFuncao($idFuncao) {
        $this->idFuncao = $idFuncao;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
    }

    function setNmEmail($nmEmail) {
        $this->nmEmail = $nmEmail;
    }

    function setDsAndar($dsAndar) {
        $this->dsAndar = $dsAndar;
    }

    function setQtPontos($qtPontos) {
        $this->qtPontos = $qtPontos;
    }

    function setQtCabos($qtCabos) {
        $this->qtCabos = $qtCabos;
    }

    function setNmApp($nmApp) {
        $this->nmApp = $nmApp;
    }

    function setQtPatchCord($qtPatchCord) {
        $this->qtPatchCord = $qtPatchCord;
    }

    function setDsJustificativa($dsJustificativa) {
        $this->dsJustificativa = $dsJustificativa;
    }

    function setNrVlan($nrVlan) {
        $this->nrVlan = $nrVlan;
    }

    function setQtKeystone($qtKeystone) {
        $this->qtKeystone = $qtKeystone;
    }

    function setQtRj45($qtRj45) {
        $this->qtRj45 = $qtRj45;
    }

    function setQtRack($qtRack) {
        $this->qtRack = $qtRack;
    }

    function setNmPasta($nmPasta) {
        $this->nmPasta = $nmPasta;
    }

    function setDsDestino($dsDestino) {
        $this->dsDestino = $dsDestino;
    }

    function setQtComputador($qtComputador) {
        $this->qtComputador = $qtComputador;
    }

    function setQtImpressora($qtImpressora) {
        $this->qtImpressora = $qtImpressora;
    }

    function setQtTelefone($qtTelefone) {
        $this->qtTelefone = $qtTelefone;
    }

    function setDsIpGateway($dsIpGateway) {
        $this->dsIpGateway = $dsIpGateway;
    }

    function setIdPessoaSolicitante($idPessoaSolicitante) {
        $this->idPessoaSolicitante = $idPessoaSolicitante;
    }

    function setNrTelefone($nrTelefone) {
        $this->nrTelefone = $nrTelefone;
    }

//*******************************************************************************
    public function cadastrarFormInfraestrutura($pdo) {
        try {
            $infraestrutura = new DaoChaFormInfraestrutura();
            $infraestrutura->setIdChamado(trim($this->idChamado));
            $infraestrutura->setTpLiberacao(trim($this->tpLiberacao));
            $infraestrutura->setNmPessoa(trim($this->nmPessoa));
            $infraestrutura->setIdCargo(trim($this->idCargo));
            $infraestrutura->setIdFuncao(trim($this->idFuncao));
            $infraestrutura->setIdLotacao(trim($this->idLotacao));
            $infraestrutura->setNmEmail(trim($this->nmEmail));
            $infraestrutura->setDsAndar(trim($this->dsAndar));
            $infraestrutura->setQtPontos(trim($this->qtPontos));
            $infraestrutura->setQtCabos(trim($this->qtCabos));
            $infraestrutura->setNmApp(trim($this->nmApp));
            $infraestrutura->setQtPatchCord(trim($this->qtPatchCord));
            $infraestrutura->setDsJustificativa(trim($this->dsJustificativa));
            $infraestrutura->setNrVlan(trim($this->nrVlan));
            $infraestrutura->setQtKeystone(trim($this->qtKeystone));
            $infraestrutura->setQtRj45(trim($this->qtRj45));
            $infraestrutura->setQtRack(trim($this->qtRack));
            $infraestrutura->setNmPasta(trim($this->nmPasta));
            $infraestrutura->setDsDestino(trim($this->dsDestino));
            $infraestrutura->setQtComputador(trim($this->qtComputador));
            $infraestrutura->setQtImpressora(trim($this->qtImpressora));
            $infraestrutura->setQtTelefone(trim($this->qtTelefone));
            $infraestrutura->setDsIpGateway(trim($this->dsIpGateway));
            $infraestrutura->setNrTelefone(trim($this->nrTelefone));
            $rs = $infraestrutura->insert($pdo);
            if ($rs != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($rs);
                $pdo->rollBack();
                return;
            }
            $infraestrutura->setIdFormInfraestrutura($pdo->lastInsertId('cha_form_infraestrutura_id_form_infraestrutura_seq'));

            if (Log::SalvaLogI('cha_form_infraestrutura', $infraestrutura->getIdFormInfraestrutura(), $pdo)) {
                $this->setSuccess(TRUE);
                return;
            } else {
                $this->setSuccess(false);
                $this->setMsg(STR_ERROR);
                $pdo->rollBack();
                return;
            }
        } catch (Exception $exc) {
            return;
        }
    }

    public function editarFormSistemas($pdo) {
        try {
            $infraestrutura = new DaoChaFormSistemas();
            $infraestrutura->setNmPessoa(trim($this->nmPessoa));
            $infraestrutura->setDsEmail(trim($this->dsEmail));
            $infraestrutura->setNrTelefone(trim($this->nrTelefone));
            $infraestrutura->setNrCartaoSus(trim($this->nrCartaoSus));
            $infraestrutura->setNrCpf(trim($this->nrCpf));
            $infraestrutura->setNrRg(trim($this->nrRg));
            $infraestrutura->setNrTelefoneSetor(trim($this->nrTelefoneSetor));
            $infraestrutura->setNrMatricula(trim($this->nrMatricula));
            $infraestrutura->setNmModulo(trim($this->nmModulo));
            $infraestrutura->setNrPortaria(trim($this->nrPortaria));
            $infraestrutura->setNmSetor(trim($this->nmSetor));
            $infraestrutura->setCdSetor(trim($this->cdSetor));
            $infraestrutura->setNmResponsavel(trim($this->nmResponsavel));
            $infraestrutura->setNrParticipantes(trim($this->nrParticipantes));
            $infraestrutura->setDsSenhaDesejada(trim($this->dsSenhaDesejada));
            $infraestrutura->setNmExame(trim($this->nmExame));
            $infraestrutura->setDsExameParametro(trim($this->dsExameParametro));
            $infraestrutura->setNmPermissao(trim($this->nmPermissao));
            $infraestrutura->setNmConselho(trim($this->nmConselho));
            $infraestrutura->setNrConselho(trim($this->nrConselho));
            $infraestrutura->setDtInicial(trim($this->dtInicial));
            $infraestrutura->setDtFim(trim($this->dtFim));
            $infraestrutura->setDtNascimento(trim($this->dtNascimento));
            $infraestrutura->setIdCargo(trim($this->idCargo));
            $infraestrutura->setIdFuncao(trim($this->idFuncao));
            $infraestrutura->setIdLotacao(trim($this->idLotacao));
            $infraestrutura->setIdVinculo(trim($this->idVinculo));

            $rs = $infraestrutura->update($pdo);


            if ($rs != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($rs);
                $pdo->rollBack();
                return;
            }

            if (Log::SalvaLogU('cha_form_sistema', $infraestrutura->getIdFormSistemas(), $pdo)) {
                $this->setSuccess(TRUE);
                return;
            } else {
                $this->setSuccess(false);
                $this->setMsg(STR_ERROR);
                $pdo->rollBack();
                return;
            }
        } catch (Exception $exc) {
            return;
        }
    }

//*******************************************************************************************************
//    public function editarFromSistemas($pdo) {
//        try {
//            $infraestrutura = new DaoChaFormSistemas();
//            $infraestrutura->setId_chamado($this->id_form_sistemas);
//            $infraestrutura->setNm_pessoa($this->nm_pessoa);
//            $infraestrutura->setDs_email($this->ds_email);
//            $infraestrutura->setNr_telefone($this->nr_telefone);
//            $infraestrutura->setNr_cartao_sus($this->nr_cartao_sus);
//            $infraestrutura->setNr_cpf($this->nr_cpf);
//            $infraestrutura->setNr_rg($this->nr_rg);
//            $infraestrutura->setNr_telefone_setor($this->nr_telefone_setor);
//            $infraestrutura->setNr_matricula($this->nr_matricula);
//            $infraestrutura->setNm_modulo($this->nm_modulo);
//            $infraestrutura->setNr_portaria($this->nr_portaria);
//            $infraestrutura->setNm_setor($this->nm_setor);
//            $infraestrutura->setCd_setor($this->cd_setor);
//            $infraestrutura->setNm_responsavel($this->nm_responsavel);
//            $infraestrutura->setNr_participantes($this->nr_participantes);
//            $infraestrutura->setDs_senha_desejada($this->ds_senha_desejada);
//            $infraestrutura->setNm_exame($this->nm_exame);
//            $infraestrutura->setDs_exame_paramentro($this->ds_exame_paramentro);
//            $infraestrutura->setNm_permissao($this->nm_permissao);
//            $infraestrutura->setNm_conselho($this->nm_conselho);
//            $infraestrutura->setNr_conselho($this->nr_conselho);
//            $infraestrutura->setDt_inicial($this->dt_inicial);
//            $infraestrutura->setDt_fim($this->dt_fim);
//            $infraestrutura->setDt_nascimento($this->dt_nascimento);
//            $infraestrutura->setId_cargo($this->id_cargo);
//            $infraestrutura->setId_funcao($this->id_funcao);
//            $infraestrutura->setId_lotacao($this->id_funcao);
//            $infraestrutura->setId_funcao($this->id_funcao);
//            //***********************************************************************
//            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &1 ");
//            $validaEmail = $infraestrutura->validarEmail($pdo, $this->ds_email);
//            if ($validaEmail) {
//                $this->setSuccess(false);
//                $this->setMsg(STR_EMAIL_EXISTE);
//                $pdo->rollBack();
//                return;
//            }
//            //print_r($pessoa);
//            //*****************************************
//            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &3 ");
//            $busca = $infraestrutura->retornaFormSistemas($pdo);
//            //print_r($busca);
//            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &4 ");
//            if (!$busca) {
//                $this->setSuccess(false);
//                $this->setMsg($busca);
//                $pdo->rollBack();
//                return;
//            }
//            //*****************************************
//            $result = $infraestrutura->update($pdo);
//            //*****************************************
//            if ($result != "Sucesso") {
//                $this->setSuccess(false);
//                $this->setMsg($result);
//                $pdo->rollBack();
//                return;
//            }
//            if (Log::SalvaLogU('cha_form_sistemas', $this->getId_form_sistemas(), $busca, $pdo)) {
//                $this->setSuccess(TRUE);
//                return;
//            } else {
//                $this->setSuccess(false);
//                $this->setMsg("ERRO de LOG em UPDATE de FORMULAŔIO SISTEMAS");
//                $pdo->rollBack();
//                return;
//            }
//        } catch (Exception $exc) {
//            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
//        }
//    }
//

    public function removerFormSistemas() {
        try {
            //***********************************************************************************
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $sistema = new DaoChaFormSistemas();
            $sistema->setIdFormSistemas($this->idFormSistemas);
//            print_r($sistema);
//           return;
            //************************************************************************************
            $buscaSistema = $sistema->retornaFormSistemas($pdo);
            if ($buscaSistema != FALSE) {
                if (!Log::SalvaLogD('cha_form_sistema', $sistema->getIdFormSistemas(), $pdo)) {
                    $pdo->rollBack();
                    return retornoAjax("Erro", "alert", "Erro ao Cadastrar Log de Formulário de Sistemas");
                }
            }
            //***************************************************************************************
            $rs = $sistema->delete($pdo);
            if ($rs != "Sucesso") {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $rs);
            }
            //***************Remover Chamado*********************************************************
            $chamado = new Chamado();
            $chamado->setIdChamado($this->idChamado);
            $rs1 = $chamado->removerChamado($pdo);

            if ($chamado->getSuccess()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", $chamado->getMsg());
            }

            return $retorno;
            //***********************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//    public function removerFormSistemas($pdo) {
//        try {
//
//            if ($this->idFormSistemas == "") {
//                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
//            }
//
//            $conexao = new Conexao();
//            $pdo = $conexao->connect();
//            $pdo->beginTransaction();
//            //Seta os Campos
//            $sistema = new DaoChaFormSistemas();
//            $sistema->setIdFormSistemas($this->getIdFormSistemas());
//
//            $busca = $sistema->delete($pdo);
//
//            if ($busca) {
//                if (!Log::SalvaLogD('cha_form_sistema', $sistema->getIdFormSistemas(), $pdo)) {
//                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
//                    $pdo->rollBack();
//                    return $retorno;
//                }
//            } else {
//                $retorno = retornoAjax("Erro", "alert", "Não Foi Possível Localizar o Formulário de Sistema.");
//                $pdo->rollBack();
//                return $retorno;
//            }
//
//            $resultDao = $sistema->delete($pdo);
//            if ($resultDao != "Sucesso") {
//                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
//                $pdo->rollBack();
//                return $retorno;
//            }
//
//            $sucesso = true;
//
//            if ($sucesso) {
//                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
//                $pdo->commit();
//                return $retorno;
//            } else {
//                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, Contate o Administrador do Sistema.");
//                $pdo->rollBack();
//                return $retorno;
//            }
//
//            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
//        } catch (Exception $exc) {
//            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
//        }
//    }
//    public function removerChamado() {
//        try {
//
//            if ($this->idChamado == "") {
//                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
//            }
//
//            $conexao = new Conexao();
//            /* @var $pdo PDO */
//            $pdo = $conexao->connect();
//            $pdo->beginTransaction();
//            //Seta os Campos
//            $dao = new DaoChaFormSistemas();
//            $dao->setIdChamado($this->idChamado);
//            $busca = $dao->retornaFormSistemas($pdo);
//            if ($busca) {
//                if (!Log::SalvaLogD('cha_chamado', $dao->getIdChamado(), $pdo)) {
//                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
//                    $pdo->rollBack();
//                    return $retorno;
//                }
//            } else {
//                $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Chamado.");
//                $pdo->rollBack();
//                return $retorno;
//            }
//
//            $resultDao = $dao->delete($pdo);
//            if ($resultDao != "Sucesso") {
//                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
//                $pdo->rollBack();
//                return $retorno;
//            }
//
//            $sucesso = true;
//
//            if ($sucesso) {
//                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
//                $pdo->commit();
//                return $retorno;
//            } else {
//                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
//                $pdo->rollBack();
//                return $retorno;
//            }
//
//            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
//        } catch (Exception $exc) {
//            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
//        }
//    }

    public function retornaFormSistemas($pdo) {
        try {
            $infraestrutura = new DaoChaFormSistemas();
            $infraestrutura->setId_form_sistemas($this->id_form_sistemas);
            $rs = $infraestrutura->retornaFormSistemas($pdo);
            if ($rs != FALSE) {
                if ($this->msg != "chamado") {
                    $retorno[] = array(
                        "idFormSistemas" => $rs["id_form_sistemas"],
                        "idChamado" => $rs["id_chamado"],
                        "nmPessoa" => $rs["nm_pessoa"],
                        "dsEmail" => $rs["ds_email"],
                        "nrTelefone" => $rs["nr_telefone"],
                        "nrCartaoSus" => $rs["nr_cartao_sus"],
                        "cpf" => $rs["nr_cpf"],
                        "rg" => $rs["nr_rg"],
                        "telefoneSetor" => $rs["nr_telefone_setor"],
                        "matricula" => $rs["nr_matricula"],
                        "modulo" => $rs["nm_modulo"],
                        "portaria" => $rs["nr_portaria"],
                        "nmSetor" => $rs["nm_setor"],
                        "cdSetor" => $rs["cd_setor"],
                        "responsavel" => $rs["nm_responsavel"],
                        "nrParticipantes" => $rs["nr_participantes"],
                        "senha" => $rs["ds_senha_desejada"],
                        "exame" => $rs["nm_exame"],
                        "parametroExame" => $rs["ds_exame_parametro"],
                        "permissao" => $rs["nm_permissao"],
                        "nmConselho" => $rs["nm_conselho"],
                        "nrConselho" => $rs["nr_conselho"],
                        "dtInicial" => $rs["dt_inicial"],
                        "dtFim" => $rs["dt_fim"],
                        "nascimento" => $rs["dt_nascimento"],
                        "idCargo" => $rs["id_cargo"],
                        "idFuncao" => $rs["id_funcao"],
                        "idLotacao" => $rs["id_lotacao"],
                        "idVinculo" => $rs["id_vinculo"]
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

    public function retornaOptionFromSistemas() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $infraestrutura = new DaoChaFormSistemas();
            $result = $infraestrutura->retornaTodosFormSistemas($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_form_sistemas'] . "'>" . $v['id_chamado'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
