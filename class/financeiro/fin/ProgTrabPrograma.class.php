<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinProgTrabPrograma.class.php";

class ProgTrabPrograma {

    //atributos de prog_trab_programa
    private $codPrograma = null;
    private $idCodPrograma = null;
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
    //getters e setters de prog_trab_programa
    function getCodPrograma() {
        return $this->codPrograma;
    }

    function getIdCodPrograma() {
        return $this->idCodPrograma;
    }

    function setCodPrograma($codPrograma) {
        $this->codPrograma = $codPrograma;
    }

    function setIdCodPrograma($idCodPrograma) {
        $this->idCodPrograma = $idCodPrograma;
    }

    //=========================================//
    //cadastra Trabalho Programa
    public function cadastrarTrabPrograma() {
        try {
            //verifica se o campo está vazio
            if (empty($this->codPrograma) == True) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //verifica se o valor possui 2 caracteres
            if (strlen($this->codPrograma) != 4) {
                return Metodos::retornoAjax("Erro", "alert", STR_VALOR_INVALIDO . "(OBS: Permitido somente valor com 4 dígitos)");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoProgTrabPrograma();
            $dao->setCodPrograma($this->codPrograma);

            $dao->verificaTrabPrograma($pdo);

            if ($dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            } else {
                $dao->cadastraTrabPrograma($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                } else {
                    $dao->setIdCodPrograma($pdo->lastInsertId('fin_prog_trab_programa_id_prog_trab_programa_seq'));
                    if (Log::SalvaLogI('fin_prog_trab_programa', $dao->getIdCodPrograma(), $pdo)) {
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

    //edita Trabalho Programa
    public function editarTrabPrograma() {
        try {
            if (empty($this->codPrograma && $this->idCodPrograma) == true) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            if (strlen($this->codPrograma) != 4) {
                return Metodos::retornoAjax("Erro", "alert", STR_VALOR_INVALIDO . "(OBS: Permitido somente valor com 4 dígitos)");
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoProgTrabPrograma();
            $dao->setCodPrograma($this->codPrograma);
            $dao->setIdCodPrograma($this->idCodPrograma);
            $dao->retornaTrabPrograma($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaTrabPrograma($pdo);
            if (!$dao->Sucesso()) {
                $dao->editaTrabPrograma($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                } else {
                    if (Log::SalvaLogU('fin_prog_trab_programa', $this->getIdCodPrograma(), $busca, $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                }
            } else {
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    //lista Trabalho Programa
    public function listarTrabPrograma() {
        try {
            if (empty($this->codPrograma) == true) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoProgTrabPrograma();
            $dao->setCodPrograma($this->codPrograma);
            if ($this->codPrograma != 'todas') {
                $dao->listaTrabPrograma($pdo);
            } else {
                $dao->listaTodasTrabPrograma($pdo);
            }
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            } else {
                $this->msgRetorno = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Programas</h3>
                        </div>
                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tabela_prog_trab_programa" class="table table-striped table-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Programa</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($dao->getMsgRetorno() as $linha) {
                    $this->msgRetorno .= '      
                                                <tr>
                                                    <td class="text-center">' . $linha["cd_prog_trab_programa"] . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" programa="' . $linha["cd_prog_trab_programa"] . '"
                                                            value="' . $linha["id_prog_trab_programa"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_prog_trab_programa"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                }
                $this->msgRetorno .= '  </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                return Metodos::retornoAjax("ok", "html", $this->msgRetorno);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    //desativa Trabalho Programa
    public function removerTrabPrograma() {
        try {
            if (empty($this->idCodPrograma) == True) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoProgTrabPrograma();
            $dao->setIdCodPrograma($this->idCodPrograma);
            $dao->setCodPrograma($this->codPrograma);
            $dao->retornaTrabPrograma($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaTrabPrograma($pdo);
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Registro não encontrado.");
            } else {
                $dao->desativaTrabPrograma($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                } else {
                    if (Log::SalvaLogU('fin_prog_trab_programa', $this->getIdCodPrograma(), $busca, $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
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

}
