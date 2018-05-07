<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoUsuarioContrato.class.php";

class UsuarioContrato {

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

    public function cadastrarUsuario() {

        try {
            //Este método verifica se o campo existe,se está vazio e se diferente de 0
            if (empty($this->idUsuario && $this->idPermissao) == true) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $dao = new DaoUsuarioContrato();

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
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function listarUsuarios() {

        try {
            //instanciando as classes
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoUsuarioContrato();

            //constante com todos os perfis 
            $perfis = "(" . PERFIL_CONTRATOS_USUARIO . "," . PERFIL_CONTRATOS_TECNICO . "," . PERFIL_CONTRATOS_ADMINISTRADOR . ")";
            //metodo para listar a unidade
            $busca = $dao->listarRegistroUsuario($pdo, $perfis);
            if (is_array($busca) == false) {
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            } else {
                $tabela = '';
                foreach ($busca as $linha) {
                    $tabela .= '<tr>
                                    <td class="text-center">' . $linha["nm_pessoa"] . '</td>
                                    <td class="text-center">' . $linha["nm_perfil"] . '</td>
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

                return $tabela;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($ex));
        }
    }

    public function editarRegistroUsuario() {

        try {
            //verifica se o campos está vazio
            if (empty($this->idUsuario) == true && empty($this->idPermissao) == true && empty($this->idPerfilPessoa) == true) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            //instanciando as classes e fazendo conexao BD
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoUsuarioContrato();

            $dao->setIdUsuario($this->idUsuario);
            $dao->setIdPermissao($this->idPermissao);
            $dao->setIdPerfilPessoa($this->idPerfilPessoa);
            $busca = $dao->retornaRegistroUsuario($pdo);

            //verifica se a unidade já existe no sistema
            $verifica = $dao->verificaRegistroUsuario($pdo);
            if ($verifica) {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Registro já existe no sistema.");
                return $retorno;
            }

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
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($ex));
        }
    }

    public function excluirRegistroUsuario() {
        try {
            //verifica se o campo está vazio
            if (empty($this->idPerfilPessoa) == true) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //instanciando as classes e fazendo conexao BD
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoUsuarioContrato();
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
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($ex));
        }
    }

    public function listarTecnicos($id = 0) {
        try {

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoUsuarioContrato();

            $resultado = $dao->listarTecnicos($pdo);
            if (is_array($resultado) == false) {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultado);
                return $retorno;
            } else {
                foreach ($resultado as $linha) {
                    if (!empty($id) && $id == $linha["id_pessoa"]) {
                        echo '<option value="' . $linha["id_pessoa"] . '" selected>' . $linha["nm_pessoa"] . '</option>';
                    } else {
                        echo '<option value="' . $linha["id_pessoa"] . '">' . $linha["nm_pessoa"] . '</option>';
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function listarPerfis($id = 0) {
        try {

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $dao = new DaoUsuarioContrato();

            $perfis = "(" . PERFIL_CONTRATOS_USUARIO . "," . PERFIL_CONTRATOS_TECNICO . "," . PERFIL_CONTRATOS_ADMINISTRADOR . ")";

            $resultado = $dao->listarPerfis($pdo, $perfis);
            if (is_array($resultado) == false) {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultado);
                $pdo->rollBack();
                return $retorno;
            } else {
                foreach ($resultado as $linha) {
                    if(!empty($id) && $id == $linha["id_perfil"]){
                         echo '<option value="' . $linha["id_perfil"] . '" selected>' . trim($linha["nm_perfil"]) . '</option>';
                    }else{
                         echo '<option value="' . $linha["id_perfil"] . '">' . trim($linha["nm_perfil"]) . '</option>';
                    }
                   
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

}
