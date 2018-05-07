<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/situacao/DaoSituacao.class.php";

class Situacao {

    private $idSituacao = null;
    private $Nova_Situacao = null;
    private $Pesq_Situacao = null;

    function getIdSituacao() {
        return $this->idSituacao;
    }

    function getNova_Situacao() {
        return $this->Nova_Situacao;
    }

    function getPesq_Situacao() {
        return $this->Pesq_Situacao;
    }

    function setIdSituacao($idSituacao) {
        $this->idSituacao = $idSituacao;
    }

    function setNova_Situacao($Nova_Situacao) {
        $this->Nova_Situacao = $Nova_Situacao;
    }

    function setPesq_Situacao($Pesq_Situacao) {
        $this->Pesq_Situacao = $Pesq_Situacao;
    }

    /*
     * Cadastra uma situação.
     */

    public function cadastrarSituacao() {
        try {
            if (empty($this->Nova_Situacao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $cad = new DaoSituacao();

                $cad->setNova_Situacao($this->Nova_Situacao);

                $busc = $cad->verificarSituacao($pdo);
                if ($busc) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Situação já existe no sistema!");
                    return $retorno;
                } else {
                    $resultado = $cad->cadastrarSituacao($pdo);
                    if (!$resultado) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $resultado);
                        $pdo->rollBack();
                        return $retorno;
                    } else {
                        $cad->setIdSituacao($pdo->lastInsertId('gco_situacao_id_situacao_seq'));
                        if (Log::SalvaLogI('gco_situacao', $cad->getIdSituacao(), $pdo)) {
                            $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                            $pdo->commit();
                            return $retorno;
                        } else {
                            $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            $pdo->rollBack();
                            return $retorno;
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Pesquisa uma situação.
     */

    public function listarSituacao($sessao) {
        try {
            if (empty($this->Pesq_Situacao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $SitDao = new DaoSituacao();

            $SitDao->setPesq_Situacao($this->Pesq_Situacao);

            $resultado = $SitDao->listarSituacao($pdo);
            if (is_array($resultado) == false) {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                return $retorno;
            } else {
                $tabela = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Situações</h3>
                        </div>
                        <div class="panel-body">
                            <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="tabela_situacao" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Situação</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($resultado as $linha) {
                    $tabela .= '      
                                                <tr>
                                                    <td class="text-center">' . $linha["nm_situacao"] . '</td>
                                                    <td class="text-center">';
                    if (!$sessao->vPComprasTecAdmin()) {
                        $tabela .= '                <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" disabled situacao="' . $linha["nm_situacao"] . '"
                                                            value="' . $linha["id_situacao"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>';
                    } else {
                        $tabela .= '                <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" situacao="' . $linha["nm_situacao"] . '"
                                                            value="' . $linha["id_situacao"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>';
                    }
                    if (!$sessao->vPComprasAdminTi()) {
                        $tabela .= '            <button type="button" class="btn btn-default btn-remover btn-xs" title="Desativar" disabled value="' . $linha["id_situacao"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                    } else {
                        $tabela .= '                <button type="button" class="btn btn-default btn-remover btn-xs" title="Desativar" value="' . $linha["id_situacao"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                    }
                }
                $tabela .= '            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>';
                return Metodos::retornoAjax("ok", "html", $tabela);
            }
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    /*
     * Lista todas as situações.
     */

    public function retornarTodasSituacoes($sessao) {
        try {
            //instanciando as classes
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $SitDao = new DaoSituacao();

            //chamando metodo para listar objeto
            $resultado = $SitDao->listarTodasSituacoes($pdo);
            if (is_array($resultado) == false) {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                return $retorno;
            } else {
                $tabela = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Situações</h3>
                        </div>
                        <div class="panel-body">
                            <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="tabela_situacao" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Situação</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($resultado as $linha) {
                    $tabela .= '      
                                                <tr>
                                                    <td class="text-center">' . $linha["nm_situacao"] . '</td>
                                                    <td class="text-center">';
                    if (!$sessao->vPComprasTecAdmin()) {
                        $tabela .= '                <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" disabled situacao="' . $linha["nm_situacao"] . '"
                                                            value="' . $linha["id_situacao"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>';
                    } else {
                        $tabela .= '                <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" situacao="' . $linha["nm_situacao"] . '"
                                                            value="' . $linha["id_situacao"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>';
                    }
                    if (!$sessao->vPComprasAdminTi()) {
                        $tabela .= '            <button type="button" class="btn btn-default btn-remover btn-xs" title="Desativar" disabled value="' . $linha["id_situacao"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                    } else {
                        $tabela .= '                <button type="button" class="btn btn-default btn-remover btn-xs" title="Desativar" value="' . $linha["id_situacao"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                    }
                }
                $tabela .= '            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>';
                return Metodos::retornoAjax("ok", "html", $tabela);
            }
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    /*
     * Edita uma situação.
     */

    public function editarSituacao() {
        try {
            if (empty($this->Nova_Situacao && $this->idSituacao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                //instaciando as classes
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $situDao = new DaoSituacao();
                $situDao->setNova_Situacao($this->Nova_Situacao);
                $situDao->setIdSituacao($this->idSituacao);
                $busca = $situDao->retornaSituacao($pdo);

                //verifica se a situação já existe no banco
                $result = $situDao->verificarSituacao($pdo);

                if ($result) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Situação já Existe no Sistema!");
                    $pdo->rollBack();
                    return $retorno;
                } else {
                    //chamando metodo para cadastrar o objeto no banco
                    $editaSituacao = $situDao->editarSituacao($pdo);
                    if (!$editaSituacao) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $editaSituacao);
                        $pdo->rollBack();
                        return $retorno;
                    } else {
                        if (Log::SalvaLogU('gco_situacao', $situDao->getIdSituacao(), $busca, $pdo)) {
                            $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                            $pdo->commit();
                            return $retorno;
                        } else {
                            $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            $pdo->rollBack();
                            return $retorno;
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Desativa uma situação.
     */

    public function desativarSituacao() {
        try {
            if (empty($this->idSituacao)) {
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                //Seta os Campos
                $delSituacao = new DaoSituacao();

                $delSituacao->setIdSituacao($this->idSituacao);
                $dadosAntigos = $delSituacao->retornaSituacao($pdo);

                if ($dadosAntigos == FALSE) {
                    $retorno = retornoAjax("Erro", "alert", "Ops! Situação não Encontrada.");
                    $pdo->rollBack();
                    return $retorno;
                } else {
                    //desativando a situação
                    $resultDao = $delSituacao->desativarSituacao($pdo);
                    if (!$resultDao) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                        $pdo->rollBack();
                        return $retorno;
                    } else {
                        if (Log::SalvaLogU('gco_situacao', $delSituacao->getIdSituacao(), $dadosAntigos, $pdo)) {
                            $retorno = Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
                            $pdo->commit();
                            return $retorno;
                        } else {
                            $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            $pdo->rollBack();
                            return $retorno;
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Lista todas as situações desativadas.
     */

    public function situacoesDesativadas() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoSituacao();
            $resultado = $dao->situacoesDesativadas($pdo);
            if (is_array($resultado) == false) {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultado);
                $pdo->rollBack();
                return $retorno;
            } else {
                $tabela = '';
                foreach ($resultado as $linha) {
                    $tabela .= '<tr id="tabela_situacao">
                                    <td class="text-center">' . $linha["nm_situacao"] . '</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" id_situacao="' . $linha["id_situacao"] . '" value="' . $linha["id_situacao"] . '">
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
     * Ativa uma situação desativada.
     */

    public function ativarSituacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoSituacao();
            $dao->setIdSituacao($this->idSituacao);
            $dadosAntigos = $dao->retornaSituacao($pdo);

            if ($dadosAntigos == FALSE) {
                $retorno = Metodos::retornoAjax("Erro", "console", "Ops! Situação não Encontrada.");
                return $retorno;
            } else {
                $resultado = $dao->ativarSituacao($pdo);
                if ($resultado) {
                    if (Log::SalvaLogU('gco_situacao', $dao->getIdSituacao(), $dadosAntigos, $pdo)) {
                        $retorno = Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
                        $pdo->commit();
                        return $retorno;
                    } else {
                        $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        $pdo->rollBack();
                        return $retorno;
                    }
                } else {
                    $retorno = Metodos::retornoAjax("Erro", "console", $resultado);
                    $pdo->rollBack();
                    return $retorno;
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function retornaSelectOption() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $sitDao = new DaoSituacao();
            $situacao = '';
            $resultado = $sitDao->listarTodasSituacoes($pdo);
            if (!$resultado) {
                return $resultado;
            } else {
                foreach ($resultado as $linha) {
                    if ($this->idSituacao == $linha['id_situacao']) {
                        $situacao .= '<option value="' . $linha["id_situacao"] . '" selected>' . $linha["nm_situacao"] . '</option>';
                    } else {
                        $situacao .= '<option value="' . $linha["id_situacao"] . '">' . $linha["nm_situacao"] . '</option>';
                    }
                }
            }
            return $situacao;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

}
