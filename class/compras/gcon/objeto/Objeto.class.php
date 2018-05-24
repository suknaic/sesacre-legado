<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/objeto/DaoObjeto.class.php";

class Objeto {

    private $idObjeto = null;
    private $objeto = null;

    function getIdObjeto() {
        return $this->idObjeto;
    }

    function getObjeto() {
        return $this->objeto;
    }

    function setIdObjeto($idObjeto) {
        $this->idObjeto = $idObjeto;
    }

    function setObjeto($objeto) {
        $this->objeto = $objeto;
    }

    /**
     * Cadasta um objeto.
     */
    public function cadastrarObjeto() {
        try {
            if (empty($this->objeto)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $cad = new DaoObjeto();

            $cad->setObjeto($this->objeto);

            $busca = $cad->verificarObjeto($pdo);

            if ($busca) {
                return Metodos::retornoAjax("Erro", "alert", "Objeto já existe no sistema.");
            } else {
                $cadastrar = $cad->cadastraObjeto($pdo);
                if (!$cadastrar) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $cadastrar);
                } else {
                    $cad->setIdObjeto($pdo->lastInsertId('gco_objeto_id_objeto_seq'));
                    if (Log::SalvaLogI('gco_objeto', $cad->getIdObjeto(), $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Pesquisa um objeto.
     * @return type array
     */

    public function pesquisarObjeto($session) {
        try {
            $tabela = "";
            if (empty($this->objeto)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $objDao = new DaoObjeto();

            $objDao->setObjeto($this->objeto);

            $busca = $objDao->pesquisarObjeto($pdo);
            if (!is_array($busca)) {
                return Metodos::retornoAjax("Erro", "console", $busca);
            } else {
                $tabela = '';
                foreach ($busca as $linha) {

                    $tabela .= '                             <tr>
                                                                    <td class="text-center">' . $linha["nm_objeto"] . '</td>
                                                                    <td class="text-center">';

                    if (!$session->vPComprasTecAdmin()) {
                        $tabela .= '                                      <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" disabled objeto="' . $linha["nm_objeto"] . '"
                                                                                value="' . $linha["id_objeto"] . '">
                                                                                <i class="ion-compose fa-lg text-primary" aria-hidden="true"></i>
                                                                            </button>';
                    } else {
                        $tabela .= '                                      <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" objeto="' . $linha["nm_objeto"] . '"
                                                                                value="' . $linha["id_objeto"] . '">
                                                                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                                            </button>';
                    }
                    if (!$session->vPComprasAdminTi()) {
                        $tabela .= '                                      <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" disabled value="' . $linha["id_objeto"] . '">
                                                                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>';
                    } else {
                        $tabela .= '                                      <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_objeto"] . '">
                                                                                <i class="ion-printer fa-lg text-danger" aria-hidden="true"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>';
                    }
                }
                return $tabela;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Lista todos os objetos.
     * @return type array
     */

    public function listarTodosObjetos($session) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $objDao = new DaoObjeto();

            $busca = $objDao->retornaTodosObjetos($pdo);
            if (!$busca) {
                return Metodos::retornoAjax("Erro", "console", $busca);
            } else {
                $tabela = '';
                foreach ($busca as $linha) {
                    $tabela .= '                             <tr>
                                                                    <td class="text-center">' . $linha["nm_objeto"] . '</td>
                                                                    <td class="text-center">';

                    if (!$session->vPComprasTecAdmin()) {
                        $tabela .= '                                      <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" disabled objeto="' . $linha["nm_objeto"] . '"
                                                                                value="' . $linha["id_objeto"] . '">
                                                                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                                            </button>';
                    } else {
                        $tabela .= '                                      <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" objeto="' . $linha["nm_objeto"] . '"
                                                                                value="' . $linha["id_objeto"] . '">
                                                                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                                            </button>';
                    }
                    if (!$session->vPComprasAdminTi()) {
                        $tabela .= '                                      <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" disabled value="' . $linha["id_objeto"] . '">
                                                                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>';
                    } else {
                        $tabela .= '                                      <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_objeto"] . '">
                                                                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>';
                    }
                }
                return $tabela;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Edita um objeto já cadastrado.
     */
    public function editarObjeto() {
        try {
            if (empty($this->idObjeto && $this->objeto)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $objtDao = new DaoObjeto();

                $objtDao->setObjeto($this->objeto);
                $objtDao->setIdObjeto($this->idObjeto);
                $busca = $objtDao->retornarObjeto($pdo);

                if (!$busca) {
                    return Metodos::retornoAjax("Erro", "alert", "Registro Não Encontrado");
                } else {
                    $verifica = $objtDao->verificarObjeto($pdo);
                    if ($verifica) {
                        return Metodos::retornoAjax("Erro", "alert", "Objeto já existe no sistema!");
                    } else {
                        $edita = $objtDao->editarObjeto($pdo);
                        if (!$edita) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", $edita);
                        } else {
                            if (Log::SalvaLogU('gco_objeto', $this->getIdObjeto(), $busca, $pdo)) {
                                $pdo->commit();
                                return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                            } else {
                                $pdo->rollBack();
                                return Metodos::retornoAjax('Erro', 'html', STR_ERROR);
                            }
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Desativa um objeto.
     * OBS: É desativado por que nenhum registro deve ser apagado
     */

    public function removerObjeto() {
        try {
            if (empty($this->idObjeto && $this->objeto)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $delObjeto = new DaoObjeto();
                $delObjeto->setIdObjeto($this->idObjeto);
                $delObjeto->setObjeto($this->objeto);
                $busca = $delObjeto->retornarObjeto($pdo);

                if (!$busca) {
                    return Metodos::retornoAjax("Erro", "alert", "Registro Não Encontrado");
                } else {
                    $desativar = $delObjeto->desativarObjeto($pdo);
                    if (!$desativar) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $desativar);
                    } else {
                        if (Log::SalvaLogU('gco_objeto', $this->getIdObjeto(), $busca, $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Lista todos ojetos desativados.
     */

    public function objetosDesativados() {
        try {
            //instaciando as classes
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoObjeto();

            $busca = $dao->objetosDesativados($pdo);
            if (!is_array($busca)) {
                return Metodos::retornoAjax("Erro", "console", $busca);
            } else {
                $tabela = "";
                foreach ($busca as $linha) {
                    $tabela .= '<tr id="tabela_objeto">
                                        <td class="text-center">' . $linha["nm_objeto"] . '</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" id_objeto="' . $linha["id_objeto"] . '" value="' . $linha["id_objeto"] . '">
                                                <i class="glyphicon glyphicon-off glyphicon-sm text-primary" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>';
                }
                return $tabela;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Ativa um objeto desativado.
     */

    public function ativarOjeto() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoObjeto();
            $dao->setIdObjeto($this->idObjeto);
            $busca = $dao->retornarObjeto($pdo);
            if (!is_array($busca)) {
                return Metodos::retornoAjax("Erro", "console", $busca);
            } else {
                $ativa = $dao->ativarObjeto($pdo);
                if ($ativa) {
                    if (Log::SalvaLogU('gco_objeto', $this->getIdObjeto(), $busca, $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax('Erro', 'console', $ativa);
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax('Erro', 'console', $ex->getMessage());
        }
    }

    /*
     * Lista objeto no select option.
     */
    public function retornarSelectOption() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $objDao = new DaoObjeto();

            $resultado = $objDao->retornaTodosObjetos($pdo);
            foreach ($resultado as $linha) {
                if ($this->idObjeto == $linha["id_objeto"]) {
                    echo '<option value="' . $linha["id_objeto"] . '" selected>' . $linha["nm_objeto"] . '</option>';
                } else {
                    echo '<option value="' . $linha["id_objeto"] . '">' . $linha["nm_objeto"] . '</option>';
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

}
