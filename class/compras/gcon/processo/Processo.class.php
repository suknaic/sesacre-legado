<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/processo/DaoProcesso.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/anotacao/DaoGcoAnotacao.class.php";

/**
 * Description of Processo
 *
 * @author elivelton
 */
class Processo {

    private $idProcesso = null;
    private $ada = null;
    private $adaTemp = null;
    private $valorEstimado = null;
    private $unidade = null;
    private $data = null;
    private $numePregao = null;
    private $valorHomologado = null;
    private $anotacoes = null;
    private $ano = null;
    private $tecnico = null;
    private $tipoGasto = null;
    private $objeto = null;
    private $area = null;
    private $user = null;
    private $situacao = null;
    private $modalidade = null;
    private $TabelaAnexo = null;
    private $centraisAtendimento = null;

    function getIdProcesso() {
        return $this->idProcesso;
    }

    function getAda() {
        return $this->ada;
    }

    function getAdaTemp() {
        return $this->adaTemp;
    }

    function getValorEstimado() {
        return $this->valorEstimado;
    }

    function getUnidade() {
        return $this->unidade;
    }

    function getData() {
        return $this->data;
    }

    function getNumePregao() {
        return $this->numePregao;
    }

    function getValorHomologado() {
        return $this->valorHomologado;
    }

    function getAnotacoes() {
        return $this->anotacoes;
    }

    function getAno() {
        return $this->ano;
    }

    function getTecnico() {
        return $this->tecnico;
    }

    function getTipoGasto() {
        return $this->tipoGasto;
    }

    function getObjeto() {
        return $this->objeto;
    }

    function getArea() {
        return $this->area;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getModalidade() {
        return $this->modalidade;
    }

    function getUser() {
        return $this->user;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getNomeAnexo() {
        return $this->nomeAnexo;
    }

    function getTabelaAnexo() {
        return $this->TabelaAnexo;
    }

    function getIdAnexo() {
        return $this->idAnexo;
    }

    function getCentraisAtendimento() {
        return $this->centraisAtendimento;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    function setAda($ada) {
        $this->ada = $ada;
    }

    function setAdaTemp($adaTemp) {
        $this->adaTemp = $adaTemp;
    }

    function setValorEstimado($valorEstimado) {
        $this->valorEstimado = $valorEstimado;
    }

    function setUnidade($unidade) {
        $this->unidade = $unidade;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setNumePregao($numePregao) {
        $this->numePregao = $numePregao;
    }

    function setValorHomologado($valorHomologado) {
        $this->valorHomologado = $valorHomologado;
    }

    function setAnotacoes($anotacoes) {
        $this->anotacoes = $anotacoes;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function setTecnico($tecnico) {
        $this->tecnico = $tecnico;
    }

    function setTipoGasto($tipoGasto) {
        $this->tipoGasto = $tipoGasto;
    }

    function setObjeto($objeto) {
        $this->objeto = $objeto;
    }

    function setArea($area) {
        $this->area = $area;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setModalidade($modalidade) {
        $this->modalidade = $modalidade;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setNomeAnexo($nomeAnexo) {
        $this->nomeAnexo = $nomeAnexo;
    }

    function setTabelaAnexo($TabelaAnexo) {
        $this->TabelaAnexo = $TabelaAnexo;
    }

    function setIdAnexo($idAnexo) {
        $this->idAnexo = $idAnexo;
    }

    function setCentraisAtendimento($centraisAtendimento) {
        $this->centraisAtendimento = $centraisAtendimento;
    }

    //**************************************************************** Cadastra um processo ****************************************************************
    public function cadastraProcesso() {
        try {
            //************** Verifica se os campos necessários estão vazios  **************
            if (empty($this->ada && $this->unidade && $this->tecnico && $this->area && $this->situacao && $this->data && $this->tipoGasto && $this->centraisAtendimento && $this->anotacoes)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $cadPro = new DaoProcesso();

                $cadPro->setAda($this->ada);
                $cadPro->setValorEstimado($this->valorEstimado != "" ? Metodos::ConverteValorIng($this->valorEstimado) : 0);
                $cadPro->setData(Metodos::ConverteDataING($this->data));
                $cadPro->setNumePregao($this->numePregao);
                $cadPro->setValorHomologado($this->valorHomologado != "" ? Metodos::ConverteValorIng($this->valorHomologado) : 0);
                $cadPro->setTipoGasto($this->tipoGasto);
                $cadPro->setObjeto($this->objeto);
                $cadPro->setSituacao($this->situacao);
                $cadPro->setModalidade($this->modalidade);
                $cadPro->setUnidade($this->unidade);
                $cadPro->setCentraisAtendimento($this->centraisAtendimento);

                //******************* Verifica se existe um processo com mems ada ativo **********************
                $busca = $cadPro->verificaProcesso($pdo);
                if ($busca["st_ativo"] == "1") {
                    return Metodos::retornoAjax("Erro", "alert", "Processo já existe no sistema!");
                    //********************************************************************************************
                } else {
                    //********** Insere o processo e salvo o Log **********
                    $cadastradaProcesso = $cadPro->cadastraProcesso($pdo);
                    if (!$cadastradaProcesso) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $cadastradaProcesso);
                        //*******************************************************
                    } else {
                        $cadPro->setIdProcesso($pdo->lastInsertId('gco_processo_id_processo_seq'));
                        if (!Log::SalvaLogI('gco_processo', $cadPro->getIdProcesso(), $pdo)) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        } else {
                            //************************ Insere a anotacao do processo **********************
                            $anotacao = new DaoGcoAnotacao();
                            $anotacao->setIdProcesso($cadPro->getIdProcesso());
                            $anotacao->setAnotacao($this->anotacoes);
                            $anotacao->setSituacao($this->situacao);
                            $anotacao->setUser($this->user);
                            $anotacao->setTecnico($this->tecnico);
                            $cadastraAnotacao = $anotacao->cadastrarAnotacao($pdo);

                            if (!$cadastraAnotacao) {
                                $pdo->rollBack();
                                return Metodos::retornoAjax("Erro", "console", $cadastraAnotacao);
                            } else {
                                $anotacao->setAnotacao($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                                if (!Log::SalvaLogI('gco_anotacao', $anotacao->getAnotacao(), $pdo)) {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                                }
                            }
                            //*********************************************************************************

                            //***************************** Insere a(s) area(s) de abrangencia e faz o Log *****************************
                            if (count($this->area) > 0) {
                                foreach ($this->area as $area) {
                                    $cadPro->setArea($area);
                                    $cadastraArea = $cadPro->cadastrarAreaAbrangencia($pdo);
                                    if ($cadastraArea) {
                                        $cadPro->setArea($pdo->lastInsertId('gco_area_abrangencia_id_area_abrangencia_seq'));
                                        if (!Log::SalvaLogI('gco_area_abrangencia', $cadPro->getArea(), $pdo)) {
                                            $pdo->rollBack();
                                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                        }
                                    } else {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                }
                            }

                            $cadastraUnidade = $cadPro->cadastarProcessoUnidade($pdo);
                            if ($cadastraUnidade) {
                                $cadPro->setUnidade($pdo->lastInsertId('gco_processo_unidade_id_processo_unidade_seq'));
                                if (!Log::SalvaLogI('gco_processo_unidade', $cadPro->getUnidade(), $pdo)) {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                                }
                            } else {
                                $pdo->rollBack();
                                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            }
                            //*************************************************************************************************************

                            //******************************************* Insere as centrais  e faz Log ***********************************
                            if (count($this->centraisAtendimento) > 0) {
                                foreach ($this->centraisAtendimento as $centrais) {
                                    $cadPro->setCentraisAtendimento($centrais);
                                    $cadastraCentrais = $cadPro->cadastrarCentraisAtendimento($pdo);
                                    if ($cadastraCentrais) {
                                        $cadPro->setCentraisAtendimento($pdo->lastInsertId('gco_processo_central_id_processo_central_seq'));
                                        if (!Log::SalvaLogI('gco_processo_central', $cadPro->getCentraisAtendimento(), $pdo)) {
                                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                        }
                                    } else {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                }
                            }
                            //*************************************************************************************************************

                            //****** Insere os tipos de gasto do processo, verifica o total dos tipos de gasto e se é maior que o valor homologado, verifica se os valores dos tipo de gasto são vazios e faz o Log ******
                            if (count($this->tipoGasto) > 0) {
                                foreach ($this->tipoGasto as $tipoGasto) {
                                    if ($tipoGasto['valor'] == NULL) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                                    }

                                    $totalTipoGasto = 0;
                                    foreach ($this->tipoGasto as $tipoGastoValor) {
                                        $totalTipoGasto = $totalTipoGasto + Metodos::ConverteValorIng($tipoGastoValor['valor']);
                                    }

                                    if ($totalTipoGasto > Metodos::ConverteValorIng($this->valorHomologado)) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'alert', 'Valor Limite dos Tipos de Gastos Foi Ultrapassado.');
                                    }

                                    $cadPro->setTipoGasto($tipoGasto['tpg']);
                                    $cadastraTipoGasto = $cadPro->cadastrarTipoGasto($pdo, Metodos::ConverteValorIng($tipoGasto["valor"]));
                                    if ($cadastraTipoGasto) {
                                        $cadPro->setTipoGasto($pdo->lastInsertId('gco_processo_tipo_gasto_id_processo_tipo_gasto_seq'));
                                        if (!Log::SalvaLogI('gco_processo_tipo_gasto', $cadPro->getTipoGasto(), $pdo)) {
                                            $pdo->rollBack();
                                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                        }
                                    } else {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                }
                            }
                            $pdo->commit();
                            return Metodos::retornoAjax('ok', 'html', STR_CADASTRO_SUCESSO);
                            //**********************************************************************************************************************************************
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    //*************************************************************************************************************************************************************

    //******************************************************************* Edita um processo ***********************************************************************
    public function editarProcesso() {
        try {
            //*********** Verifica se os campos necessários estão vazios ***********
            if (empty($this->idProcesso && $this->ada && $this->data && $this->unidade && $this->tecnico && $this->area && $this->situacao && $this->tipoGasto && $this->centraisAtendimento)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $editPro = new DaoProcesso();
                $editPro->setIdProcesso($this->idProcesso);
                $editPro->setAda($this->ada);
                $editPro->setValorEstimado($this->valorEstimado != "" ? Metodos::ConverteValorIng($this->valorEstimado) : 0);
                $editPro->setData(Metodos::validaConverteDataING($this->data));
                $editPro->setNumePregao($this->numePregao);
                $editPro->setValorHomologado($this->valorHomologado != "" ? Metodos::ConverteValorIng($this->valorHomologado) : 0);
                $editPro->setObjeto($this->objeto);
                $editPro->setModalidade($this->modalidade);
                $dadosPro = $editPro->retornarProcessoLog($pdo);
                $dadosUni = $editPro->retornaProcessoUnidadeLog($pdo);
                $dadosArea = $editPro->retornarAreaLog($pdo);
                $dadosCentral = $editPro->retornarProcessoCentral($pdo);
                $dadosTipoGasto = $editPro->retornarProcessoTipoGasto($pdo);

                //********************* Verifica se já existe um processo ativo com o mesmo ada *****************
                if ($this->ada != $this->adaTemp) {
                    $buscaProcessoAda = $editPro->verificaProcesso($pdo);
                    if ($buscaProcessoAda["st_ativo"] == "1") {
                        return Metodos::retornoAjax("Erro", "alert", "Processo Com Mesmo Ada Já Existe no Sistema.");
                    }
                }
                //************************************************************************************************

                //*************************** Edita o processo ****************************
                $editaProcesso = $editPro->editarProcesso($pdo);
                if (!$editaProcesso) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $editaProcesso);
                }
                //*************************************************************************
                if (Log::SalvaLogU('gco_processo', $this->getIdProcesso(), $dadosPro, $pdo)) {
                    if ($dadosArea == NULL) {
                        //**************** Insere a ara de abrangencia quando o processo não possuir nenhema area ****************
                        if (count($this->area) > 0) {
                            foreach ($this->area as $area) {
                                $editPro->setArea($area);
                                $cadastraArea = $editPro->cadastrarAreaAbrangencia($pdo);
                                if ($cadastraArea) {
                                    $editPro->setArea($pdo->lastInsertId('gco_area_abrangencia_id_area_abrangencia_seq'));
                                    if (!Log::SalvaLogI('gco_area_abrangencia', $editPro->getArea(), $pdo)) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                } else {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'console', $cadastraArea);
                                }
                            }
                        }
                        //**********************************************************************************************************
                    } else {
                        //************************* Altera a area de abrangencia de um processo **************************
                        $areasInsert = $editPro->retornarAreaCidade($pdo);
                        $insert = array_diff($this->area, $areasInsert);
                        if (count($insert) > 0) {
                            foreach ($insert as $area) {
                                $editPro->setArea($area);
                                $cadastraArea = $editPro->cadastrarAreaAbrangencia($pdo);
                                if ($cadastraArea) {
                                    $editPro->setArea($pdo->lastInsertId('gco_area_abrangencia_id_area_abrangencia_seq'));
                                    if (!Log::SalvaLogI('gco_area_abrangencia', $editPro->getArea(), $pdo)) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                } else {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'console', $cadastraArea);
                                }
                            }
                        }
                        //************************************************************************************************

                        //************ Pega a diferença, que são os qu irão ser deletados, deleta e salva log ************
                        $delete = array_diff($areasInsert, $this->area);
                        if (count($delete) > 0) {
                            foreach ($delete as $area) {
                                $editPro->setArea($area);
                                $idArea = $editPro->retornaAreaDelete($pdo);
                                $deletaArea = $editPro->deletarAreaAbrangencia($pdo);
                                if ($deletaArea) {
                                    if (!Log::SalvaLogD('gco_area_abrangencia', $idArea['id_area_abrangencia'], $pdo)) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                } else {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'console', $deletaArea);
                                }
                            }
                        }
                        //*************************************************************************************************
                    }

                    if ($dadosUni == NULL) {
                        //************** Insere unidade no processo que não possui nenhuma unidade **************
                        $editPro->setUnidade($this->unidade);
                        $editaUnidade = $editPro->cadastarProcessoUnidade($pdo);
                        if ($editaUnidade) {
                            $editPro->setUnidade($pdo->lastInsertId('gco_processo_unidade_id_processo_unidade_seq'));
                            if (!Log::SalvaLogI('gco_processo_unidade', $editPro->getUnidade(), $pdo)) {
                                $pdo->rollBack();
                                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            }
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", $editaUnidade);
                        }
                        //**************************************************************************************
                    } else {
                        //************************* Altera a unidade de um processo ****************************
                        $editPro->setUnidade($this->unidade);
                        $editaUnidade = $editPro->editarUnidade($pdo);
                        if ($editaUnidade) {
                            $editPro->setUnidade($dadosUni['id_unidade_contempladas']);
                            if (!Log::SalvaLogU('gco_processo_unidade', $editPro->getUnidade(), $dadosUni, $pdo)) {
                                $pdo->rollBack();
                                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            }
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", $editaUnidade);
                        }
                        //**************************************************************************************
                    }

                    if ($dadosCentral == NULL) {
                        //** Insere as centrais caso o processo não tenha nehum cadastrado **
                        if (count($this->centraisAtendimento) > 0) {
                            foreach ($this->centraisAtendimento as $centrais) {
                                $editPro->setCentraisAtendimento($centrais);
                                $cadastraCentrais = $editPro->cadastrarCentraisAtendimento($pdo);
                                if ($cadastraCentrais) {
                                    $editPro->setCentraisAtendimento($pdo->lastInsertId('gco_processo_central_id_processo_central_seq'));
                                    if (!Log::SalvaLogI('gco_processo_central', $editPro->getCentraisAtendimento(), $pdo)) {
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                } else {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                }
                            }
                        }
                        //******************************************************************************
                    } else {
                        //******************* Verifica a direfença e edita as centrais *****************
                        $centraisInsert = $editPro->retornarCentraisDoProcesso($pdo);
                        $insert = array_diff($this->centraisAtendimento, $centraisInsert);
                        if (count($insert) > 0) {
                            foreach ($insert as $central) {
                                $editPro->setCentraisAtendimento($central);
                                $cadastraCentrais = $editPro->cadastrarCentraisAtendimento($pdo);
                                if ($cadastraCentrais) {
                                    $editPro->setCentraisAtendimento($pdo->lastInsertId('gco_processo_central_id_processo_central_seq'));
                                    if (!Log::SalvaLogI('gco_processo_central', $editPro->getCentraisAtendimento(), $pdo)) {
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                } else {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'console', $cadastraCentrais);
                                }
                            }
                        }
                        //**********************************************************************************

                        //********************* Verifica a diferença e remove as centrais ********************
                        $delete = array_diff($centraisInsert, $this->centraisAtendimento);
                        if (count($delete) > 0) {
                            foreach ($delete as $centrais) {
                                $editPro->setCentraisAtendimento($centrais);
                                $idCentral = $editPro->retornaCeltralDelete($pdo);
                                $detetaCentral = $editPro->deletarProcessoCentral($pdo);
                                if ($detetaCentral) {
                                    if (!Log::SalvaLogD('gco_processo_central', $idCentral['id_processo_central'], $pdo)) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                } else {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'console', $detetaCentral);
                                }
                            }
                        }
                        //************************************************************************************
                    }

                    if ($dadosTipoGasto == NULL) {
                        //** Insere os tipos de gastos no processo caso ele não tenha nenhum tipo de gasto,
                        //  Verifica se os valor dos tipos de gasto são vazios e 
                        //  Verifica se o valor total dos tipos de gastos é maior que o valor homologado **
                        if (count($this->tipoGasto) > 0) {
                            foreach ($this->tipoGasto as $tipoGasto) {
                                if ($tipoGasto['valor'] == NULL) {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                                }

                                $totalTipoGasto = 0;
                                foreach ($this->tipoGasto as $tipoGastoValor) {
                                    $totalTipoGasto = $totalTipoGasto + Metodos::ConverteValorIng($tipoGastoValor['valor']);
                                }

                                if ($totalTipoGasto > Metodos::ConverteValorIng($this->valorHomologado)) {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'alert', 'Valor Limite dos Tipos de Gastos Foi Ultrapassado.');
                                }

                                $editPro->setTipoGasto($tipoGasto['tpg']);
                                $cadastraTipoGasto = $editPro->cadastrarTipoGasto($pdo, Metodos::ConverteValorIng($tipoGasto["valor"]));
                                if ($cadastraTipoGasto) {
                                    $editPro->setTipoGasto($pdo->lastInsertId('gco_processo_tipo_gasto_id_processo_tipo_gasto_seq'));
                                    if (!Log::SalvaLogI('gco_processo_tipo_gasto', $editPro->getTipoGasto(), $pdo)) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                } else {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'console', $cadastraTipoGasto);
                                }
                            }
                        }
                        //***************************************************************************************
                    } else {
                        $busca = $editPro->retornarTipoDeGastoDoProcesso($pdo);

                        //** Total dos valores dos tipos de gastos e verifica se é maior que o valor homologado **
                        $totalTipoGasto = 0;
                        foreach ($this->tipoGasto as $tipoGastoValor) {
                            $totalTipoGasto = $totalTipoGasto + Metodos::ConverteValorIng($tipoGastoValor['valor']);
                        }

                        if ($totalTipoGasto > round(Metodos::ConverteValorIng($this->valorHomologado), 2)) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax('Erro', 'alert', 'Valor Limite dos Tipos de Gastos Foi Ultrapassado.');
                        }
                        //******************************************************************************************

                        foreach ($this->tipoGasto as $key => $tipoGastoApp) {
                            //** Verifica se os valores dos tipos de gasto é vazio, insere os tipos de gasto do processo direto caso ele não esteja cadastrado no processo **
                            if ($tipoGastoApp['valor'] == NULL) {
                                $pdo->rollBack();
                                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                            }

                            if ($tipoGastoApp['id'] == 0) {
                                $editPro->setTipoGasto($tipoGastoApp['tpg']);
                                $cadastraTipoGasto = $editPro->cadastrarTipoGasto($pdo, Metodos::ConverteValorIng($tipoGastoApp["valor"]));
                                if ($cadastraTipoGasto) {
                                    $editPro->setTipoGasto($pdo->lastInsertId('gco_processo_tipo_gasto_id_processo_tipo_gasto_seq'));
                                    if (!Log::SalvaLogI('gco_processo_tipo_gasto', $editPro->getTipoGasto(), $pdo)) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                } else {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'console', $cadastraTipoGasto);
                                }
                                //****************************************************************************
                            } else {
                                //** Verifica se os valores dos tipos de gasto estão vazios, 
                                //   verifia se o total dos tipos de gasto é maior que o valor homologado 
                                //   e remove o tipo de gasto do processo **
                                foreach ($busca as $tipoGastoBd) {
                                    if ($tipoGastoApp['valor'] == NULL) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                                    }

                                    $totalTipoGasto = 0;
                                    foreach ($this->tipoGasto as $tipoGastoValor) {
                                        $totalTipoGasto = $totalTipoGasto + Metodos::ConverteValorIng($tipoGastoValor['valor']);
                                    }

                                    if ($totalTipoGasto > Metodos::ConverteValorIng($this->valorHomologado)) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'alert', 'Valor Limite dos Tipos de Gastos Foi Ultrapassado.');
                                    }

                                    if ($tipoGastoApp['id'] == $tipoGastoBd['id_processo_tipo_gasto']) {
                                        $tipoGastoBd['vl_processo_tipo_gasto'] = Metodos::ConverteValorBr($tipoGastoBd['vl_processo_tipo_gasto'], 2);
                                        if (count(array_diff_assoc($tipoGastoBd, $tipoGastoApp)) > 0) {
                                            $editPro->setTipoGasto($tipoGastoApp['id']);
                                            $editaProcessoTipoGasto = $editPro->editarTipoGasto($pdo, $tipoGastoApp['tpg'], Metodos::ConverteValorIng($tipoGastoApp['valor']));
                                            if ($editaProcessoTipoGasto) {
                                                if (!Log::SalvaLogU('gco_processo_tipo_gasto', $tipoGastoApp['id'], $tipoGastoBd, $pdo)) {
                                                    $pdo->rollBack();
                                                    return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                                }
                                            } else {
                                                $pdo->rollBack();
                                                return Metodos::retornoAjax('Erro', 'console', $editaProcessoTipoGasto);
                                            }
                                        }
                                    }
                                    unset($busca[$key]);
                                }
                                //***********************************************************************************
                            }
                        }
                        //** O restante que sobra na variável, são so tipos de gasto a serem removidos **
                        foreach ($busca as $delete) {
                            $editPro->setTipoGasto($delete['id_processo_tipo_gasto']);
                            $deletar = $editPro->deletarTipoGasto($pdo);
                            if ($deletar) {
                                if (!Log::SalvaLogD('gco_processo_tipo_gasto', $delete['id_processo_tipo_gasto'], $pdo)) {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                }
                            } else {
                                $pdo->rollBack();
                                return Metodos::retornoAjax('Erro', 'console', $deletar);
                            }
                        }
                        //**********************************************************************************
                    }

                    //** Salva a anotação e finaliza a edição do processo **
                    $anotacao = new DaoGcoAnotacao();
                    $anotacao->setIdProcesso($this->idProcesso);
                    $anotacao->setAnotacao("Edição de dados");
                    $anotacao->setSituacao($this->situacao);
                    $anotacao->setTecnico($this->tecnico);
                    $anotacao->setUser($this->user);

                    $insereAnotacao = $anotacao->cadastrarAnotacao($pdo);
                    if ($insereAnotacao) {
                        $anotacao->setAnotacao($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                        if (Log::SalvaLogI('gco_anotacao', $anotacao->getAnotacao(), $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $insereAnotacao);
                    }
                    //**********************************************************
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    //****************************************************************************************************************************************

    //**************************************************************** Desativa um processo ***********************************************************
    public function desativarProcesso() {
        try {
            //*Verifica se os campos necessarios estão vazios, busca os dados antigos do processo, desativa o processo e salva o log *
            if (empty($this->idProcesso)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $remove = new DaoProcesso();

            $remove->setIdProcesso($this->idProcesso);
            $dadosPro = $remove->retornarProcessoLog($pdo);
            if ($dadosPro != FALSE) {
                if ($dadosPro['st_ativo'] === '1') {
                    $desativaProcesso = $remove->desativarProcesso($pdo);
                    if (!$desativaProcesso) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", $desativaProcesso);
                    } else {
                        if (Log::SalvaLogU('gco_processo', $remove->getIdProcesso(), $dadosPro, $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        }
                    }
                } else {
                    return Metodos::retornoAjax("Erro", "alert", "Processo Já Está Desativado.");
                }
            } else {
                return Metodos::retornoAjax("Erro", "alert", "Processo Não Existe.");
            }
            //*************************************************************************************************************************
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    //***********************************************************************************************************************************************

    //**************************************************************** Pesquisa um processo ************************************************************
    public function retornaProcesso($session) {
        try {
            $erro = false;
            if ($erro == false) {
                //******************************************** Verifica se os campos necessários estão vazios ***************************************
                if (empty($this->ada) == true && empty($this->numePregao) == true && empty($this->ano) == true && empty($this->situacao) == true &&
                        empty($this->modalidade) == true && empty($this->centraisAtendimento) == true && empty($this->tecnico) == true &&
                        empty($this->tipoGasto) == true && empty($this->area) == true) {
                    return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
                }
                //*************************************************************************************************************************************
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $proDao = new DaoProcesso();
                $tabela = '';

                //********************************************* Filtro de busca ********************************************
                if ($this->ano != 'Todos') {
                    $condicao = array();
                    if (!empty($this->ada)) {
                        $condicao[] = "PRO.cd_ada_cpr ILIKE '%" . $this->ada . "%'";
                    }
                    if (!empty($this->numePregao)) {
                        $condicao[] = "PRO.cd_pregao ILIKE '%" . $this->numePregao . "%'";
                    }
                    if (!empty($this->centraisAtendimento)) {
                        $condicao[] = is_array($this->centraisAtendimento) == TRUE ? "SL.id_lotacao IN (" . implode(',', $this->centraisAtendimento) . ")" : "SL.id_lotacao IN (" . $this->centraisAtendimento . ")";
                    }
                    if (!empty($this->ano)) {
                        $condicao[] = "EXTRACT('Year' FROM PRO.dt_processo) IN ('" . $this->ano . "')";
                    }
                    if (!empty($this->situacao)) {
                        $condicao[] = is_array($this->situacao) == TRUE ? "SIT.id_situacao IN (" . implode(',', $this->situacao) . ")" : "SIT.id_situacao IN (" . $this->situacao . ")";
                    }
                    if (!empty($this->modalidade)) {
                        $condicao[] = "MOD.id_modalidade IN (" . $this->modalidade . ")";
                    }
                    if (!empty($this->tecnico)) {
                        $condicao[] = "PES.id_pessoa IN (" . $this->tecnico . ")";
                    }
                    if (!empty($this->tipoGasto)) {
                        $condicao[] = is_array($this->tipoGasto) == TRUE ? "TG.id_tipo_gasto IN (" . implode(',', $this->tipoGasto) . ")" : "TG.id_tipo_gasto IN (" . $this->tipoGasto . ")";
                    }
                    if (!empty($this->area)) {
                        $condicao[] = "CID.id_cidade IN (" . $this->area . ")";
                    }

                    if (count($condicao) > 0) {
                        $filtro = "WHERE (PRO.st_ativo = '1') AND " . implode(' AND ', $condicao);
                    } else {
                        return FALSE;
                    }
                } else {
                    $filtro = "WHERE PRO.st_ativo = '1'";
                }
                //*************************************************************************************************************
                
                //************************ Verifica se a necessidade da tabela e lista os processos ***************************
                if ($this->TabelaAnexo == 'sim') {
                    $anexo = ", COALESCE(json_object_agg(ANE.id_anexo, ANE.ds_anexo) FILTER (WHERE ANE.id_anexo IS NOT NULL), '[]') AS ds_anexo,
                              COALESCE(json_object_agg(ANE.id_anexo, ANE.id_anexo) FILTER (WHERE ANE.id_anexo IS NOT NULL), '[]') AS id_anexo";
                    $resultado = $proDao->listarProcesso($pdo, $filtro, $anexo);
                    if (!is_array($resultado)) {
                        $erro = true;
                        return Metodos::retornoAjax("Erro", "console", $resultado);
                    }
                    if ($erro == false) {
                        foreach ($resultado as $linha) {
                            $tabela .= '    <tr>
                                                                    <td class="text-center">' . $linha["cd_ada_cpr"] . '</td>
                                                                    <td class="text-center">' . $linha["tipos_gastos"] . '</td>
                                                                    <td class="text-center">' . $linha["nm_situacao"] . '</td>
                                                                    <td class="text-center">' . Metodos::ConverteDataBR($linha["dt_processo"]) . '</td>
                                                                    <td class="text-center">' . $linha["nm_modalidade"] . '</td>
                                                                    <td class="text-center">' . $linha["cd_pregao"] . '</td>
                                                                    <td class="text-center">' . $linha["nm_objeto"] . '</td>
                                                                    <td class="text-center">' . $linha["centrais"] . '</td>
                                                                    <td class="text-center">' . $linha["nm_cidade"] . '</td>
                                                                    <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_total_est"], 2) . '</td>
                                                                    <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_total_hom"], 2) . '</td>
                                                                    <td class="text-center">';
                            foreach ((json_decode($linha["ds_anexo"], true)) as $key => $value) {
                                $tabela .= '          <a href="/pages/compras/gcon/upload/printUpload.php?idAnexo=' . json_decode($linha["id_anexo"], true)[$key] . '&idProcesso=' . $linha['id_processo'] . '"target="_blank">' . $value . '</a></br>';
                            }
                            $tabela .= '                            </td>
                                                                    <td class="text-center">' . $linha["nm_pessoa"] . '</td>
                                                                    <td class="text-center">';
                            if (!$session->vPComprasTecAdmin()) {
                                $tabela .= '                            <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" disabled ada="' . $linha["cd_ada_cpr"] . '"
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="ion-compose fa-lg text-primary" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default btn-imprimir btn-xs" title="Imprimir" ada="' . $linha["cd_ada_cpr"] . '"
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="ion-printer fa-lg text-info" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default btn-anexar btn-xs" title="Anexar" disabled value="' . $linha["id_processo"] . '">
                                                                            <i class="ion-upload fa-lg text-warning" aria-hidden="true"></i>
                                                                        </button>';
                            } else {
                                $tabela .= '                            <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" ada="' . $linha["cd_ada_cpr"] . '"
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="ion-compose fa-lg text-primary" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default btn-imprimir btn-xs" title="Imprimir" ada="' . $linha["cd_ada_cpr"] . '"
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="ion-printer fa-lg text-info" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default btn-anexar btn-xs" title="Anexar" value="' . $linha["id_processo"] . '">
                                                                            <i class="ion-upload fa-lg text-warning" aria-hidden="true"></i>
                                                                        </button>';
                            }
                            if (!$session->vPComprasAdminTi()) {
                                $tabela .= '                            <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" disabled
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="ion-trash-a fa-lg text-danger" aria-hidden="true"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>';
                            } else {
                                $tabela .= '                            <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover"
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="ion-trash-a fa-lg text-danger" aria-hidden="true"></i>
                                                                         </button>
                                                                    </td>
                                                                </tr>';
                            }
                        }
                        return ($tabela);
                    }
                    //**************************************************************************************************************************
                } else {
                    //*********** Lista os processos sem a tabela **********
                    $anexo = "";
                    return $proDao->listarProcesso($pdo, $filtro, $anexo);
                    //******************************************************
                }
            }
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    //***************************************************************************************************************************************************

    //********************** Carrega os dados de um processo *******************

    public function carregarProcesso() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $processo = new DaoProcesso();
            $processo->setIdProcesso($this->idProcesso);

            return $processo->retornarProcesso($pdo);
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //**************************************************************************

    //****************** Lista os processo os retorna em json ******************
    public function listaProcessoJSON() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $processo = new DaoProcesso();
            $anexo = "";

            $resultado = $processo->listarProcessoJSON($pdo, null, $anexo);
            if (!is_array($resultado)) {
                return json_encode([]);
            }
            return json_encode($resultado);
        } catch (Exception $ex) {
            return json_encode([]);
        }
    }
    //***************************************************************************

    //*********************************************** Lista técnicos no select option *******************************************
    public function retornarTodosTecnicosProcesso() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $tec = new DaoProcesso();
            $tec->setTecnico($this->id_tecnico);
            $tecnicos = '';
            $resultado = $tec->retornaTodosTecnicos($pdo);
            foreach ($resultado as $linha) {
                if ($this->getTecnico() == $linha['id_pessoa']) {
                    $tecnicos .= '<option value="' . $linha["id_pessoa"] . '" selected>' . $linha["nm_pessoa"] . '</option>';
                } else {
                    $tecnicos .= '<option value="' . $linha["id_pessoa"] . '">' . $linha["nm_pessoa"] . '</option>';
                }
            }
            return $tecnicos;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //**************************************************************************************************************************

    //************************************************ Lista os tecnicos dos processo ******************************************
    public function retornarTecnicosProcesso() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tec = new DaoProcesso();
            $tecnicos = '';
            $resultado = $tec->retornaTecnicosProcessos($pdo);
            foreach ($resultado as $linha) {
                $tecnicos .= '<option value="' . $linha["id_pessoa"] . '">' . $linha["nm_pessoa"] . '</option>';
            }
            return $tecnicos;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //**************************************************************************************************************************

    //************************************************ Lista as areas de abrangencia ******************************************
    public function retornarAreas() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $areaDao = new DaoProcesso();

            $idsArea = explode(',', $this->area);
            $areas = '';
            $resultado = $areaDao->retornaTodasAreas($pdo);
            foreach ($idsArea as $area) {
                foreach ($resultado as $linha) {
                    if ($area == $linha["id_cidade"]) {
                        $areas .= '<option value="' . $linha["id_cidade"] . '" selected>' . $linha["nm_regional_geo"] . ' - ' . $linha["nm_cidade"] . '</option>';
                    } else {
                        $areas .= '<option value="' . $linha["id_cidade"] . '">' . $linha["nm_regional_geo"] . ' - ' . $linha["nm_cidade"] . '</option>';
                    }
                }
            }
            return $areas;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //**************************************************************************************************************************

    //***************** Carrega os dados do processo para o pdf **************
    public function processoPdf() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoProcesso = new DaoProcesso();
            $daoProcesso->setIdProcesso($this->idProcesso);

            $dados = $daoProcesso->carregarProcessoPdf($pdo);
            if ($dados != FALSE) {
                return $dados;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //**************************************************************************

    //***************** Carrega o histórico do processo para o pdf *************
    public function hitoricoProcessoPdf() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoProcesso = new DaoProcesso();
            $daoProcesso->setIdProcesso($this->idProcesso);
            return $daoProcesso->historicoProcesso($pdo);
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    //************************************************************************

    //*********************************************** Carrega todos processo desativados ********************************************
    public function processosDesativados() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tabela = "";
            $daoProcesso = new DaoProcesso();
            $processos = $daoProcesso->listarProcessosDesativados($pdo);
            if (is_array($processos) == false) {
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            } else {
                foreach ($processos as $linha) {
                    $tabela .= '    <tr id="tabela_processo">
                                        <td class="text-center">' . $linha["cd_ada_cpr"] . '</td>
                                        <td class="text-center">' . $linha["nm_tipo_gasto"] . '</td>
                                        <td class="text-center">' . $linha["nm_situacao"] . '</td>
                                        <td class="text-center">' . Metodos::ConverteDataBR($linha["dt_processo"]) . '</td>
                                        <td class="text-center">' . $linha["nm_modalidade"] . '</td>
                                        <td class="text-center">' . $linha["cd_pregao"] . '</td>
                                        <td class="text-center">' . $linha["nm_objeto"] . '</td>
                                        <td class="text-center">' . $linha["nm_cidade"] . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_total_est"], 2) . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_total_hom"], 2) . '</td>
                                        <td class="text-center">';
                    foreach ((json_decode($linha["ds_anexo"], true)) as $key => $value) {
                        $tabela .= '          <a href="' . json_decode($linha["lk_anexo"], true)[$key] . '">' . $value . '</a></br>';
                    }
                    $tabela .= '        </td>
                                        <td class="text-center">' . $linha["nm_pessoa"] . '</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" ada="' . $linha["cd_ada_cpr"] . '" value="' . $linha["id_processo"] . '">
                                                <i class="glyphicon glyphicon-off glyphicon-sm text-primary" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>';
                }
                return $tabela;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //*********************************************************************************************************************************

    //********************************************** Ativa um processo desativado ******************************************
    public function ativarProcesso() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $ativa = new DaoProcesso();

            $ativa->setAda($this->ada);
            $processo = $ativa->verificaProcesso($pdo);
            $ativa->setIdProcesso($this->idProcesso);
            $dadosPro = $ativa->retornarProcessoLog($pdo);

            if ($processo["st_ativo"] == "0") {
                $ativar = $ativa->ativarProcesso($pdo);
                if (!$ativar) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $ativar);
                } else {
                    if (Log::SalvaLogU('gco_processo', $this->idProcesso, $dadosPro, $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", "Registro Ativado com Sucesso.");
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                }
            } else {
                return Metodos::retornoAjax("Erro", "alert", "Processo não existe.");
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    //**********************************************************************************************************************

    //* *************************************************** Carrega os tipos de gasto de um processo *************************************************
    public function carregarTipoGastoProcesso() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoProcesso = new DaoProcesso();
            $daoProcesso->setIdProcesso($this->idProcesso);
            $tipoGasto = '';
            $busca = $daoProcesso->retornaTiposGastoProcesso($pdo);
            if (is_array($busca)) {
                foreach ($busca as $linhas) {
                    $tipoGasto .= '<div class="tipoGastoCampos row" data-id="' . $linhas['id_processo_tipo_gasto'] . '">
                                        <div class="col-md-4 ">
                                            <div class="panel-body">Tipo de Gasto: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                                <select class="form-control tipoGastoSelect" name="tipoGasto">
                                                     <option value="' . $linhas['id_tipo_gasto'] . '" selected>' . $linhas['nm_tipo_gasto'] . '</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="panel-body">Valor do Tipo de Gasto: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                                <input class="form-control valorTipoGasto" type="text" name="val_tipo_gasto" value="' . Metodos::ConverteValorBr($linhas['vl_processo_tipo_gasto'], 2) . '"  id="val_tipo_gasto" placeholder="1.000.000,00">
                                            </div>
                                        </div><br>
                                        <div class="col-md-3">
                                            <div class="panel-body">
                                                <button class="ion-close-round btn btn-danger btn-removerTipoGasto"></button>
                                            </div>
                                        </div>
                                    </div>';
                }
            }
            return $tipoGasto;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //*************************************************************************************************************************************************

    //********************************************************* Carrega as centrais de um processo *******************************************************
    public function carregarCentraisProcesso() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoProcesso = new DaoProcesso();
            $daoProcesso->setIdProcesso($this->idProcesso);
            $centrais = '';
            $busca = $daoProcesso->retornaCentraisProcesso($pdo);
            if (is_array($busca)) {
                foreach ($busca as $linhas) {
                    $centrais .= '  <div id="centrais">
                                        <div class="centrais row">
                                            <div class="col-md-4">
                                                <div class="panel-body">Centrais de Atendimento: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                                    <div class="centraisCampos">
                                                        <select class="form-control selectCentrais" name="centraisAtendimento" required id="centraisAtendimento">
                                                            <option value="' . $linhas['id_lotacao'] . '" selected="">' . $linhas['nm_lotacao'] . '</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div><br>
                                            <div class="col-md-3">
                                                <div class="panel-body">
                                                    <button class="ion-close-round btn btn-danger btn-removerCentral"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                }
            }
            return $centrais;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //*************************************************************************************************************************************************
}
