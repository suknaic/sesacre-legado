<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/processo/DaoProcesso.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Metodos.class.php";

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
    private $situacao = null;
    private $modalidade = null;
    private $user = null;
    private $endereco = null;
    private $nomeAnexo = null;
    private $TabelaAnexo = null;
    private $idAnexo = null;
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

    /*
     * Cadastra um processo.
     */

    public function cadastraProcesso() {
        try {
            if (empty($this->ada && $this->unidade && $this->tecnico && $this->area && $this->situacao && $this->data && $this->tipoGasto && $this->centraisAtendimento && $this->anotacoes)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $cadPro = new DaoProcesso();

                $cadPro->setAda($this->ada);
                $cadPro->setValorEstimado($this->valorEstimado != "" ? Metodos::ConverteValorIng($this->valorEstimado) : "");
                $cadPro->setData(Metodos::ConverteDataING($this->data));
                $cadPro->setNumePregao($this->numePregao);
                $cadPro->setValorHomologado($this->valorHomologado != "" ? Metodos::ConverteValorIng($this->valorHomologado) : "");
                $cadPro->setTipoGasto($this->tipoGasto);
                $cadPro->setObjeto($this->objeto);
                $cadPro->setSituacao($this->situacao);
                $cadPro->setModalidade($this->modalidade);
                $cadPro->setUnidade($this->unidade);
                $cadPro->setCentraisAtendimento($this->centraisAtendimento);

                $busca = $cadPro->verificaProcesso($pdo);
                if ($busca["st_ativo"] == "1") {
                    return Metodos::retornoAjax("Erro", "alert", "Processo já existe no sistema!");
                } else {
                    $cadastradaProcesso = $cadPro->cadastraProcesso($pdo);
                    if (!$cadastradaProcesso) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $cadastradaProcesso);
                    } else {
                        $cadPro->setIdProcesso($pdo->lastInsertId('gco_processo_id_processo_seq'));
                        if (!Log::SalvaLogI('gco_processo', $cadPro->getIdProcesso(), $pdo)) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        } else {
                            $cadPro->setAnotacoes($this->anotacoes);
                            $cadPro->setSituacao($this->situacao);
                            $cadPro->setUser($this->user);
                            $cadPro->setTecnico($this->tecnico);
                            $cadastraAnotacao = $cadPro->cadastraAnotacao($pdo);

                            if (!$cadastraAnotacao) {
                                $pdo->rollBack();
                                return Metodos::retornoAjax("Erro", "console", $cadastraAnotacao);
                            } else {
                                $cadPro->setAnotacoes($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                                if (!Log::SalvaLogI('gco_anotacao', $cadPro->getAnotacoes(), $pdo)) {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                                }
                            }

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

                            if (count($this->tipoGasto) > 0) {
                                foreach ($this->tipoGasto as $tipoGasto) {
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
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    /*
     * Edita um processo.
     */

    public function editarProcesso() {
        try {
            if (empty($this->idProcesso && $this->ada && $this->data && $this->unidade && $this->tecnico && $this->area && $this->situacao && $this->tipoGasto && $this->centraisAtendimento)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $editPro = new DaoProcesso();
                $editPro->setIdProcesso($this->idProcesso);
                $editPro->setAda($this->ada);
                $editPro->setValorEstimado(Metodos::ConverteValorIng($this->valorEstimado));
                $editPro->setData(Metodos::validaConverteDataING($this->data));
                $editPro->setNumePregao($this->numePregao);
                $editPro->setValorHomologado(Metodos::ConverteValorIng($this->valorHomologado));
                $editPro->setObjeto($this->objeto);
                $editPro->setModalidade($this->modalidade);
                $dadosPro = $editPro->retornarProcessoLog($pdo);
                $dadosUni = $editPro->retornaProcessoUnidadeLog($pdo);
                $dadosArea = $editPro->retornarAreaLog($pdo);
                $dadosCentral = $editPro->retornarProcessoCentral($pdo);
                $dadosTipoGasto = $editPro->retornarProcessoTipoGasto($pdo);

                if ($this->ada != $this->adaTemp) {
                    $buscaProcessoAda = $editPro->verificaProcesso($pdo);
                    if ($buscaProcessoAda["st_ativo"] == "1") {
                        return Metodos::retornoAjax("Erro", "alert", "Processo Com Mesmo Ada Já Existe no Sistema.");
                    }
                }
                $editaProcesso = $editPro->editarProcesso($pdo);
                if (!$editaProcesso) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $editaProcesso);
                }

                if (Log::SalvaLogU('gco_processo', $this->getIdProcesso(), $dadosPro, $pdo)) {
                    if ($dadosArea == NULL) {
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
                    } else {
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
                        $delete = array_diff($areasInsert, $this->area);
                        if (count($delete) > 0) {
                            foreach ($delete as $area) {
                                $editPro->setArea($area);
                                $idArea = $editPro->retornaAreaDelete($pdo);
                                $detetaArea = $editPro->deletarAreaAbrangencia($pdo);
                                if ($detetaArea) {
                                    if (!Log::SalvaLogD('gco_area_abrangencia', $idArea['id_area_abrangencia'], $pdo)) {
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                                    }
                                } else {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax('Erro', 'console', $detetaArea);
                                }
                            }
                        }
                    }

                    if ($dadosUni == NULL) {
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
                    } else {
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
                    }

                    if ($dadosCentral == NULL) {
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
                    } else {
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
                                    return Metodos::retornoAjax('Erro', 'console', $detetaArea);
                                }
                            }
                        }
                    }

                    if ($dadosTipoGasto == NULL) {
                        if (count($this->tipoGasto) > 0) {
                            foreach ($this->tipoGasto as $tipoGasto) {
                                $editPro->setTipoGasto($tipoGasto['tpg']);
                                $cadastraTipoGasto = $editPro->cadastrarTipoGasto($pdo, $tipoGasto["valor"]);
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
                    } else {
//                        print_r($this->tipoGasto);
//                        $pdo->rollBack();
//                        return;
//                        foreach ($this->tipoGasto as $tipoGasto) {
//                            $editPro->setTipoGasto($tipoGasto['tpg']);
//                            $tipoGastoInsert = $editPro->retornarTipoDeGastoDoProcesso($pdo);
//                            if (!$tipoGastoInsert) {
//                                $cadastraTipoGasto = $editPro->cadastrarTipoGasto($pdo, Metodos::ConverteValorIng($tipoGasto["valor"]));
//                                if ($cadastraTipoGasto) {
//                                    $editPro->setTipoGasto($pdo->lastInsertId('gco_processo_tipo_gasto_id_processo_tipo_gasto_seq'));
//                                    if (!Log::SalvaLogI('gco_processo_tipo_gasto', $editPro->getTipoGasto(), $pdo)) {
//                                        $pdo->rollBack();
//                                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
//                                    }
//                                } else {
//                                    $pdo->rollBack();
//                                    return Metodos::retornoAjax('Erro', 'console', $cadastraTipoGasto);
//                                }
//                            }
//                        }
//                        $array = array();
//                        
//                        var_dump($this->tipoGasto);
//                        
//                        for($i = 0; $i < count($tipoGastoInsert); $i++ ){
//                            foreach ($this->tipoGasto as $t){
//                                if($t["tpg"] == $tipoGastoInsert[$i]){
//                                    $array [] = $t; 
//                                }
//                                
//                                
//                            }
//                        }
//                        var_dump($array);
//                        foreach ($this->tipoGasto as $dadosTipoGasto) {
//                            $insert = array_diff($this->tipoGasto, $array);
//                                var_dump($insert);
//                                var_dump($dadosTipoGasto);
//                                $pdo->rollBack();
//                                return;
//                        }
//                        return;
//                        print_r($this->tipoGasto);
//                        return;
                        
//                        
//                        foreach ($araydapalicavcao as $key => $value) {
//                            
//                            $araydapalicavcao[$key]['valor'] =  convertido($value['valor'])
//                        }
                        
                        $busca = $editPro->retornarTipoDeGastoDoProcesso($pdo);
                        print_r($busca);
                        return;
                        foreach ($this->tipoGasto as $linha) {
                            if ((int)$linha['id'] > 0) {
                                $update = array_diff_assoc($linha, $busca);
                                print_r($update);
                                $converte = Metodos::ConverteValorIng($update['valor']);
                                print_r($converte);
                                return;
                            }
                        }
//                        print_r($tipoGastoInsert);
//                        return;
                        $insert = array_diff($idTipogasto, $tipoGastoInsert);
//                        print_r($insert);
                        $pdo->rollBack();
                        return;
                    }



                    $editPro->setAnotacoes("Edição de dados");
                    $editPro->setSituacao($this->situacao);
                    $editPro->setTecnico($this->tecnico);
                    $editPro->setUser($this->user);

                    $insereAnotacao = $editPro->cadastraAnotacao($pdo);
                    if ($insereAnotacao) {
                        $editPro->setAnotacoes($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                        if (Log::SalvaLogI('gco_anotacao', $editPro->getAnotacoes(), $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $insereAnotacao);
                    }
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Desativa um processo.
     */

    public function desativarProcesso() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $remove = new DaoProcesso();

            $remove->setId_Processo($this->Id_Processo);
            $remove->setADA_process($this->ADA_process);
            $dadosPro = $remove->retornarProcessoLog($pdo);
            if ($dadosPro != FALSE) {
                $desativaProcesso = $remove->desativarProcesso($pdo);
                if (!$desativaProcesso) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $desativaProcesso);
                } else {
                    if (Log::SalvaLogU('gco_processo', $remove->getId_Processo(), $dadosPro, $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                }
            } else {
                return Metodos::retornoAjax("Erro", "alert", "Processo Não Existe.");
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Pesquisa um processo e possui um filtro de busca.
     */

    public function retornaProcesso($session) {
        try {
            $erro = false;
            if ($erro == false) {
                if (empty($this->ada) == true && empty($this->numePregao) == true && empty($this->ano) == true && empty($this->situacao) == true &&
                        empty($this->modalidade) == true && empty($this->centraisAtendimento) == true && empty($this->tecnico) == true && empty($this->tipoGasto) == true && empty($this->area) == true) {
                    return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
                }

                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $proDao = new DaoProcesso();
                $tabela = '';

                /*
                 * Filtro de busca.
                 */
                if ($this->ano != 'Todos') {
                    $condicao = array();
                    if (!empty($this->ada)) {
                        $condicao[] = "PRO.cd_ada_cpr ILIKE '%" . $this->ada . "%'";
                    }
                    if (!empty($this->numePregao)) {
                        $condicao[] = "PRO.cd_pregao ILIKE '%" . $this->numePregao . "%'";
                    }
                    if (!empty($this->centraisAtendimento)) {
                        $condicao[] = "PRO.nm_centrais ILIKE '%" . $this->centraisAtendimento . "%'";
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
                        $condicao[] = "TPG.id_tipo_gasto IN (" . $this->tipoGasto . ")";
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
                //-----------------------------------------------------------------------------//
                if ($this->getTabelaAnexo() == 'sim') {
                    $anexo = ", COALESCE(json_object_agg(ANE.id_anexo, ANE.ds_anexo) FILTER (WHERE ANE.id_anexo IS NOT NULL), '[]') AS ds_anexo,
                              COALESCE(json_object_agg(ANE.id_anexo, ANE.lk_anexo) FILTER (WHERE ANE.id_anexo IS NOT NULL), '[]') AS lk_anexo";
                    //chamando metodo para listar processo
                    $resultado = $proDao->listarProcesso($pdo, $filtro, $anexo);
                    if (is_array($resultado) == false) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $resultado);
                        $erro = true;
                        return $retorno;
                    }
                    if ($erro == false) {
                        foreach ($resultado as $linha) {
                            $tabela .= '    <tr>
                                                                    <td class="text-center">' . $linha["cd_ada_cpr"] . '</td>
                                                                    <td class="text-center">' . $linha["nm_tipo_gasto"] . '</td>
                                                                    <td class="text-center">' . $linha["nm_situacao"] . '</td>
                                                                    <td class="text-center">' . Metodos::ConverteDataBR($linha["dt_processo"]) . '</td>
                                                                    <td class="text-center">' . $linha["nm_modalidade"] . '</td>
                                                                    <td class="text-center">' . $linha["cd_pregao"] . '</td>
                                                                    <td class="text-center">' . $linha["nm_objeto"] . '</td>
                                                                    <td class="text-center">' . $linha["nm_centrais"] . '</td>
                                                                    <td class="text-center">' . $linha["nm_cidade"] . '</td>
                                                                    <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_total_est"], 2) . '</td>
                                                                    <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_total_hom"], 2) . '</td>
                                                                    <td class="text-center">';
                            foreach ((json_decode($linha["ds_anexo"], true)) as $key => $value) {
                                $tabela .= '          <a href="' . json_decode($linha["lk_anexo"], true)[$key] . '">' . $value . '</a></br>';
                            }
                            $tabela .= '                            </td>
                                                                    <td class="text-center">' . $linha["nm_pessoa"] . '</td>
                                                                    <td class="text-center">';
                            if (!$session->vPComprasTecAdmin()) {
                                $tabela .= '                            <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" disabled ada="' . $linha["cd_ada_cpr"] . '"
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default btn-imprimir btn-xs" title="Imprimir" ada="' . $linha["cd_ada_cpr"] . '"
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="fa fa-print fa-lg text-info" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default btn-anexar btn-xs" title="Anexar" disabled value="' . $linha["id_processo"] . '">
                                                                            <i class="fa fa-upload fa-lg text-warning" aria-hidden="true"></i>
                                                                        </button>';
                            } else {
                                $tabela .= '                            <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" ada="' . $linha["cd_ada_cpr"] . '"
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default btn-imprimir btn-xs" title="Imprimir" ada="' . $linha["cd_ada_cpr"] . '"
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="fa fa-print fa-lg text-info" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default btn-anexar btn-xs" title="Anexar" value="' . $linha["id_processo"] . '">
                                                                            <i class="fa fa-upload fa-lg text-warning" aria-hidden="true"></i>
                                                                        </button>';
                            }
                            if (!$session->vPComprasAdminTi()) {
                                $tabela .= '                            <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" disabled
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>';
                            } else {
                                $tabela .= '                            <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover"
                                                                            value="' . $linha["id_processo"] . '">
                                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                                         </button>
                                                                    </td>
                                                                </tr>';
                            }
                        }
                        return ($tabela);
                    }
                } else {
                    $anexo = "";
                    $resultado = $proDao->listarProcesso($pdo, $filtro, $anexo);
                    return $resultado;
                }
            }
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Carrega um processo.
     */

    public function carregarProcesso() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $processo = new DaoProcesso();
            $processo->setIdProcesso($this->idProcesso);

            $resultado = $processo->retornarProcesso($pdo);
            return $resultado;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function listaProcessoJSON() {
        try {

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $processo = new DaoProcesso();
            $anexo = "";

            $resultado = $processo->listarProcessoJSON($pdo, null, $anexo);
            return json_encode($resultado);
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    /*
     * Lista técnicos no select option.
     */

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

    public function upload() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $uploadDao = new DaoProcesso();
            $uploadDao->setId_Processo($this->Id_Processo);
            $uploadDao->setNomeAnexo($this->nomeAnexo);
            $uploadDao->setEndereço($this->endereco);

            $cadastraAnexo = $uploadDao->cadastrarAnexo($pdo);
            if ($cadastraAnexo) {
                $uploadDao->setIdAnexo($pdo->lastInsertId('gco_anexo_id_anexo_seq'));
                if (Log::SalvaLogI('gco_anexo', $uploadDao->getIdAnexo(), $pdo)) {
                    $dados = $uploadDao->acharProcessoUpload($pdo);
                    if ($dados != "") {
                        $uploadDao->setId_situacao($dados['id_situacao']);
                        $uploadDao->setTecnico($dados['id_pessoa']);
                        $uploadDao->setUser($_SESSION['idUser']);
                        $uploadDao->setAnotacoes_process("Anexo " . $this->nomeAnexo . " adicionado.");

                        $cadastraAnotacao = $uploadDao->cadastraAnotacao($pdo);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                    if ($cadastraAnotacao) {
                        $uploadDao->setId_anotacao($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                        if (Log::SalvaLogI('gco_anotacao', $uploadDao->getId_anotacao(), $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", "Anexo salvo com sucesso.");
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $cadastraAnotacao);
                    }
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $cadastraAnexo);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function processoPdf() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoProcesso = new DaoProcesso();
            $daoProcesso->setId_Processo($this->Id_Processo);

            $dados = $daoProcesso->carregarProcessoPdf($pdo);
            if ($dados != "") {
                return $dados;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function hitoricoProcessoPdf() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoProcesso = new DaoProcesso();
            $daoProcesso->setId_Processo($this->Id_Processo);
            $historico = $daoProcesso->historicoProcesso($pdo);
            return $historico;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function processosDesativados() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tabela = "";
            $daoProcesso = new DaoProcesso();
            $processos = $daoProcesso->listarProcessosDesativados($pdo);
            if (is_array($processos) == false) {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                return $retorno;
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
                                            <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" ada="' . $linha["cd_ada_cpr"] . '" value="' . $linha["cd_ada_cpr"] . '">
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

    public function ativarProcesso() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $ativa = new DaoProcesso();

            $ativa->setADA_process($this->ADA_process);
            $processo = $ativa->verificaProcesso($pdo);
            $ativa->setId_Processo($processo['id_processo']);
            $dadosPro = $ativa->retornarProcessoLog($pdo);

            if ($processo["st_ativo"] == "0") {
                $resultado = $ativa->ativarProcesso($pdo);
                if ($resultado != "Sucesso") {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $resultado);
                } else {
                    if (Log::SalvaLogU('gco_processo', $ativa->getId_Processo(), $dadosPro, $pdo)) {
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

    public function carregarAnexos() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoProcesso();
            $dao->setIdProcesso($this->idProcesso);

            $dados = $dao->anexos($pdo);
            if (count($dados) > 0) {
                $cont = 1;
                $anexos = '     <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Anexos</h3>
                                    </div>
                                    <div class="input_ordens">
                                        <div class="form-group">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-6">';
                foreach ($dados as $linha) {
                    $anexos .= '                 <div id="anexo_' . $cont . '">   
                                                    <div class="panel-body">Anexo ' . $cont . ':
                                                        <div class="input-group">
                                                            <input class="form-control" name="anexo" readonly id="anexo_' . $cont . '" value="' . $linha['ds_anexo'] . '">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-ExluirAnexo" anexo="' . $linha['ds_anexo'] . '" id_anexo="' . $linha['id_anexo'] . '">
                                                                    <i class="fa fa-remove fa-lg text-danger"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                    $cont++;
                }
                $anexos .= '                 </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-2 text-center">
                                            <button  type="button" class="btn btn-warning btn-block btn-rounded btn-anexar" title="Adicionar Anexo">
                                                <i class="fa fa-upload" aria-hidden="true"></i> Adicionar
                                            </button>
                                        </div>
                                        <div class="col-md-5"></div>
                                    </div> 
                                </div>';
                return $anexos;
            } else {
                $anexos = '     <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Anexos</h3>
                                    </div><br>
                                    <div class="input_ordens">
                                        <div class="form-group">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-2 text-center">
                                            <button  type="button" class="btn btn-warning btn-block btn-rounded btn-anexar" title="Adicionar Anexo">
                                                <i class="fa fa-upload" aria-hidden="true"></i> Adicionar
                                            </button>
                                        </div>
                                        <div class="col-md-5"></div>
                                    </div> 
                                    </div>
                                </div>';
                return $anexos;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function excluirAnexo() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoProcesso();
            $dao->setIdAnexo($this->idAnexo);
            $dao->setIdProcesso($this->idProcesso);

            if (Log::SalvaLogD('gco_anexo', $dao->getIdAnexo(), $pdo)) {
                $deletaAnexo = $dao->excluiAnexo($pdo);
                if ($deletaAnexo) {
                    $dados = $dao->acharProcessoUpload($pdo);
                    if ($dados != "") {
                        $dao->setSituacao($dados['id_situacao']);
                        $dao->setTecnico($dados['id_pessoa']);
                        $dao->setUser($_SESSION['idUser']);
                        $dao->setAnotacoes("Anexo " . $this->nomeAnexo . " removido.");

                        $cadastraAnotacao = $dao->cadastraAnotacao($pdo);
                        if ($cadastraAnotacao) {
                            $dao->setAnotacoes($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                            if (Log::SalvaLogI('gco_anotacao', $dao->getAnotacoes(), $pdo)) {
                                $link = $_SERVER["DOCUMENT_ROOT"] . '/files/gcon/' . md5($this->nomeAnexo);
                                if (unlink($link)) {
                                    $pdo->commit();
                                    return Metodos::retornoAjax("ok", "html", "Anexo Removido com Sucesso.");
                                } else {
                                    $pdo->rollBack();
                                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                                }
                            } else {
                                $pdo->rollBack();
                                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            }
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        }
                    }
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $deletaAnexo);
                }
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function retornarAnotacoes() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoProcesso();
            $dao->setIdProcesso($this->idProcesso);

            $dados = $dao->retornaAnotacoes($pdo);
            $retorno = '';
            if (count($dados != 0)) {
                foreach ($dados as $anotacoes) {
                    $retorno .= date('d/m/Y H:i:s', strtotime($anotacoes['dh_anotacao'])) . ' - ' . $anotacoes['nm_pessoa'] . ': ' . $anotacoes['ds_anotacao'] . "\n";
                }
                return $retorno;
            } else {
                return $retorno;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function adicionarAnotacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoProcesso();
            $pdo->beginTransaction();

            $dao->setIdProcesso($this->idProcesso);
            $dao->setAnotacoes($this->anotacoes);
            $busca = $dao->carregaAnotacao($pdo);
            $dao->setSituacao($busca['id_situacao']);
            $dao->setUser($_SESSION['idUser']);
            $dao->setTecnico($busca['id_pessoa']);

            $cadastraAnotacao = $dao->cadastraAnotacao($pdo);
            if (!$cadastraAnotacao) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $cadastraAnotacao);
            } else {
                $dao->setAnotacoes($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                if (Log::SalvaLogI('gco_anotacao', $dao->getAnotacoes(), $pdo)) {
                    $pdo->commit();
                    return Metodos::retornoAjax("ok", "html", 'Anotação Adicionada com Sucesso.');
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

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
                    $tipoGasto .= '<div class="tipoGastoCampos row" data-id="'.$linhas['id_processo_tipo_gasto'].'">
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
                                                <button class="fa fa-remove btn btn-danger btn-removerTipoGasto"></button>
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
                                                    <button class="fa fa-remove btn btn-danger btn-removerCentral"></button>
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

}
