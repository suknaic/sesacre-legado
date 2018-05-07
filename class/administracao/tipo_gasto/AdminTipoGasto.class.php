<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/administracao/tipo_gasto/DaoAdminTipoGasto.class.php";

/**
 * Description of TipoGasto
 *
 * @author elivelton
 */
class AdminTipoGasto {

    private $idTipoGasto = null;
    private $nmTipoGasto = null;

    function getIdTipoGasto() {
        return $this->idTipoGasto;
    }

    function getNmTipoGasto() {
        return $this->nmTipoGasto;
    }

    function setIdTipoGasto($idTipoGasto) {
        $this->idTipoGasto = $idTipoGasto;
    }

    function setNmTipoGasto($nmTipoGasto) {
        $this->nmTipoGasto = $nmTipoGasto;
    }

    public function cadastrarTipoGasto() {
        try {
            if (empty($this->nmTipoGasto)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $daoTipoGasto = new DaoAdminTipoGasto();
                $daoTipoGasto->setNmTipoGasto($this->nmTipoGasto);

                if ($daoTipoGasto->verificarExistenciaTipoGasto($pdo, "nm_tipo_gasto", "'" . $this->nmTipoGasto . "'") == 0) {
                    if ($daoTipoGasto->inserirTipoGastor($pdo)) {
                        $daoTipoGasto->setIdTipoGasto($pdo->lastInsertId('pla_tipo_gasto_id_tipo_gasto_seq'));
                        if (Log::SalvaLogI('pla_tipo_gasto', $daoTipoGasto->getIdTipoGasto(), $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax('ok', 'html', STR_CADASTRO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                } else {
                    return Metodos::retornoAjax('Erro', 'alert', STR_REGISTRO_EXISTE);
                }
            }
        } catch (Exception $ex) {
            
        }
    }

    public function listarTipoGasto() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoTipoGasto = new DaoAdminTipoGasto();
            $resultado = $daoTipoGasto->listarTipoGasto($pdo);
            $retorno = "";
            if (!is_array($resultado)) {
                return Metodos::retornoAjax('Erro', 'console', $resultado);
            } else {
                foreach ($resultado as $linha) {
                    $retorno .= '
                                <tr>
                                    <td class="text-left">' . $linha["nm_tipo_gasto"] . '</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" tipoGasto="' . $linha["nm_tipo_gasto"] . '" value="' . $linha["id_tipo_gasto"] . '">
                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_tipo_gasto"] . '">
                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>';
                }
                return $retorno;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function editarTipoGasto() {
        try {
            if (empty($this->idTipoGasto && $this->nmTipoGasto)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $daoTipoGasto = new DaoAdminTipoGasto();
                $dados = $daoTipoGasto->verificarExistenciaTipoGasto($pdo, "id_tipo_gasto", $this->idTipoGasto);

                if ($this->nmTipoGasto == $dados['nm_tipo_gasto']) {
                    return Metodos::retornoAjax('ok', 'html', STR_EDICAO_SUCESSO);
                } else {
                    if ($daoTipoGasto->verificarExistenciaTipoGasto($pdo, "nm_tipo_gasto", "'" . $this->nmTipoGasto . "'") == 0) {
                        $daoTipoGasto->setNmTipoGasto($this->nmTipoGasto);
                        $daoTipoGasto->setIdTipoGasto($this->idTipoGasto);
                        if ($daoTipoGasto->editarTipoGasto($pdo)) {
                            if (Log::SalvaLogU('pla_tipo_gasto', $this->idTipoGasto, $dados, $pdo)) {
                                $pdo->commit();
                                return Metodos::retornoAjax('ok', 'html', STR_EDICAO_SUCESSO);
                            } else {
                                $pdo->rollBack();
                                return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                            }
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                        }
                    } else {
                        return Metodos::retornoAjax('Erro', 'alert', STR_REGISTRO_EXISTE);
                    }
                }
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function desativarTipoGasto() {
        try {
            if (empty($this->idTipoGasto)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $daoTipoGasto = new DaoAdminTipoGasto();
                if ($daoTipoGasto->verificarExistenciaTipoGasto($pdo, "id_tipo_gasto", $this->idTipoGasto) != 0) {
                    $daoTipoGasto->setIdTipoGasto($this->idTipoGasto);
                    if ($daoTipoGasto->desativarTipoGasto($pdo)) {
                        if (Log::SalvaLogD('pla_tipo_gasto', $daoTipoGasto->getIdTipoGasto(), $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax('ok', 'html', STR_REMOCAO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                } else {
                    return Metodos::retornoAjax('Erro', 'alert', 'Registro Não Encontrado');
                }
            }
        } catch (Exception $ex) {
            
        }
    }

    public function retornoSelectOption() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoTipoGasto = new DaoAdminTipoGasto();

            $resultado = $daoTipoGasto->listarTipoGasto($pdo);

            if (!is_array($resultado)) {
                return Metodos::retornoAjax('Erro', 'console', $resultado);
            } else {
                foreach ($resultado as $v) {
                    if ($this->idTipoGasto == $v['id_tipo_gasto']) {
                        $retorno .= "<option value='" . $v['id_tipo_gasto'] . "' selected>" . $v['nm_tipo_gasto'] . "</option>";
                    } else {
                        $retorno .= "<option value='" . $v['id_tipo_gasto'] . "'>" . $v['nm_tipo_gasto'] . "</option>";
                    }
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
