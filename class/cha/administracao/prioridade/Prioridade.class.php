<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaPrioridade.class.php";

/**
 * Description of Prioridade
 *
 * @author elivelton
 */
class Prioridade {

    private $idPrioridade = null;
    private $nmPrioridade = null;
    private $csPrioridade = null;
    private $stAtivo = null;

    /* ================================== */
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    /* ==================================== */

    function getIdPrioridade() {
        return $this->idPrioridade;
    }

    function getNmPrioridade() {
        return $this->nmPrioridade;
    }

    function getCsPrioridade() {
        return $this->csPrioridade;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdPrioridade($idPrioridade) {
        $this->idPrioridade = $idPrioridade;
    }

    function setNmPrioridade($nmPrioridade) {
        $this->nmPrioridade = $nmPrioridade;
    }

    function setCsPrioridade($csPrioridade) {
        $this->csPrioridade = $csPrioridade;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

    /* ============================================================================ */
    /* Cadastra uma prioridade */

    public function cadastrarPrioridade() {
        try {
            if (empty($this->nmPrioridade && $this->csPrioridade)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();

                $dao = new DaoChaPrioridade();
                $dao->setNmPrioridade($this->nmPrioridade);
                $dao->setCsPrioridade($this->csPrioridade);

                $dao->verificaPrioridadeNome($pdo);
                if ($dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_REGISTRO_EXISTE);
                } else {
                    $dao->cadastrarPrioridade($pdo);
                    if (!$dao->Sucesso()) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                    } else {
                        $dao->setIdPrioridade($pdo->lastInsertId('cha_prioridade_id_prioridade_seq'));
                        if (Log::SalvaLogI('cha_prioridade', $dao->getIdPrioridade(), $pdo)) {
                            $this->sucesso = TRUE;
                            $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_CADASTRO_SUCESSO);
                        } else {
                            $this->sucesso = TRUE;
                            $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /* edita uma prioridade */

    public function editarPrioridade($verifica) {
        try {
            if (empty($this->idPrioridade && $this->nmPrioridade && $this->csPrioridade)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();

                $dao = new DaoChaPrioridade();
                $dao->setIdPrioridade($this->idPrioridade);
                $dao->setNmPrioridade($this->nmPrioridade);
                $dao->setCsPrioridade($this->csPrioridade);
                $dao->retornaPrioridade($pdo);
                $busca = $dao->getMsgRetorno();

                if ($this->nmPrioridade == $verifica) {
                    $dao->verificaPrioridadeNomeCs($pdo);
                    if ($dao->Sucesso()) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_REGISTRO_EXISTE);
                    } else {
                        $dao->editarPrioridade($pdo);
                        if (!$dao->Sucesso()) {
                            $this->sucesso = FALSE;
                            $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                        } else {
                            if (Log::SalvaLogU('cha_prioridade', $this->idPrioridade, $busca, $pdo)) {
                                $this->sucesso = TRUE;
                                $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_EDICAO_SUCESSO);
                            } else {
                                $this->sucesso = TRUE;
                                $this->msgRetorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            }
                        }
                    }
                } else {
                    $dao->verificaPrioridadeNome($pdo);
                    if ($dao->Sucesso()) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_REGISTRO_EXISTE);
                    } else {
                        $dao->editarPrioridade($pdo);
                        if (!$dao->Sucesso()) {
                            $this->sucesso = FALSE;
                            $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                        } else {
                            if (Log::SalvaLogU('cha_prioridade', $this->idPrioridade, $busca, $pdo)) {
                                $this->sucesso = TRUE;
                                $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_EDICAO_SUCESSO);
                            } else {
                                $this->sucesso = TRUE;
                                $this->msgRetorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            }
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /* lista todas as prioridades */

    public function listarPrioridades() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaPrioridade();
            $dao->listarPrioridades($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
            } else {
                $this->sucesso = TRUE;
                foreach ($dao->getMsgRetorno() as $linha) {
                    $this->msgRetorno .= '
                                                <tr>
                                                    <td class="text-center">' . $linha["nm_prioridade"] . '</td>
                                                    <td class="text-center">' . $linha["cs_prioridade"] . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" prioridade="' . $linha["nm_prioridade"] . '" classificacao="' . $linha["cs_prioridade"] . '"
                                                            value="' . $linha["id_prioridade"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_prioridade"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>';

                    if ($linha['st_ativo'] == '1') {
                        $this->msgRetorno .= '
                                                            <button type="button" class="btn btn-default btn-desativar btn-xs" title="Desativar" value="' . $linha["id_prioridade"] . '">
                                                                <i class="glyphicon glyphicon-off glyphicon-sm text-success" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                    </tr>';
                    } else {
                        $this->msgRetorno .= '              <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" value="' . $linha["id_prioridade"] . '">
                                                                <i class="glyphicon glyphicon-off glyphicon-sm text-default" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                    </tr>';
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /* desativar uma prioridade */

    public function desativarPrioridade() {
        try {
            if (empty($this->idPrioridade)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();

                $dao = new DaoChaPrioridade();
                $dao->setIdPrioridade($this->idPrioridade);
                $dao->retornaPrioridade($pdo);
                $busca = $dao->getMsgRetorno();

                $dao->verificaPrioridadeId($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
                } else {
                    $dao->desativarPrioridade($pdo);
                    if (!$dao->Sucesso()) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                    } else {
                        if (Log::SalvaLogU('cha_prioridade', $this->idPrioridade, $busca, $pdo)) {
                            $this->sucesso = TRUE;
                            $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_DESATIVADO_SUCESSO);
                        } else {
                            $this->sucesso = TRUE;
                            $this->msgRetorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /* ativar uma prioridade */

    public function ativarPrioridade() {
        try {
            if (empty($this->idPrioridade)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();

                $dao = new DaoChaPrioridade();
                $dao->setIdPrioridade($this->idPrioridade);
                $dao->retornaPrioridade($pdo);
                $busca = $dao->getMsgRetorno();

                $dao->verificaPrioridadeId($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não existe no Sistema.');
                } else {
                    $dao->ativarPrioridade($pdo);
                    if (!$dao->Sucesso()) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', $dao->getMsgRetorno());
                    } else {
                        if (Log::SalvaLogU('cha_prioridade', $this->idPrioridade, $busca, $pdo)) {
                            $this->sucesso = TRUE;
                            $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_ATIVADO_SUCESSO);
                        } else {
                            $this->sucesso = TRUE;
                            $this->msgRetorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /* deletar uma prioridade */

    public function deletarPrioridade() {
        try {
            if (empty($this->idPrioridade)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();

                $dao = new DaoChaPrioridade();
                $dao->setIdPrioridade($this->idPrioridade);

                $dao->retornaPrioridade($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
                } else {
                    if (Log::SalvaLogD('cha_prioridade', $this->idPrioridade, $pdo)) {
                        $dao->deletarPrioridade($pdo);
                        if (!$dao->Sucesso()) {
                            $this->sucesso = FALSE;
                            $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                        } else {
                            $this->sucesso = TRUE;
                            $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_REMOCAO_SUCESSO);
                        }
                    } else {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
