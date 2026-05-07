<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/unidade/DaoUnidade.class.php";

class Unidade {

    private $unidade = null;
    private $idUnidade = null;

    function getUnidade() {
        return $this->unidade;
    }

    function setUnidade($unidade) {
        $this->unidade = $unidade;
    }

    function getIdUnidade() {
        return $this->idUnidade;
    }

    function setIdUnidade($idUnidade) {
        $this->idUnidade = $idUnidade;
    }

    /*
     * Cadastrar unidade.
     */

    public function cadastrarUnidade() {
        try {
            if (empty($this->unidade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $cad = new DaoUnidade();
                $cad->setUnidade($this->unidade);

                $verifica = $cad->verificarUnidade($pdo);
                $retorno = Metodos::retornoAjax("Erro", "alert", $cadastrar);
                if ($verifica) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Unidade já existe no sistema.");
                } else {
                    $cadastrar = $cad->cadastrarUnidade($pdo);
                    if (!$cadastrar) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", $cadastrar);
                    } else {
                        $cad->setIdUnidade($pdo->lastInsertId('gco_unidade_contempladas_id_unidade_contempladas_seq'));
                        if (Log::SalvaLogI('gco_unidade_contempladas', $cad->getIdUnidade(), $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Pesquisa uma unidade.
     */

    public function pesquisarUnidade($sessão) {
        try {
            if (empty($this->unidade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $unidadeDao = new DaoUnidade();

                $unidadeDao->setUnidade($this->unidade);

                $busca = $unidadeDao->pesquisarUnidade($pdo);
                if (!is_array($busca)) {
                    return Metodos::retornoAjax("Erro", "console", $busca);
                } else {
                    $tabela = '
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Lista de Unidades Contempladas</h3>
                            </div>
                            <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tabela_unidade" class="table table-striped table-bordered" cellspacing="0"
                                                   width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-capitalize text-center">Unidade Contemplada</th>
                                                        <th class="text-capitalize text-center">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                    foreach ($busca as $linha) {
                        $tabela .= '      
                                                    <tr>
                                                        <td class="text-center">' . $linha["nm_unidade_contempladas"] . '</td>
                                                        <td class="text-center">';
                        if (!$sessão->vPComprasTecAdmin()) {
                            $tabela .= '                <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" disabled unidade="' . $linha["nm_unidade_contempladas"] . '" value="' . $linha["id_unidade_contempladas"] . '">
                                                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                            </button>';
                        } else {
                            $tabela .= '                <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" unidade="' . $linha["nm_unidade_contempladas"] . '" value="' . $linha["id_unidade_contempladas"] . '">
                                                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                            </button>';
                        }
                        if (!$sessão->vPComprasAdminTi()) {
                            $tabela .= '                <button type="button" class="btn btn-default btn-remover btn-xs" title="Desativar" disabled value="' . $linha["id_unidade_contempladas"] . '">
                                                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                            </button>
                                                        </td>';
                        } else {
                            $tabela .= '                <button type="button" class="btn btn-default btn-remover btn-xs" title="Desativar" value="' . $linha["id_unidade_contempladas"] . '">
                                                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                            </button>
                                                        </td>';
                        }
                        $tabela .= '            </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                    return Metodos::retornoAjax("ok", "html", $tabela);
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    /*
     * Lista todas as unidades.
     */

    public function retornarTodasUnidades($sessão) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $unidadeDao = new DaoUnidade();

            $busca = $unidadeDao->retornarTodasUnidades($pdo);
            if (!is_array($busca)) {
                return Metodos::retornoAjax("Erro", "console", $busca);
            } else {
                $tabela = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Unidades Contempladas</h3>
                        </div>
                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tabela_unidade" class="table table-striped table-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Unidade Contemplada</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($busca as $linha) {
                    $tabela .= '      
                                                <tr>
                                                    <td class="text-center">' . $linha["nm_unidade_contempladas"] . '</td>
                                                    <td class="text-center">';
                    if (!$sessão->vPComprasTecAdmin()) {
                        $tabela .= '                    <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" disabled unidade="' . $linha["nm_unidade_contempladas"] . '" value="' . $linha["id_unidade_contempladas"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>';
                    } else {
                        $tabela .= '                    <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" unidade="' . $linha["nm_unidade_contempladas"] . '" value="' . $linha["id_unidade_contempladas"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>';
                    }
                    if (!$sessão->vPComprasAdminTi()) {
                        $tabela .= '                    <button type="button" class="btn btn-default btn-remover btn-xs" title="Desativar" disabled value="' . $linha["id_unidade_contempladas"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>';
                    } else {
                        $tabela .= '                     <button type="button" class="btn btn-default btn-remover btn-xs" title="Desativar" value="' . $linha["id_unidade_contempladas"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>';
                    }
                }
                $tabela .= '                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                return Metodos::retornoAjax("ok", "html", $tabela);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    /*
     * Edita uma unidade.
     */

    public function editarUnidade() {
        try {
            if (empty($this->unidade && $this->idUnidade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $unidadeDao = new DaoUnidade();
                $unidadeDao->setUnidade($this->unidade);
                $unidadeDao->setIdUnidade($this->idUnidade);
                $dadosAntigos = $unidadeDao->retornarUnidade($pdo);

                $verifica = $unidadeDao->verificarUnidade($pdo);
                if ($verifica) {
                    return Metodos::retornoAjax("Erro", "alert", "Unidade já Existe no Sistema.");
                } else {
                    $edita = $unidadeDao->editarUnidade($pdo);
                    if (!$edita) {
                        return Metodos::retornoAjax("Erro", "console", $edita);
                    } else {
                        if (Log::SalvaLogU('gco_unidade_contempladas', $unidadeDao->getIdUnidade(), $dadosAntigos, $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($ex));
        }
    }

    /*
     * Desativa uma unidade.
     */

    public function desativarUnidade() {
        try {
            if (empty($this->idUnidade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $unidadeDao = new DaoUnidade();
                $unidadeDao->setIdUnidade($this->idUnidade);

                $dadosAntigos = $unidadeDao->retornarUnidade($pdo);
                if (!$dadosAntigos) {
                    return Metodos::retornoAjax("Erro", "alert", "Unidade não Encontrada no Sistema.");
                } else {
                    $desativa = $unidadeDao->desativarUnidade($pdo);
                    if (!$desativa) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", $desativa);
                    } else {
                        if (Log::SalvaLogU('gco_unidade_contempladas', $unidadeDao->getIdUnidade(), $dadosAntigos, $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    /*
     * Lista todas as unidades desativadas.
     */

    public function UnidadesDesativadas() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoUnidade();
            $busca = $dao->unidadesDesativadas($pdo);
            if (!is_array($busca)) {
                $retorno = Metodos::retornoAjax("Erro", "console", $busca);
                return $retorno;
            } else {
                $tabela = '';
                foreach ($busca as $linha) {
                    $tabela .= '<tr id="tabela_unidade">
                                    <td class="text-center">' . $linha["nm_unidade_contempladas"] . '</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" id_unidade="' . $linha["id_unidade_contempladas"] . '" value="' . $linha["id_unidade_contempladas"] . '">
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

    /*
     * Ativar unidade.
     */

    public function ativarUnidade() {
        try {
            if (empty($this->idUnidade)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $dao = new DaoUnidade();
                $dao->setIdUnidade($this->idUnidade);

                $dadosAntigos = $dao->retornarUnidade($pdo);
                if (!$dadosAntigos) {
                    return Metodos::retornoAjax("Erro", "alert", 'Unidade não Encontrada no Sistema.');
                } else {
                    $resultado = $dao->ativarUnidade($pdo);
                    if ($resultado) {
                        if (Log::SalvaLogU('gco_unidade_contempladas', $dao->getIdUnidade(), $dadosAntigos, $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $resultado);
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function retornarSelectOption() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $unidadeDao = new DaoUnidade();
            $unidades = '';
            $resultado = $unidadeDao->retornarTodasUnidades($pdo);
            if (!$resultado) {
                return $resultado;
            } else {
                foreach ($resultado as $linha) {
                    if ($this->idUnidade == $linha["id_unidade_contempladas"]) {
                        $unidades .= '<option value="' . $linha["id_unidade_contempladas"] . '" selected>' . $linha["nm_unidade_contempladas"] . '</option>';
                    } else {
                        $unidades .= '<option value="' . $linha["id_unidade_contempladas"] . '">' . $linha["nm_unidade_contempladas"] . '</option>';
                    }
                }
            }
            return $unidades;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

}
