<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaCategoriaTipo.class.php";

/**
 * Description of CategoriaTipo
 *
 * @author elivelton
 */
class CategoriaTipo {

    private $idCategoriaTipo = null;
    private $idCategoriaPrincipal = null;
    private $nmCategoriaTipo = null;
    private $stAtivo = null;
    /* ========================== */
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    /* ========================== */

    function getIdCategoriaTipo() {
        return $this->idCategoriaTipo;
    }

    function getIdCategoriaPrincipal() {
        return $this->idCategoriaPrincipal;
    }

    function getNmCategoriaTipo() {
        return $this->nmCategoriaTipo;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdCategoriaTipo($idCategoriaTipo) {
        $this->idCategoriaTipo = $idCategoriaTipo;
    }

    function setIdCategoriaPrincipal($idCategoriaPrincipal) {
        $this->idCategoriaPrincipal = $idCategoriaPrincipal;
    }

    function setNmCategoriaTipo($nmCategoriaTipo) {
        $this->nmCategoriaTipo = $nmCategoriaTipo;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

    public function cadastrarCategoriaTipo() {
        try {
            if (empty($this->nmCategoriaTipo && $this->idCategoriaPrincipal)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoChaCategoriaTipo();
            $dao->setNmCategoriaTipo($this->nmCategoriaTipo);
            $dao->setIdCategoriaPrincipal($this->idCategoriaPrincipal);

            $dao->verificaCategoriaTipo($pdo);
            if ($dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Categoria Já Existe no Sistema.');
            } else {
                $dao->cadastrarCategoriaTipo($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    $dao->setIdCategoriaTipo($pdo->lastInsertId('cha_categoria_tipo_id_categoria_tipo_seq'));
                    if (!Log::SalvaLogI('cha_categoria_tipo', $dao->getIdCategoriaTipo(), $pdo)) {
                        $pdo->rollBack();
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $pdo->commit();
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_CADASTRO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function editarCategoriaTipo() {
        try {
            if (empty($this->idCategoriaPrincipal && $this->idCategoriaTipo && $this->nmCategoriaTipo)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoChaCategoriaTipo();
            $dao->setIdCategoriaTipo($this->idCategoriaTipo);
            $dao->setNmCategoriaTipo($this->nmCategoriaTipo);
            $dao->setIdCategoriaPrincipal($this->idCategoriaPrincipal);
            $dao->retornarCategoriaTipo($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaCategoriaTipo($pdo);
            if ($dao->Sucesso()) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Categoria Já Existe no Sistema.');
            } else {
                $dao->editarCategoriaTipo($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    if (!Log::SalvaLogU('cha_categoria_tipo', $this->getIdCategoriaTipo(), $busca, $pdo)) {
                        $pdo->rollBack();
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $pdo->commit();
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_EDICAO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function removerCategoriaTipo() {
        try {
            if (empty($this->idCategoriaTipo && $this->nmCategoriaTipo && $this->idCategoriaPrincipal)) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoChaCategoriaTipo();
            $dao->setIdCategoriaTipo($this->idCategoriaTipo);

            $dao->retornarCategoriaTipo($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
            } else {
                if (!Log::SalvaLogD('cha_categoria_tipo', $this->getIdCategoriaTipo(), $pdo)) {
                    $pdo->rollBack();
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                } else {
                    $dao->removerCategoriaTipo($pdo);
                    if (!$dao->Sucesso()) {
                        $pdo->rollBack();
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                    } else {
                        $pdo->commit();
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_REMOCAO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function desativarCategoriaTipo() {
        try {
            if (empty($this->idCategoriaTipo && $this->nmCategoriaTipo && $this->idCategoriaPrincipal)) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoChaCategoriaTipo();
            $dao->setIdCategoriaTipo($this->idCategoriaTipo);
            $dao->setNmCategoriaTipo($this->nmCategoriaTipo);
            $dao->setIdCategoriaPrincipal($this->idCategoriaPrincipal);
            $dao->retornarCategoriaTipo($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaCategoriaTipo($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
            } else {
                $dao->desativarCategoriaTipo($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    if (!Log::SalvaLogU('cha_categoria_tipo', $this->getIdCategoriaTipo(), $busca, $pdo)) {
                        $pdo->rollBack();
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $pdo->commit();
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_DESATIVADO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function ativarCategoriaTipo() {
        try {
            if (empty($this->idCategoriaTipo && $this->nmCategoriaTipo && $this->idCategoriaPrincipal)) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoChaCategoriaTipo();
            $dao->setIdCategoriaTipo($this->idCategoriaTipo);
            $dao->setNmCategoriaTipo($this->nmCategoriaTipo);
            $dao->setIdCategoriaPrincipal($this->idCategoriaPrincipal);
            $dao->retornarCategoriaTipo($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaCategoriaTipo($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
            } else {
                $dao->ativarCategoriaTipo($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    if (!Log::SalvaLogU('cha_categoria_tipo', $this->getIdCategoriaTipo(), $busca, $pdo)) {
                        $pdo->rollBack();
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $pdo->commit();
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_ATIVADO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function listarCategoriaPrincipal() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaTipo();
            $dao->retornaCategoriaPrincipal($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', $dao->getMsgRetorno());
            } else {
                foreach ($dao->getMsgRetorno() as $linhas) {
                    $this->msgRetorno .= "<option value='" . $linhas['id_categoria_principal'] . "'>" . $linhas['nm_categoria_principal'] . "</option>";
                }
            }
            return $this->msgRetorno;
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function listarCategoriaTipo() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaTipo();
            $dao->listarCategoriaTipo($pdo);

            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();
            } else {
                $this->sucesso = TRUE;
                foreach ($dao->getMsgRetorno() as $linha) {
                    $this->msgRetorno .= '
                                                <tr>
                                                    <td class="text-center">' . $linha["nm_categoria_tipo"] . '</td>
                                                    <td class="text-center">' . $linha["nm_categoria_principal"] . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" categoriaPrincipal="' . $linha["id_categoria_principal"] . '" categoriaTipo="' . $linha["nm_categoria_tipo"] . '"
                                                            value="' . $linha["id_categoria_tipo"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_categoria_tipo"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>';

                    if ($linha['st_ativo'] == '1') {
                        $this->msgRetorno .= '
                                                            <button type="button" class="btn btn-default btn-desativar btn-xs" title="Desativar" value="' . $linha["id_categoria_tipo"] . '">
                                                                <i class="glyphicon glyphicon-off glyphicon-sm text-success" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                    </tr>';
                    } else {
                        $this->msgRetorno .= '              <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" value="' . $linha["id_categoria_tipo"] . '">
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
    
    public function retornaOptionPrincipais() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tip = new DaoChaCategoriaTipo();

            $result = $tip->retornaPrincipaisSelect($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_categoria_principal'] . "'>" . $v['nm_categoria_principal'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
    public function retornaOptionCategoriaTipo($idCategoriaPrincipal = null, $idCategoriaTipo = null) {
        $retorno = "<option value = '0'>Selecione a Categoria Tipo</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tip = new DaoChaCategoriaTipo();

            $tip->setIdCategoriaPrincipal($idCategoriaPrincipal);
            $result = $tip->retornaCategoriasTipo($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if (empty($tip->getIdCategoriaPrincipal())) {
                        $retorno .= "<option value = '" . $v['id_categoria_tipo'] . "'>" . $v['nm_categoria_tipo'] . " - " . $v['nm_categoria_principal'] . "</option>";
                    } else {
                        if ($idCategoriaTipo == $v['id_categoria_tipo']) {
                            $retorno .= "<option value = '" . $v['id_categoria_tipo'] . "' selected>" . $v['nm_categoria_tipo'] . "</option>";
                        } else {
                            $retorno .= "<option value = '" . $v['id_categoria_tipo'] . "'>" . $v['nm_categoria_tipo'] . "</option>";
                        }
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}
