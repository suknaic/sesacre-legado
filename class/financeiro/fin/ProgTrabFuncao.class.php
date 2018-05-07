<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinProgTrabFuncao.class.php";

class ProgTrabFuncao {

    //atributos de prog_trab_funcao
    private $codFuncao = null;
    private $idCodFuncao = null;
    //============================//
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    //============================//
    //getters e setters de prog_trab_funcao
    function getCodFuncao() {
        return $this->codFuncao;
    }

    function getIdCodFuncao() {
        return $this->idCodFuncao;
    }

    function setCodFuncao($codFuncao) {
        $this->codFuncao = $codFuncao;
    }

    function setIdCodFuncao($idCodFuncao) {
        $this->idCodFuncao = $idCodFuncao;
    }

    //=========================================//
    //cadastra Função
    public function cadastrarTrabFuncao() {
        try {
            //verifica se o campo está vazio
            if (empty($this->codFuncao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //verifica se o valor possui 2 caracteres
            if (strlen($this->codFuncao) != 2) {
                return Metodos::retornoAjax("Erro", "alert", STR_VALOR_INVALIDO . "(OBS: Permitido somente valor com 2 dígitos)");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoProgTrabFuncao();
            $dao->setCodFuncao($this->codFuncao);

            $dao->verificaTrabFuncao($pdo);
            if ($dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            } else {
                $dao->cadastraTrabFuncao($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                } else {
                    $dao->setIdCodFuncao($pdo->lastInsertId('fin_prog_trab_funcao_id_prog_trab_funcao_seq'));
                    if (Log::SalvaLogI('fin_prog_trab_funcao', $dao->getIdCodFuncao(), $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    //edita Função
    public function editarTrabFuncao() {
        try {
            if (empty($this->codFuncao && $this->idCodFuncao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            if (strlen($this->codFuncao) != 2) {
                return Metodos::retornoAjax("Erro", "alert", STR_VALOR_INVALIDO . "(OBS: Permitido somente valor com 2 dígitos)");
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoProgTrabFuncao();
            $dao->setCodFuncao($this->codFuncao);
            $dao->setIdCodFuncao($this->idCodFuncao);
            $dao->retornaTrabFuncao($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaTrabFuncao($pdo);
            if ($dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            } else {
                $dao->editaTrabFuncao($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                } else {
                    if (Log::SalvaLogU('fin_prog_trab_funcao', $this->getIdCodFuncao(), $busca, $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    //lista Função
    public function listarTrabFuncao() {
        try {
            if (empty($this->codFuncao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoProgTrabFuncao();
            $dao->setCodFuncao($this->codFuncao);
            if ($this->codFuncao != 'todas') {
                $dao->listaTrabFuncao($pdo);
            } else {
                $dao->listaTodasTrabFuncao($pdo);
            }
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            } else {
                $this->msgRetorno = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Funções</h3>
                        </div>
                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tabela_prog_trab_func" class="table table-striped table-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Função</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($dao->getMsgRetorno() as $linha) {
                    $this->msgRetorno .= '      
                                                <tr>
                                                    <td class="text-center">' . $linha["cd_prog_trab_funcao"] . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" funcao="' . $linha["cd_prog_trab_funcao"] . '"
                                                            value="' . $linha["id_prog_trab_funcao"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_prog_trab_funcao"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                }
                $this->msgRetorno .= '   </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                return Metodos::retornoAjax("ok", "html", $this->msgRetorno);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($ex));
        }
    }

    //remove Função
    public function removerTrabFuncao() {
        try {
            if (empty($this->idCodFuncao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $dao = new DaoProgTrabFuncao();
                $dao->setIdCodFuncao($this->idCodFuncao);
                $dao->setCodFuncao($this->codFuncao);
                $dao->retornaTrabFuncao($pdo);
                $busca = $dao->getMsgRetorno();

                $dao->verificaTrabFuncao($pdo);
                if (!$dao->Sucesso()) {
                    return Metodos::retornoAjax("Erro", "alert", "Registro não encontrado.");
                } else {
                    $dao->desativaTrabFuncao($pdo);
                    if (!$dao->Sucesso()) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    } else {
                        if (Log::SalvaLogU('fin_prog_trab_funcao', $this->getIdCodFuncao(), $busca, $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($ex));
        }
    }

}
