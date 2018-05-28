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
    private $endereco = null;

    function getIdProcesso() {
        return $this->idProcesso;
    }

    function getNomeAnexo() {
        return $this->nomeAnexo;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getIdAnexo() {
        return $this->idAnexo;
    }

    function setIdAnexo($idAnexo) {
        $this->idAnexo = $idAnexo;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    function setNomeAnexo($nomeAnexo) {
        $this->nomeAnexo = $nomeAnexo;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function inserirAnexo() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoAnexo = new DaoGcoAnexo();
            $daoAnexo->setIdProcesso($this->idProcesso);
            $daoAnexo->setEndereco($this->endereco);
            $daoAnexo->setNomeAnexo($this->nomeAnexo);

            $cadastraAnexo = $daoAnexo->cadastrarAnexo($pdo);

            if ($cadastraAnexo) {
                $daoAnexo->setIdAnexo($pdo->lastInsertId('gco_anexo_id_anexo_seq'));
                if (Log::SalvaLogI('gco_anexo', $daoAnexo->getIdAnexo(), $pdo)) {
                    $processo = new DaoProcesso();
                    $processo->setIdProcesso($this->idProcesso);
                    $dados = $processo->acharProcessoUpload($pdo);

                    if ($dados != FALSE) {
                        $anotacao = new DaoGcoAnotacao();
                        $anotacao->setIdProcesso($this->idProcesso);
                        $anotacao->setSituacao($dados['id_situacao']);
                        $anotacao->setTecnico($dados['id_pessoa']);
                        $anotacao->setUser($_SESSION['idUser']);
                        $anotacao->setAnotacao("Anexo " . $this->nomeAnexo . " adicionado.");

                        $cadastraAnotacao = $anotacao->cadastrarAnotacao($pdo);
                        if ($cadastraAnotacao) {
                            $anotacao->setAnotacao($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                            if (Log::SalvaLogI('gco_anotacao', $anotacao->getAnotacao(), $pdo)) {
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

            $dao = new DaoGcoAnexo();
            $dao->setIdAnexo($this->idAnexo);
            $dao->setIdProcesso($this->idProcesso);
            $extencao = substr($this->nomeAnexo, -5);

            if (Log::SalvaLogD('gco_anexo', $dao->getIdAnexo(), $pdo)) {
                $deletaAnexo = $dao->excluirAnexo($pdo);
                if ($deletaAnexo) {
                    $processo = new DaoProcesso();
                    $processo->setIdProcesso($this->idProcesso);
                    $dados = $processo->acharProcessoUpload($pdo);
                    if ($dados != FALSE) {
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
                                $link = $_SERVER["DOCUMENT_ROOT"] . '/files/gcon/' . $this->idProcesso . '/' . md5($this->nomeAnexo) . $extencao;

                                if (file_exists($link)) {
                                    $removeArquivo = unlink($link);
                                } else {
                                    $removeArquivo = TRUE;
                                }
                                
                                if ($removeArquivo) {
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

    public function verificaAnexo() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoAnexo = new DaoGcoAnexo();
            $daoAnexo->setIdProcesso($this->idProcesso);
            $daoAnexo->setEndereco($this->endereco);

            $verifica = $daoAnexo->retornarAnexo($pdo);
            var_dump($verifica);
            return;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

}
