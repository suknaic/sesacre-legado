<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaFormSistemas.class.php";

class FormSistemas {

    private $idFormSistemas = null;
    private $idChamado = null;
    private $nmPessoa = null;
    private $dsEmail = null;
    private $nrTelefone = null;
    private $nrCartaoSus = null;
    private $nrCpf = null;
    private $nrRg = null;
    private $nrTelefoneSetor = null;
    private $nrMatricula = null;
    private $nmModulo = null;
    private $nrPortaria = null;
    private $nmSetor = null;
    private $cdSetor = null;
    private $nmResponsavel = null;
    private $nrParticipantes = null;
    private $dsSenhaDesejada = null;
    private $nmExame = null;
    private $dsExameParametro = null;
    private $nmPermissao = null;
    private $nmConselho = null;
    private $nrConselho = null;
    private $dtInicial = null;
    private $dtFim = null;
    private $dtNascimento = null;
    private $idCargo = null;
    private $idFuncao = null;
    private $idLotacao = null;
    private $idVinculo = null;
    private $idPessoaSolicitante = null;
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
    function getIdFormSistemas() {
        return $this->idFormSistemas;
    }

    function getIdChamado() {
        return $this->idChamado;
    }

    function getNmPessoa() {
        return $this->nmPessoa;
    }

    function getDsEmail() {
        return $this->dsEmail;
    }

    function getNrTelefone() {
        return $this->nrTelefone;
    }

    function getNrCartaoSus() {
        return $this->nrCartaoSus;
    }

    function getNrCpf() {
        return $this->nrCpf;
    }

    function getNrRg() {
        return $this->nrRg;
    }

    function getNrTelefoneSetor() {
        return $this->nrTelefoneSetor;
    }

    function getNrMatricula() {
        return $this->nrMatricula;
    }

    function getNmModulo() {
        return $this->nmModulo;
    }

    function getNrPortaria() {
        return $this->nrPortaria;
    }

    function getNmSetor() {
        return $this->nmSetor;
    }

    function getCdSetor() {
        return $this->cdSetor;
    }

    function getNmResponsavel() {
        return $this->nmResponsavel;
    }

    function getNrParticipantes() {
        return $this->nrParticipantes;
    }

    function getDsSenhaDesejada() {
        return $this->dsSenhaDesejada;
    }

    function getNmExame() {
        return $this->nmExame;
    }

    function getDsExameParametro() {
        return $this->dsExameParametro;
    }

    function getNmPermissao() {
        return $this->nmPermissao;
    }

    function getNmConselho() {
        return $this->nmConselho;
    }

    function getNrConselho() {
        return $this->nrConselho;
    }

    function getDtInicial() {
        return $this->dtInicial;
    }

    function getDtFim() {
        return $this->dtFim;
    }

    function getDtNascimento() {
        return $this->dtNascimento;
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

    function getIdVinculo() {
        return $this->idVinculo;
    }

    function getIdPessoaSolicitante() {
        return $this->idPessoaSolicitante;
    }

    function setIdFormSistemas($idFormSistemas) {
        $this->idFormSistemas = $idFormSistemas;
    }

    function setIdChamado($idChamado) {
        $this->idChamado = $idChamado;
    }

    function setNmPessoa($nmPessoa) {
        $this->nmPessoa = $nmPessoa;
    }

    function setDsEmail($dsEmail) {
        $this->dsEmail = $dsEmail;
    }

    function setNrTelefone($nrTelefone) {
        $this->nrTelefone = $nrTelefone;
    }

    function setNrCartaoSus($nrCartaoSus) {
        $this->nrCartaoSus = $nrCartaoSus;
    }

    function setNrCpf($nrCpf) {
        $this->nrCpf = $nrCpf;
    }

    function setNrRg($nrRg) {
        $this->nrRg = $nrRg;
    }

    function setNrTelefoneSetor($nrTelefoneSetor) {
        $this->nrTelefoneSetor = $nrTelefoneSetor;
    }

    function setNrMatricula($nrMatricula) {
        $this->nrMatricula = $nrMatricula;
    }

    function setNmModulo($nmModulo) {
        $this->nmModulo = $nmModulo;
    }

    function setNrPortaria($nrPortaria) {
        $this->nrPortaria = $nrPortaria;
    }

    function setNmSetor($nmSetor) {
        $this->nmSetor = $nmSetor;
    }

    function setCdSetor($cdSetor) {
        $this->cdSetor = $cdSetor;
    }

    function setNmResponsavel($nmResponsavel) {
        $this->nmResponsavel = $nmResponsavel;
    }

    function setNrParticipantes($nrParticipantes) {
        $this->nrParticipantes = $nrParticipantes;
    }

    function setDsSenhaDesejada($dsSenhaDesejada) {
        $this->dsSenhaDesejada = $dsSenhaDesejada;
    }

    function setNmExame($nmExame) {
        $this->nmExame = $nmExame;
    }

    function setDsExameParametro($dsExameParametro) {
        $this->dsExameParametro = $dsExameParametro;
    }

    function setNmPermissao($nmPermissao) {
        $this->nmPermissao = $nmPermissao;
    }

    function setNmConselho($nmConselho) {
        $this->nmConselho = $nmConselho;
    }

    function setNrConselho($nrConselho) {
        $this->nrConselho = $nrConselho;
    }

    function setDtInicial($dtInicial) {
        $this->dtInicial = $dtInicial;
    }

    function setDtFim($dtFim) {
        $this->dtFim = $dtFim;
    }

    function setDtNascimento($dtNascimento) {
        $this->dtNascimento = $dtNascimento;
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

    function setIdVinculo($idVinculo) {
        $this->idVinculo = $idVinculo;
    }

    function setIdPessoaSolicitante($idPessoaSolicitante) {
        $this->idPessoaSolicitante = $idPessoaSolicitante;
    }

//*******************************************************************************
    public function cadastrarFormSistemas($pdo) {
        try {
            $sistemas = new DaoChaFormSistemas();
            $sistemas->setIdChamado(trim($this->idChamado));
            $sistemas->setNmPessoa(trim($this->nmPessoa));
            $sistemas->setDsEmail(trim($this->dsEmail));
            $sistemas->setNrTelefone(trim($this->nrTelefone));
            $sistemas->setNrCartaoSus(trim($this->nrCartaoSus));
            $sistemas->setNrCpf(trim($this->nrCpf));
            $sistemas->setNrRg(trim($this->nrRg));
            $sistemas->setNrTelefoneSetor(trim($this->nrTelefoneSetor));
            $sistemas->setNrMatricula(trim($this->nrMatricula));
            $sistemas->setNmModulo(trim($this->nmModulo));
            $sistemas->setNrPortaria(trim($this->nrPortaria));
            $sistemas->setNmSetor(trim($this->nmSetor));
            $sistemas->setCdSetor(trim($this->cdSetor));
            $sistemas->setNmResponsavel(trim($this->nmResponsavel));
            $sistemas->setNrParticipantes(trim($this->nrParticipantes));
            $sistemas->setDsSenhaDesejada(trim($this->dsSenhaDesejada));
            $sistemas->setNmExame(trim($this->nmExame));
            $sistemas->setDsExameParametro(trim($this->dsExameParametro));
            $sistemas->setNmPermissao(trim($this->nmPermissao));
            $sistemas->setNmConselho(trim($this->nmConselho));
            $sistemas->setNrConselho(trim($this->nrConselho));
            $sistemas->setDtInicial(trim($this->dtInicial));
            $sistemas->setDtFim(trim($this->dtFim));
            $sistemas->setDtNascimento(trim($this->dtNascimento));
            $sistemas->setIdCargo(trim($this->idCargo));
            $sistemas->setIdFuncao(trim($this->idFuncao));
            $sistemas->setIdLotacao(trim($this->idLotacao));
            $sistemas->setIdVinculo(trim($this->idVinculo));

            $rs = $sistemas->insert($pdo);


            if ($rs != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($rs);
                $pdo->rollBack();
                return;
            }
            $sistemas->setIdFormSistemas($pdo->lastInsertId('cha_form_sistema_id_form_sistema_seq'));

            if (Log::SalvaLogI('cha_form_sistema', $sistemas->getIdFormSistemas(), $pdo)) {
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
            $sistemas = new DaoChaFormSistemas();
            $sistemas->setNmPessoa(trim($this->nmPessoa));
            $sistemas->setDsEmail(trim($this->dsEmail));
            $sistemas->setNrTelefone(trim($this->nrTelefone));
            $sistemas->setNrCartaoSus(trim($this->nrCartaoSus));
            $sistemas->setNrCpf(trim($this->nrCpf));
            $sistemas->setNrRg(trim($this->nrRg));
            $sistemas->setNrTelefoneSetor(trim($this->nrTelefoneSetor));
            $sistemas->setNrMatricula(trim($this->nrMatricula));
            $sistemas->setNmModulo(trim($this->nmModulo));
            $sistemas->setNrPortaria(trim($this->nrPortaria));
            $sistemas->setNmSetor(trim($this->nmSetor));
            $sistemas->setCdSetor(trim($this->cdSetor));
            $sistemas->setNmResponsavel(trim($this->nmResponsavel));
            $sistemas->setNrParticipantes(trim($this->nrParticipantes));
            $sistemas->setDsSenhaDesejada(trim($this->dsSenhaDesejada));
            $sistemas->setNmExame(trim($this->nmExame));
            $sistemas->setDsExameParametro(trim($this->dsExameParametro));
            $sistemas->setNmPermissao(trim($this->nmPermissao));
            $sistemas->setNmConselho(trim($this->nmConselho));
            $sistemas->setNrConselho(trim($this->nrConselho));
            $sistemas->setDtInicial(trim($this->dtInicial));
            $sistemas->setDtFim(trim($this->dtFim));
            $sistemas->setDtNascimento(trim($this->dtNascimento));
            $sistemas->setIdCargo(trim($this->idCargo));
            $sistemas->setIdFuncao(trim($this->idFuncao));
            $sistemas->setIdLotacao(trim($this->idLotacao));
            $sistemas->setIdVinculo(trim($this->idVinculo));

            $rs = $sistemas->update($pdo);


            if ($rs != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($rs);
                $pdo->rollBack();
                return;
            }

            if (Log::SalvaLogU('cha_form_sistema', $sistemas->getIdFormSistemas(), $pdo)) {
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
//            $sistemas = new DaoChaFormSistemas();
//            $sistemas->setId_chamado($this->id_form_sistemas);
//            $sistemas->setNm_pessoa($this->nm_pessoa);
//            $sistemas->setDs_email($this->ds_email);
//            $sistemas->setNr_telefone($this->nr_telefone);
//            $sistemas->setNr_cartao_sus($this->nr_cartao_sus);
//            $sistemas->setNr_cpf($this->nr_cpf);
//            $sistemas->setNr_rg($this->nr_rg);
//            $sistemas->setNr_telefone_setor($this->nr_telefone_setor);
//            $sistemas->setNr_matricula($this->nr_matricula);
//            $sistemas->setNm_modulo($this->nm_modulo);
//            $sistemas->setNr_portaria($this->nr_portaria);
//            $sistemas->setNm_setor($this->nm_setor);
//            $sistemas->setCd_setor($this->cd_setor);
//            $sistemas->setNm_responsavel($this->nm_responsavel);
//            $sistemas->setNr_participantes($this->nr_participantes);
//            $sistemas->setDs_senha_desejada($this->ds_senha_desejada);
//            $sistemas->setNm_exame($this->nm_exame);
//            $sistemas->setDs_exame_paramentro($this->ds_exame_paramentro);
//            $sistemas->setNm_permissao($this->nm_permissao);
//            $sistemas->setNm_conselho($this->nm_conselho);
//            $sistemas->setNr_conselho($this->nr_conselho);
//            $sistemas->setDt_inicial($this->dt_inicial);
//            $sistemas->setDt_fim($this->dt_fim);
//            $sistemas->setDt_nascimento($this->dt_nascimento);
//            $sistemas->setId_cargo($this->id_cargo);
//            $sistemas->setId_funcao($this->id_funcao);
//            $sistemas->setId_lotacao($this->id_funcao);
//            $sistemas->setId_funcao($this->id_funcao);
//            //***********************************************************************
//            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &1 ");
//            $validaEmail = $sistemas->validarEmail($pdo, $this->ds_email);
//            if ($validaEmail) {
//                $this->setSuccess(false);
//                $this->setMsg(STR_EMAIL_EXISTE);
//                $pdo->rollBack();
//                return;
//            }
//            //print_r($pessoa);
//            //*****************************************
//            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &3 ");
//            $busca = $sistemas->retornaFormSistemas($pdo);
//            //print_r($busca);
//            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &4 ");
//            if (!$busca) {
//                $this->setSuccess(false);
//                $this->setMsg($busca);
//                $pdo->rollBack();
//                return;
//            }
//            //*****************************************
//            $result = $sistemas->update($pdo);
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
            $sistemas = new DaoChaFormSistemas();
            $sistemas->setIdFormSistemas($this->idFormSistemas);
            $s = $sistemas->retornaFormSistemas($pdo);
//            print_r($s);
            if ($s != FALSE) {
                if ($this->msg != "sistema") {
                    $retorno[] = array(
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
                        "idVinculo" => $s["id_vinculo"]
                    );
                    return json_encode($retorno);
                } else {
                    return $s;
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
            $sistemas = new DaoChaFormSistemas();
            $result = $sistemas->retornaTodosFormSistemas($pdo);
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
