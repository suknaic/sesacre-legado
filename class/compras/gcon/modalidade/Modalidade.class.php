<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/modalidade/DaoModalidade.class.php";

class Modalidade {

    private $idModalidade = null;
    private $modalidade = null;

    function getIdModalidade() {
        return $this->idModalidade;
    }

    function getModalidade() {
        return $this->modalidade;
    }

    function setIdModalidade($idModalidade) {
        $this->idModalidade = $idModalidade;
    }

    function setModalidade($modalidade) {
        $this->modalidade = $modalidade;
    }

    /*
     * Método para cadastro de modaldidade
     */

    public function cadastrarModalidade() {
        try {
            if (empty($this->modalidade) == true) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $cad = new DaoModalidade();

                $cad->setModalidade($this->modalidade);
                $verifica = $cad->verificaModalidade($pdo);
                if ($verifica) {
                    return Metodos::retornoAjax("Erro", "alert", "Modalidade já existe no sistema!");
                } else {
                    $cadastra = $cad->cadastraModalidade($pdo);
                    if (!$cadastra) {
                        return Metodos::retornoAjax("Erro", "console", $cadastra);
                        $pdo->rollBack();
                    } else {
                        $cad->setIdModalidade($pdo->lastInsertId('gco_modalidade_id_modalidade_seq'));
                        if (Log::SalvaLogI('gco_modalidade', $cad->getIdModalidade(), $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
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
     * Método para listar modaldidade pesquisada
     */

    public function listarModalidade($session) {
        try {
            //verificado se o campo está vazio
            if (empty($this->modalidade) == true) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                //instanciando as classes
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $modDao = new DaoModalidade();

                //setando os campos para a extenção
                $modDao->setModalidade($this->modalidade);

                //chamando metodo para listar modalidade
                $resultado = $modDao->listaModalidade($pdo);
                if (!is_array($resultado)) {
                    return Metodos::retornoAjax("Erro", "console", $resultado);
                } else {

                    $tabela = ' 
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Lista de Modalidades</h3>
                                            </div>
                                            <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table id="tabela_modalidade" class="table table-striped table-bordered" cellspacing="0"
                                                                   width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-capitalize text-center">Modalidade</th>
                                                                        <th class="text-capitalize text-center">Ação</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                    foreach ($resultado as $linha) {
                        $tabela .= '                                <tr>
                                                                        <td class="text-center">' . $linha["nm_modalidade"] . '</td>
                                                                        <td class="text-center">';
                        if (!$session->vPComprasTecAdmin()) {
                            $tabela .= '                                  <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" disabled modalidade="' . $linha["nm_modalidade"] . '"
                                                                                value="' . $linha["id_modalidade"] . '">
                                                                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                                            </button>';
                        } else {
                            $tabela .= '                                  <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" modalidade="' . $linha["nm_modalidade"] . '"
                                                                                value="' . $linha["id_modalidade"] . '">
                                                                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                                            </button>';
                        }
                        if (!$session->vPComprasAdminTi()) {
                            $tabela .= '                                      <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" disabled value="' . $linha["id_modalidade"] . '">
                                                                                    <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>';
                        } else {
                            $tabela .= '                                      <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_modalidade"] . '">
                                                                                    <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                                                </button>
                                                                            </td>
                                                                    </tr>';
                        }
                    }
                    $tabela .= "                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                    return Metodos::retornoAjax("ok", "html", $tabela);
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * metodo para listar todas as modaldidades
     */

    public function retornarTodasModalidades($session) {
        try {
            //instanciando as classes
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $modDao = new DaoModalidade();

            //chamando metodo para listar modalidade
            $resultado = $modDao->retornaTodasModalidades($pdo);
            if (!is_array($resultado)) {
                return Metodos::retornoAjax("Erro", "console", $resultado);
            } else {

                $tabela = ' 
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Lista de Modalidades</h3>
                                            </div>
                                            <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table id="tabela_modalidade" class="table table-striped table-bordered" cellspacing="0"
                                                                   width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-capitalize text-center">Modalidade</th>
                                                                        <th class="text-capitalize text-center">Ação</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                foreach ($resultado as $linha) {
                    $tabela .= '                                    <tr>
                                                                        <td class="text-center">' . $linha["nm_modalidade"] . '</td>
                                                                        <td class="text-center">';
                    if (!$session->vPComprasTecAdmin()) {
                        $tabela .= '                                  <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" disabled modalidade="' . $linha["nm_modalidade"] . '"
                                                                                value="' . $linha["id_modalidade"] . '">
                                                                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                                            </button>';
                    } else {
                        $tabela .= '                                  <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" modalidade="' . $linha["nm_modalidade"] . '"
                                                                                value="' . $linha["id_modalidade"] . '">
                                                                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                                            </button>';
                    }
                    if (!$session->vPComprasAdminTi()) {
                        $tabela .= '                                      <button type="button" class="btn btn-default btn-remover btn-xs" title="Desativar" disabled value="' . $linha["id_modalidade"] . '">
                                                                                    <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>';
                    } else {
                        $tabela .= '                                      <button type="button" class="btn btn-default btn-remover btn-xs" title="Desativar" value="' . $linha["id_modalidade"] . '">
                                                                                    <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                                                </button>
                                                                            </td>
                                                                    </tr>';
                    }
                }
                $tabela .= "                                    </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                return Metodos::retornoAjax("ok", "html", $tabela);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Método para editar modaldidade.
     */

    public function editarModalidade() {
        try {
            if (empty($this->modalidade && $this->idModalidade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                //instaciando as classes
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $modDao = new DaoModalidade();

                $modDao->setModalidade($this->modalidade);
                $modDao->setIdModalidade($this->idModalidade);
                $dadosAntigos = $modDao->retornaModalidade($pdo);

                //verifica se a modalidade já existe no banco
                $result = $modDao->verificaModalidade($pdo);
                if ($result) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Modalidade já Existe no sistema.");
                    return $retorno;
                } else {
                    //chamando metodo para cadastrar a modalidade no banco
                    $edita = $modDao->editarModalidade($pdo);
                    if (!$edita) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $edita);
                        $pdo->rollBack();
                        return $retorno;
                    } else {
                        if (Log::SalvaLogU('gco_modalidade', $modDao->getIdModalidade(), $dadosAntigos, $pdo)) {
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
     * Método para desativar modaldidade.
     */

    public function removerModalidade() {
        try {
            if (empty($this->idModalidade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                //Seta os Campos
                $delModalidade = new DaoModalidade();

                $delModalidade->setIdModalidade($this->idModalidade);
                $dadosAntigos = $delModalidade->retornaModalidade($pdo);

                if ($dadosAntigos == FALSE) {
                    $retorno = retornoAjax("Erro", "alert", "Ops! Modalidade não encontrada!");
                    return $retorno;
                } else {
                    $resultDao = $delModalidade->desativarModalidade($pdo);
                    if (!$resultDao) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                        $pdo->rollBack();
                        return $retorno;
                    } else {
                        if (Log::SalvaLogU('gco_modalidade', $delModalidade->getIdModalidade(), $dadosAntigos, $pdo)) {
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
     * Método para listar modalidades desativadas.
     */

    public function modalidadesDesativadas() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoModalidade();
            $resultado = $dao->modalidadesDesativadas($pdo);
            if (is_array($resultado) == false) {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultado);
                return $retorno;
            } else {
                $tabela = '';
                foreach ($resultado as $linha) {
                    $tabela .= '<tr id="tabela_modalidade">
                                    <td class="text-center">' . $linha["nm_modalidade"] . '</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" id_modalidade="' . $linha["id_modalidade"] . '" value="' . $linha["id_modalidade"] . '">
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
     * Ativar modalidade desativada.
     */

    public function ativarModalidade() {
        try {
            if (empty($this->idModalidade)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $dao = new DaoModalidade();
                $dao->setIdModalidade($this->idModalidade);

                $dadosAntigos = $dao->retornaModalidade($pdo);
                if ($dadosAntigos == FALSE) {
                    $retorno = Metodos::retornoAjax("Erro", "console", "Ops! Modalidade não encontrada!");
                    return $retorno;
                } else {
                    $resultado = $dao->ativarModalidade($pdo);
                    if (!$resultado) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $resultado);
                        $pdo->rollBack();
                        return $retorno;
                    } else {
                        if (Log::SalvaLogU('gco_modalidade', $dao->getIdModalidade(), $dadosAntigos, $pdo)) {
                            $retorno = Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
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
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    /*
     * Lista todas as modalidades no select option.
     */
    public function retornarSelectOption() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoModalidade();
            $modalidades = '';
            $resultado = $dao->retornaTodasModalidades($pdo);
            foreach ($resultado as $linha) {
                if ($this->idModalidade == $linha["id_modalidade"]) {
                    $modalidades .= '<option value="' . $linha["id_modalidade"] . '" selected>' . $linha["nm_modalidade"] . '</option>';
                } else {
                    $modalidades .= '<option value="' . $linha["id_modalidade"] . '">' . $linha["nm_modalidade"] . '</option>';
                }
            }
            return $modalidades;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
}
