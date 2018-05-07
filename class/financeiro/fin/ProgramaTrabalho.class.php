<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinProgramaTrabalho.class.php";

class ProgramaTrabalho {

    private $idProgramaTrabalho = null;
    private $dsProgramaTrabalho = null;
    private $cdProgramaTrabalho = null;
    private $aaProgramaTrabalho = null;
    private $idProgtrabFuncao = null;
    private $idProgTrabSubFuncao = null;
    private $idProgTrabPrograma = null;
//=============================================================================
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

//============================================================================//    
    function getIdProgramaTrabalho() {
        return $this->idProgramaTrabalho;
    }

    function getDsProgramaTrabalho() {
        return $this->dsProgramaTrabalho;
    }

    function getAaProgramaTrabalho() {
        return $this->aaProgramaTrabalho;
    }

    function getIdProgtrabFuncao() {
        return $this->idProgtrabFuncao;
    }

    function getIdProgTrabSubFuncao() {
        return $this->idProgTrabSubFuncao;
    }

    function getIdProgTrabPrograma() {
        return $this->idProgTrabPrograma;
    }

    function getCdProgramaTrabalho() {
        return $this->cdProgramaTrabalho;
    }

    function setCdProgramaTrabalho($cdProgramaTrabalho) {
        $this->cdProgramaTrabalho = $cdProgramaTrabalho;
    }

    function setIdProgtrabFuncao($idProgtrabFuncao) {
        $this->idProgtrabFuncao = $idProgtrabFuncao;
    }

    function setIdProgTrabSubFuncao($idProgTrabSubFuncao) {
        $this->idProgTrabSubFuncao = $idProgTrabSubFuncao;
    }

    function setIdProgTrabPrograma($idProgTrabPrograma) {
        $this->idProgTrabPrograma = $idProgTrabPrograma;
    }

    function setIdProgramaTrabalho($idProgramaTrabalho) {
        $this->idProgramaTrabalho = $idProgramaTrabalho;
        return $this;
    }

    function setDsProgramaTrabalho($dsProgramaTrabalho) {
        $this->dsProgramaTrabalho = $dsProgramaTrabalho;
        return $this;
    }

    function setAaProgramaTrabalho($aaProgramaTrabalho) {
        $this->aaProgramaTrabalho = $aaProgramaTrabalho;
        return $this;
    }

//============================================================================//
    public function cadastrarProgramaTrabalho() {
        try {
            if (empty($this->cdProgramaTrabalho && $this->dsProgramaTrabalho && $this->aaProgramaTrabalho &&
                            $this->idProgtrabFuncao && $this->idProgTrabSubFuncao && $this->idProgTrabPrograma) == TRUE) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $dao = new DaoFinProgramaTrabalho();
            $dao->setCdProgramaTrabalho($this->cdProgramaTrabalho);
            $dao->setDsProgramaTrabalho($this->dsProgramaTrabalho);
            $dao->setAaProgramaTrabalho($this->aaProgramaTrabalho);
            $dao->setIdProgTrabFuncao($this->idProgtrabFuncao);
            $dao->setIdProgTrabSubfuncao($this->idProgTrabSubFuncao);
            $dao->setIdProgTrabPrograma($this->idProgTrabPrograma);

            $dao->verificaProgramaTrabalho($pdo);

            if ($dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            } else {
                $dao->cadastrarProgramaTrabalho($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                } else {
                    $dao->setIdProgramaTrabalho($pdo->lastInsertId('fin_programa_trabalho_id_programa_trabalho_seq'));
                    if (Log::SalvaLogI('fin_programa_trabalho', $dao->getIdProgramaTrabalho(), $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                }
            }
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function listarProgramaTrabalho() {
        try {
            if (empty($this->cdProgramaTrabalho || $this->dsProgramaTrabalho || $this->aaProgramaTrabalho) == TRUE) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoFinProgramaTrabalho();
            $dao->setCdProgramaTrabalho($this->cdProgramaTrabalho);

            if (empty($this->cdProgramaTrabalho) == FALSE) {
                $codigo = "progTrab.cd_programa_trabalho='" . $this->cdProgramaTrabalho . "'";
            } elseif (empty($this->dsProgramaTrabalho) == FALSE) {
                $codigo = "progTrab.ds_programa_trabalho ILIKE '" . $this->dsProgramaTrabalho . "%'";
            } elseif (empty($this->aaProgramaTrabalho) == FALSE) {
                $codigo = "progTrab.aa_programa_trabalho='" . $this->aaProgramaTrabalho . "'";
            }

            $dao->listarProgramaTrabalho($pdo, $codigo);
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            } else {
                $this->msgRetorno = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Programas de Trabalho</h3>
                        </div>
                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tabela_prog_trab" class="table table-striped table-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Codigo</th>
                                                    <th class="text-capitalize text-center">Descrição</th>
                                                    <th class="text-capitalize text-center">Ano</th>
                                                    <th class="text-capitalize text-center">Função</th>
                                                    <th class="text-capitalize text-center">Subfunção</th>
                                                    <th class="text-capitalize text-center">Programa</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($dao->getMsgRetorno() as $linha) {
                    $this->msgRetorno .= '      
                                                <tr>
                                                    <td class="text-center">' . $linha["cd_programa_trabalho"] . '</td>
                                                    <td class="text-center">' . $linha["ds_programa_trabalho"] . '</td>
                                                    <td class="text-center">' . $linha["aa_programa_trabalho"] . '</td>
                                                    <td class="text-center">' . $linha["cd_prog_trab_funcao"] . '</td>
                                                    <td class="text-center">' . $linha["cd_prog_trab_subfuncao"] . '</td>
                                                    <td class="text-center">' . $linha["cd_prog_trab_programa"] . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" programa="' . $linha["cd_programa_trabalho"] . '"
                                                            value="' . $linha["id_programa_trabalho"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_programa_trabalho"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                }
                $this->msgRetorno .= '</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                return Metodos::retornoAjax("ok", "html", $this->msgRetorno);
            }
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function listarProgramaTrabalhoJson() {
        try {
            if (empty($this->cdProgramaTrabalho || $this->dsProgramaTrabalho || $this->aaProgramaTrabalho) == TRUE) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoFinProgramaTrabalho();
            $dao->setCdProgramaTrabalho($this->cdProgramaTrabalho);

            if (empty($this->cdProgramaTrabalho) == FALSE) {
                $codigo = "progTrab.cd_programa_trabalho='" . $this->cdProgramaTrabalho . "'";
            } elseif (empty($this->dsProgramaTrabalho) == FALSE) {
                $codigo = "progTrab.ds_programa_trabalho ILIKE '" . $this->dsProgramaTrabalho . "%'";
            } elseif (empty($this->aaProgramaTrabalho) == FALSE) {
                $codigo = "progTrab.aa_programa_trabalho='" . $this->aaProgramaTrabalho . "'";
            }

            $result = $dao->listarProgramaTrabalhoTotal($pdo, $codigo);
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            } else {
                return json_encode($dao->getMsgRetorno());
            }
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function listarLiberacaoJson() {
        try {
            if (empty($this->cdProgramaTrabalho || $this->dsProgramaTrabalho || $this->aaProgramaTrabalho) == TRUE) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoFinProgramaTrabalho();
          

            $result = $dao->listarProgramaTrabalhoTotal($pdo, $codigo);
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            } else {
                return json_encode($dao->getMsgRetorno());
            }
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function editarProgramaTrabalho($cdVerifica) {
        try {
            if (empty($this->cdProgramaTrabalho && $this->dsProgramaTrabalho && $this->aaProgramaTrabalho &&
                            $this->idProgTrabPrograma && $this->idProgTrabSubFuncao && $this->idProgtrabFuncao &&
                            $this->idProgramaTrabalho) == TRUE) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $dao = new DaoFinProgramaTrabalho();

            $dao->setIdProgramaTrabalho($this->idProgramaTrabalho);
            $dao->setCdProgramaTrabalho($this->cdProgramaTrabalho);
            $dao->setDsProgramaTrabalho($this->dsProgramaTrabalho);
            $dao->setAaProgramaTrabalho($this->aaProgramaTrabalho);
            $dao->setIdProgTrabFuncao($this->idProgtrabFuncao);
            $dao->setIdProgTrabSubfuncao($this->idProgTrabSubFuncao);
            $dao->setIdProgTrabPrograma($this->idProgTrabPrograma);
            $dao->retornaProgramaTrabalho($pdo);
            $busca = $dao->getMsgRetorno();

            if ($cdVerifica != $this->cdProgramaTrabalho) {
                $dao->verificaProgramaTrabalho($pdo);
                if ($dao->Sucesso()) {
                    return Metodos::retornoAjax("Erro", "alert", 'Registro com o mesmo CÓDIGO já existe no sistema.');
                } else {
                    $dao->editarProgramaTrabalho($pdo);
                    if (!$dao->Sucesso()) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                    } else {
                        if (Log::SalvaLogU('fin_programa_trabalho', $this->idProgramaTrabalho, $busca, $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        }
                    }
                }
            } else {
                $dao->editarProgramaTrabalho($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                } else {
                    if (Log::SalvaLogU('fin_programa_trabalho', $this->idProgramaTrabalho, $busca, $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                }
            }
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function desativarProgramaTrabalho() {
        try {
            if (empty($this->idProgramaTrabalho) == TRUE) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $dao = new DaoFinProgramaTrabalho();

            $dao->setIdProgramaTrabalho($this->idProgramaTrabalho);
            $dao->setCdProgramaTrabalho($this->cdProgramaTrabalho);
            $dao->retornaProgramaTrabalho($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaProgramaTrabalho($pdo);
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Registro não encontrado.");
            } else {
                $dao->desativarProgramaTrabalho($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $dao->getMsgRetorno());
                } else {
                    if (Log::SalvaLogU('fin_programa_trabalho', $dao->getIdProgramaTrabalho(), $busca, $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                }
            }
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function carregadoDadosProgramaTrbalho() {
        try {
            if (empty($this->idProgramaTrabalho) == TRUE) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoFinProgramaTrabalho();

            $dao->setIdProgramaTrabalho($this->idProgramaTrabalho);

            $dao->carregaDadosProgramaTrabalho($pdo);
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            } else {
                return $dao->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    /**
     * Retorna os options de Todas Programas de Trabalho Através de um Ano
     * @return string
     */
    public function retornaOptionSelectPorAno($idProgramaTrabalho = null) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoFinProgramaTrabalho();
            $dao->setAaProgramaTrabalho($this->aaProgramaTrabalho);

            $result = $dao->retornaTodosPorAno($pdo);

            $retorno .= "<option value=0>Selecione uma " . STR_FUNCIONAL_PROGRAMATICA . "</option>";

            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    if ($idProgramaTrabalho == $v['id_programa_trabalho']) {
                        $retorno .= "<option value='" . $v['id_programa_trabalho'] . "' selected>" . $v['cd_programa_trabalho'] . " - " . $v['ds_programa_trabalho'] . "</option>";
                    } else {
                        $retorno .= "<option value='" . $v['id_programa_trabalho'] . "'>" . $v['cd_programa_trabalho'] . " - " . $v['ds_programa_trabalho'] . "</option>";
                    }
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function carregaFuncoes() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoFinProgramaTrabalho();

            $dao->carregaFuncao($pdo);
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            } else {
                foreach ($dao->getMsgRetorno() as $linhas) {
                    if ($this->idProgtrabFuncao == $linhas['id_prog_trab_funcao']) {
                        $this->msgRetorno .= "<option value='" . $linhas['id_prog_trab_funcao'] . "' selected>" . $linhas['cd_prog_trab_funcao'] . "</option>";
                    } else {
                        $this->msgRetorno .= "<option value='" . $linhas['id_prog_trab_funcao'] . "'>" . $linhas['cd_prog_trab_funcao'] . "</option>";
                    }
                }
            }
            return $this->msgRetorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function carregaSubFuncoes() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoFinProgramaTrabalho();

            $dao->carregaSubFuncao($pdo);
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            } else {
                foreach ($dao->getMsgRetorno() as $linhas) {
                    if ($this->idProgTrabSubFuncao == $linhas['id_prog_trab_subfuncao']) {
                        $this->msgRetorno .= "<option value='" . $linhas['id_prog_trab_subfuncao'] . "' selected>" . $linhas['cd_prog_trab_subfuncao'] . "</option>";
                    } else {
                        $this->msgRetorno .= "<option value='" . $linhas['id_prog_trab_subfuncao'] . "'>" . $linhas['cd_prog_trab_subfuncao'] . "</option>";
                    }
                }
            }
            return $this->msgRetorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function carregaProgramas() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoFinProgramaTrabalho();

            $dao->carregaPrograma($pdo);
            if (!$dao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            } else {
                foreach ($dao->getMsgRetorno() as $linhas) {
                    if ($this->idProgTrabPrograma == $linhas['id_prog_trab_programa']) {
                        $this->msgRetorno .= "<option value='" . $linhas['id_prog_trab_programa'] . "' selected>" . $linhas['cd_prog_trab_programa'] . "</option>";
                    } else {
                        $this->msgRetorno .= "<option value='" . $linhas['id_prog_trab_programa'] . "'>" . $linhas['cd_prog_trab_programa'] . "</option>";
                    }
                }
            }
            return $this->msgRetorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

}

?>
