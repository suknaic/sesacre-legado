<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/usuario/DaoUsuario.class.php";

class Usuario {

    private $idPerfilPessoa = null;
    private $idUsuario = null;
    private $idPermissao = null;
    private $idPerfil = null;

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getIdPermissao() {
        return $this->idPermissao;
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }

    function getIdPerfilPessoa() {
        return $this->idPerfilPessoa;
    }

    function setIdPerfilPessoa($idPerfilPessoa) {
        $this->idPerfilPessoa = $idPerfilPessoa;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    function setIdPermissao($idPermissao) {
        $this->idPermissao = $idPermissao;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    /*
     * Cadastra usuário.
     */

    public function cadastrarUsuario() {
        try {
            if (empty($this->idUsuario && $this->idPermissao) == true) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $dao = new DaoUsuario();

                //setando o campo para a extensão
                $dao->setIdUsuario($this->idUsuario);
                $dao->setIdPermissao($this->idPermissao);

                $cadastrar = $dao->cadastrarRegistroUsuario($pdo);
                if (!$cadastrar) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                } else {
                    $dao->setIdPerfil($pdo->lastInsertId('ses_perfil_pessoa_id_perfil_pessoa_seq'));
                    if (Log::SalvaLogI('ses_perfil_pessoa', $dao->getIdPerfil(), $pdo)) {
                        $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                        $pdo->commit();
                        return $retorno;
                    } else {
                        $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /*
     * Lista usuário.
     */

    public function listarUsuarios() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $dao = new DaoUsuario();

            $perfis = "(" . PERFIL_COMPRAS_USUARIO . "," . PERFIL_COMPRAS_TECNICO . "," . PERFIL_COMPRAS_ADMINISTRADOR . ")";
            $busca = $dao->listarRegistroUsuario($pdo, $perfis);
            if (is_array($busca) == false) {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            } else {
                $tabela = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Usuários</h3>
                        </div>
                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tabela_usuario" class="table table-striped table-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Usuário</th>
                                                    <th class="text-capitalize text-center">Permissão</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($busca as $linha) {
                    $tabela .= '      
                                                <tr>
                                                    <td class="text-center">' . $linha["nm_pessoa"] . '</td>
                                                    <td class="text-center">' . substr($linha["nm_perfil"], 14) . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" perfil="' . $linha['id_perfil'] . '" usuario="' . $linha["id_pessoa"] . '"
                                                            value="' . $linha["id_perfil_pessoa"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_perfil_pessoa"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
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
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($ex));
        }
    }

    /*
     * Edita o registro de um usuário.
     */

    public function editarRegistroUsuario() {
        try {
            if (empty($this->idUsuario) == true && empty($this->idPermissao) == true) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $dao = new DaoUsuario();

                $dao->setIdUsuario($this->idUsuario);
                $dao->setIdPermissao($this->idPermissao);
                $dao->setIdPerfilPessoa($this->idPerfilPessoa);
                $busca = $dao->retornaRegistroUsuario($pdo);

                $verifica = $dao->verificaRegistroUsuario($pdo);
                if ($verifica) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Registro já existe no sistema.");
                    return $retorno;
                } else {
                    $edita = $dao->editarRegistroUsuario($pdo);
                    if (!$edita) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $edita);
                        $pdo->rollBack();
                        return $retorno;
                    } else {
                        if (Log::SalvaLogU('ses_perfil_pessoa', $dao->getIdPerfilPessoa(), $busca, $pdo)) {
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
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($ex));
        }
    }

    /*
     * Exclui o registro de um usário.
     */

    public function excluirRegistroUsuario() {
        try {
            if (empty($this->idPerfilPessoa) == true) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $dao = new DaoUsuario();
                $dao->setIdPerfilPessoa($this->idPerfilPessoa);

                $desativa = $dao->deletarRegistroUsuario($pdo);
                if (!$desativa) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", $desativa);
                    $pdo->rollBack();
                    return $retorno;
                } else {
                    if (Log::SalvaLogD('ses_perfil_pessoa', $dao->getIdPerfilPessoa(), $pdo)) {
                        $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                        $pdo->commit();
                        return $retorno;
                    } else {
                        $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($ex));
        }
    }

    /*
     * Lista todos os técnicos no select option.
     */

    public function listarTecnicos() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoUsuario();

            $resultado = $dao->listarTecnicos($pdo);
            if (is_array($resultado) == false) {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultado);
                return $retorno;
            } else {
                foreach ($resultado as $linha) {
                    echo '<option value="' . $linha["id_pessoa"] . '">' . $linha["nm_pessoa"] . '</option>';
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    /*
     * Lista todos os perfis do GCON no select option.
     */

    public function listarPerfis() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $dao = new DaoUsuario();

            $perfis = "(" . PERFIL_COMPRAS_USUARIO . "," . PERFIL_COMPRAS_TECNICO . "," . PERFIL_COMPRAS_ADMINISTRADOR . ")";
            $resultado = $dao->listarPerfis($pdo, $perfis);
            if (is_array($resultado) == false) {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultado);
                $pdo->rollBack();
                return $retorno;
            } else {
                foreach ($resultado as $linha) {
                    echo '<option value="' . $linha["id_perfil"] . '">' . trim(substr($linha["nm_perfil"], 14)) . '</option>';
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

}
