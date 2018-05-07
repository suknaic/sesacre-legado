<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaCategoriaPrimaria.class.php";

/**
 * Description of CategoriaTipo
 *
 * @author elivelton
 */
class CategoriaPrimaria {

    private $idCategoriaPrimaria = null;
    private $idCategoriaTipo = null;
    private $nmCategoriaPrimaria = null;
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

    function getIdCategoriaPrimaria() {
        return $this->idCategoriaPrimaria;
    }

    function getIdCategoriaTipo() {
        return $this->idCategoriaTipo;
    }

    function getNmCategoriaPrimaria() {
        return $this->nmCategoriaPrimaria;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function getSucesso() {
        return $this->sucesso;
    }

    function setIdCategoriaPrimaria($idCategoriaPrimaria) {
        $this->idCategoriaPrimaria = $idCategoriaPrimaria;
    }

    function setIdCategoriaTipo($idCategoriaTipo) {
        $this->idCategoriaTipo = $idCategoriaTipo;
    }

    function setNmCategoriaPrimaria($nmCategoriaPrimaria) {
        $this->nmCategoriaPrimaria = $nmCategoriaPrimaria;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

    function setSucesso($sucesso) {
        $this->sucesso = $sucesso;
    }

    public function cadastrarCategoriaPrimaria() {
        try {
            if (empty($this->nmCategoriaPrimaria && $this->idCategoriaTipo)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaPrimaria();
            $dao->setNmCategoriaPrimaria($this->nmCategoriaPrimaria);
            $dao->setIdCategoriaTipo($this->idCategoriaTipo);

            $dao->verificaCategoriaPrimaria($pdo);
            if ($dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Categoria Já Existe no Sistema.');
            } else {
                $dao->cadastrarCategoriaPrimaria($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    $dao->setIdCategoriaPrimaria($pdo->lastInsertId('cha_categoria_primaria_id_categoria_primaria_seq'));
                    if (!Log::SalvaLogI('cha_categoria_primaria', $dao->getIdCategoriaPrimaria(), $pdo)) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
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

    public function editarCategoriaPrimaria() {
        try {
            if (empty($this->idCategoriaTipo && $this->idCategoriaPrimaria && $this->nmCategoriaPrimaria)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaPrimaria();
            $dao->setIdCategoriaPrimaria($this->idCategoriaPrimaria);
            $dao->setNmCategoriaPrimaria($this->nmCategoriaPrimaria);
            $dao->setIdCategoriaTipo($this->idCategoriaTipo);
            $dao->retornarCategoriaPrimaria($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaCategoriaPrimaria($pdo);
            if ($dao->Sucesso()) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Categoria Já Existe no Sistema.');
            } else {
                $dao->editarCategoriaPrimaria($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    if (!Log::SalvaLogU('cha_categoria_primaria', $this->getIdCategoriaPrimaria(), $busca, $pdo)) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
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

    public function removerCategoriaPrimaria() {
        try {
            if (empty($this->idCategoriaPrimaria && $this->nmCategoriaPrimaria && $this->idCategoriaTipo)) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaPrimaria();
            $dao->setIdCategoriaPrimaria($this->idCategoriaPrimaria);

            $dao->retornarCategoriaPrimaria($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
            } else {
                if (!Log::SalvaLogD('cha_categoria_primaria', $this->getIdCategoriaPrimaria(), $pdo)) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                } else {
                    $dao->removerCategoriaPrimaria($pdo);
                    if (!$dao->Sucesso()) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                    } else {
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

    public function desativarCategoriaPrimaria() {
        try {
            if (empty($this->idCategoriaPrimaria && $this->nmCategoriaPrimaria && $this->idCategoriaTipo)) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaPrimaria();
            $dao->setIdCategoriaPrimaria($this->idCategoriaPrimaria);
            $dao->setNmCategoriaPrimaria($this->nmCategoriaPrimaria);
            $dao->setIdCategoriaTipo($this->idCategoriaTipo);
            $dao->retornarCategoriaPrimaria($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaCategoriaPrimaria($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
            } else {
                $dao->desativarCategoriaPrimaria($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    if (!Log::SalvaLogU('cha_categoria_primaria', $this->getIdCategoriaPrimaria(), $busca, $pdo)) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
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

    public function ativarCategoriaPrimaria() {
        try {
            if (empty($this->idCategoriaPrimaria && $this->nmCategoriaPrimaria && $this->idCategoriaTipo)) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaPrimaria();
            $dao->setIdCategoriaPrimaria($this->idCategoriaPrimaria);
            $dao->setNmCategoriaPrimaria($this->nmCategoriaPrimaria);
            $dao->setIdCategoriaTipo($this->idCategoriaTipo);
            $dao->retornarCategoriaPrimaria($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaCategoriaPrimaria($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
            } else {
                $dao->ativarCategoriaPrimaria($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    if (!Log::SalvaLogU('cha_categoria_primaria', $this->getIdCategoriaPrimaria(), $busca, $pdo)) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
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

    public function listarCategoriaTipo() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaPrimaria();
            $dao->retornaCategoriaTipo($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', $dao->getMsgRetorno());
            } else {
                foreach ($dao->getMsgRetorno() as $linhas) {
                    $this->msgRetorno .= "<option value='" . $linhas['id_categoria_tipo'] . "'>" . $linhas['nm_categoria_tipo'] . "</option>";
                }
            }
            return $this->msgRetorno;
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function listarCategoriaPrimaria() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaPrimaria();
            $dao->listarCategoriaPrimaria($pdo);

            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();
            } else {
                $this->sucesso = TRUE;
                foreach ($dao->getMsgRetorno() as $linha) {
                    $this->msgRetorno .= '
                                                <tr>
                                                    <td class="text-center">' . $linha["nm_categoria_primaria"] . '</td>
                                                    <td class="text-center">' . $linha["nm_categoria_tipo"] . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" categoriaTipo="' . $linha["id_categoria_tipo"] . '" categoriaPrimaria="' . $linha["nm_categoria_primaria"] . '"
                                                            value="' . $linha["id_categoria_primaria"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_categoria_primaria"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>';

                    if ($linha['st_ativo'] == '1') {
                        $this->msgRetorno .= '
                                                            <button type="button" class="btn btn-default btn-desativar btn-xs" title="Desativar" value="' . $linha["id_categoria_primaria"] . '">
                                                                <i class="glyphicon glyphicon-off glyphicon-sm text-success" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                    </tr>';
                    } else {
                        $this->msgRetorno .= '              <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" value="' . $linha["id_categoria_primaria"] . '">
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
    
    public function retornaOptionCategoriaPrimaria($idCategoriaTipo = null, $idCategoriaPrimaria = null) {
        $retorno = "<option value = '0'>Selecione a Categoria Primária</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $prim = new DaoChaCategoriaPrimaria();

            $prim->setIdCategoriaTipo($idCategoriaTipo);
            $result = $prim->retornaCategoriasPrimaria($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if (empty($prim->getIdCategoriaTipo())) {
                        $retorno .= "<option value = '" . $v['id_categoria_primaria'] . "'>" . $v['nm_categoria_primaria'] . " - " . $v['nm_categoria_tipo'] . "</option>";
                    } else {
                        if ($idCategoriaPrimaria == $v['id_categoria_primaria']) {
                            $retorno .= "<option value = '" . $v['id_categoria_primaria'] . "' selected>" . $v['nm_categoria_primaria'] . "</option>";
                        } else {
                            $retorno .= "<option value = '" . $v['id_categoria_primaria'] . "'>" . $v['nm_categoria_primaria'] . "</option>";
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
