<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/anexo/DaoGcoAnexo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/anotacao/DaoGcoAnotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/processo/DaoProcesso.class.php";

/**
 * Description of Upload
 *
 * @author elivelton
 */
class Anexo {

    private $idProcesso = null;
    private $idAnexo = null;
    private $nomeAnexo = null;
    private $binAnexo = null;
    private $tipoAnexo = null;

    function getIdProcesso() {
        return $this->idProcesso;
    }

    function getIdAnexo() {
        return $this->idAnexo;
    }

    function getNomeAnexo() {
        return $this->nomeAnexo;
    }

    function getBinAnexo() {
        return $this->binAnexo;
    }

    function getTipoAnexo() {
        return $this->tipoAnexo;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    function setIdAnexo($idAnexo) {
        $this->idAnexo = $idAnexo;
    }

    function setNomeAnexo($nomeAnexo) {
        $this->nomeAnexo = $nomeAnexo;
    }

    function setBinAnexo($binAnexo) {
        $this->binAnexo = $binAnexo;
    }

    function setTipoAnexo($tipoAnexo) {
        $this->tipoAnexo = $tipoAnexo;
    }

    // ************************************ Salva Anexo de Um processo ****************************************
    public function inserirAnexo($link) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoAnexo = new DaoGcoAnexo();
            $daoAnexo->setIdProcesso($this->idProcesso);
            $daoAnexo->setNomeAnexo($this->nomeAnexo);
            $daoAnexo->setBinAnexo($this->binAnexo);
            $daoAnexo->setTipoAnexo($this->tipoAnexo);

            // ************* Verifica a existencia do processo *****************
            $processo = new DaoProcesso();
            $processo->setIdProcesso($this->idProcesso);
            $dados = $processo->acharProcessoUpload($pdo);
            // *****************************************************************
            if (empty($dados)) {
                return Metodos::retornoAjax('Erro', 'alert', 'Processo Não Encontrado.');
            } else {
                // *************** Cadastra um anexo **************
                $cadastraAnexo = $daoAnexo->cadastrarAnexo($pdo);
                // ************************************************
                
                //************** Insere na tabela gco_anotação o cadastro do anexo ****************
                if ($cadastraAnexo) {
                    // ******************** Salva Log do Anexo ********************
                    $daoAnexo->setIdAnexo($pdo->lastInsertId('gco_anexo_id_anexo_seq'));
                    if (!Log::SalvaLogIBinario('gco_anexo', $daoAnexo->getIdAnexo(), $pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                    // ************************************************************

                    $anotacao = new DaoGcoAnotacao();
                    $anotacao->setIdProcesso($this->idProcesso);
                    $anotacao->setSituacao($dados['id_situacao']);
                    $anotacao->setTecnico($dados['id_pessoa']);
                    $anotacao->setUser($_SESSION['idUser']);
                    $anotacao->setAnotacao("Anexo " . $this->nomeAnexo . " adicionado.");

                    $cadastraAnotacao = $anotacao->cadastrarAnotacao($pdo);
                    if ($cadastraAnotacao) {
                        // ********************** Salva log da anotação ***************************
                        $anotacao->setAnotacao($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                        if (Log::SalvaLogI('gco_anotacao', $anotacao->getAnotacao(), $pdo)) {
                            unlink($link);
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", "Anexo salvo com sucesso.");
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        }
                        // ***********************************************************************
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $cadastraAnotacao);
                    }
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax('Erro', 'console', $cadastraAnexo);
                }
                // ***********************************************************************************
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

// ****************************************************************************************************************
// ************************************* Carrega os anexos de um processo *****************************************
    public function carregarAnexos() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoGcoAnexo();
            $dao->setIdProcesso($this->idProcesso);

            $dados = $dao->retornarAnexosProcesso($pdo);
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
                                                        <div class="row">
                                                            <div class="col-sm-10">
                                                                <input class="form-control" name="anexo" readonly id="anexo_' . $cont . '" value="' . $linha['ds_anexo'] . '">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <button type="button" class="btn btn-primary btn-verAnexo" title="Ver" anexo="' . $linha['ds_anexo'] . '" id_anexo="' . $linha['id_anexo'] . '" id_processo="' . $linha['id_processo'] . '">
                                                                    <i class="ion-eye"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-ExluirAnexo" title="Remover" anexo="' . $linha['ds_anexo'] . '" id_anexo="' . $linha['id_anexo'] . '">
                                                                    <i class="ion-close-round"></i>
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

// ************************************************************************************************************
// ***************************************** Exclui um anexo de um processo ***********************************
    public function excluirAnexo() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoGcoAnexo();
            $dao->setIdAnexo($this->idAnexo);
            $dao->setIdProcesso($this->idProcesso);

            //********** Procurando o processo **********
            $processo = new DaoProcesso();
            $processo->setIdProcesso($this->idProcesso);
            $dados = $processo->acharProcessoUpload($pdo);
            //********************************************
            if (empty($dados)) {
                return Metodos::retornoAjax('Erro', 'alert', 'Processo Não Encontrado.');
            } else {
                // ******** Salva o log do anexo **********
                if (!Log::SalvaLogDBinario('gco_anexo', $dao->getIdAnexo(), $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                }
                //****************************************
                // ******* Deleta o anexo ********
                $deletaAnexo = $dao->excluirAnexo($pdo);
                //********************************
                //************ Insere na tabela gco_anotação a exclusão do anexo **************
                if ($deletaAnexo) {
                    $anotacao = new DaoGcoAnotacao();
                    $anotacao->setIdProcesso($this->idProcesso);
                    $anotacao->setSituacao($dados['id_situacao']);
                    $anotacao->setTecnico($dados['id_pessoa']);
                    $anotacao->setUser($_SESSION['idUser']);
                    $anotacao->setAnotacao("Anexo " . $this->nomeAnexo . " removido.");

                    $cadastraAnotacao = $anotacao->cadastrarAnotacao($pdo);
                    if ($cadastraAnotacao) {
                        $anotacao->setAnotacao($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                        if (Log::SalvaLogI('gco_anotacao', $anotacao->getAnotacao(), $pdo)) {
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
                    return Metodos::retornoAjax('Erro', 'console', $deletaAnexo);
                }
                //****************************************************************************
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

// ************************************************************************************************************
// ************************ Carrega um anexo de um processo *********************
    public function carregarAnexo() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoAnexo = new DaoGcoAnexo();
            $daoAnexo->setIdAnexo($this->idAnexo);
            $daoAnexo->setIdProcesso($this->idProcesso);

            $anexo = $daoAnexo->retornarAnexo($pdo);
            return $anexo;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

// *******************************************************************************
}
