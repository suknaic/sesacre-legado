<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/perfil_pessoa/PerfilPessoa.class.php";

class Usuario {

    private $idPerfilPessoa = null;
    private $idPessoa = null;
    private $idPerfil = null;

    function getIdPerfilPessoa() {
        return $this->idPerfilPessoa;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }

    function setIdPerfilPessoa($idPerfilPessoa) {
        $this->idPerfilPessoa = $idPerfilPessoa;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    /************************************** Cadastra usuário **********************************/
    public function inserirPerfilUsuarioGCON() {
        try {
            if (empty($this->idPessoa && $this->idPerfil)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $perfilPessoa = new PerfilPessoa();
                $perfilPessoa->setIdPerfil($this->idPerfil);
                $perfilPessoa->setIdPessoa($this->idPessoa);

                $inseri = $perfilPessoa->incluirPessoaPerfil($pdo);
                if ($inseri) {
                    $pdo->commit();
                    return Metodos::retornoAjax('ok', 'html', STR_CADASTRO_SUCESSO);
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax('Erro', 'console', $inseri);
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    /*********************************************************************************************/

    /******************************************* Lista todos os usuários do GCON ***************************************/
    public function listarUsuariosGCON() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $perfilPessoa = new PerfilPessoa();
            
            $perfilPessoa->retornaPessoasPorINPerfil(PERFIL_COMPRAS_ADMINISTRADOR . "," . PERFIL_COMPRAS_TECNICO . "," . PERFIL_COMPRAS_USUARIO, $pdo);
            $tabela = "";
            if (!$perfilPessoa->Sucesso()) {
                return "";
            } else {
                foreach ($perfilPessoa->getMsgRetorno() as $linha) {
                    $tabela .= '      
                                <tr>
                                    <td class="text-center">' . $linha["nm_pessoa"] . '</td>
                                    <td class="text-center">' . substr($linha["nm_perfil"], 15) . '</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" Pessoa="'.$linha['id_pessoa'] . '" Perfil="'.$linha['id_perfil'].'">
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
    /******************************************************************************************************/
    
    /************************************ Exclui o registro de um usário **********************************/
    public function deletarPerfilUsuarioGCON() {
        try {
            if (empty($this->idPerfil && $this->idPessoa)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $perfilPessoa = new PerfilPessoa();
                $perfilPessoa->setIdPerfil($this->idPerfil);
                $perfilPessoa->setIdPessoa($this->idPessoa);

                $deleta = $perfilPessoa->removerPerfilPessoa($pdo);
                if ($deleta) {
                    $pdo->commit();
                    return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($ex));
        }
    }
    /*******************************************************************************************************/
    
    /********************************* Lista todos os técnicos no select option ****************************/
    public function listarTecnicos() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoUsuario();

            $resultado = $dao->listarTecnicos($pdo);
            if (!is_array($resultado)) {
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
    /*******************************************************************************************************/
    
    /*************************************** Perfis GCON ***************************************/
    private function carregarPerfisGCON() {
        try {
            $perfis = array(
                PERFIL_COMPRAS_ADMINISTRADOR => "Administrador",
                PERFIL_COMPRAS_TECNICO => "Técnico",
                PERFIL_COMPRAS_USUARIO => "Usuário"
            );
            return $perfis;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function retornarSelectOptionPerfisGCON() {
        try {
            $retorno = "";
            $perfis = $this->carregarPerfisGCON();
            foreach ($perfis as $key => $valor) {
                $retorno .= "<option value='" . $key . "'>" . $valor . "</option>";
            }
            return $retorno;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    /*******************************************************************************************/

}
