<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/perfil_pessoa/PerfilPessoa.class.php";

/**
 * Description of Usuario
 *
 * @author elivelton
 */
class PerfilRH {

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

    public function inserirPerfilPessoaRH() {
        try {

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
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarPessoaPerfilRH() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $perfilPessoa = new PerfilPessoa();
            
            $perfilPessoa->retornaPessoasPorINPerfil(PERFIL_RH_USUARIO . "," . PERFIL_RH . "," . PERFIL_RH_ZEUS, $pdo);
            $tabela = "";
            if (!$perfilPessoa->Sucesso()) {
                return "";
            } else {
                foreach ($perfilPessoa->getMsgRetorno() as $linhas) {
                    $tabela .= '      
                                <tr>
                                    <td class="text-center">' . $linhas["nm_pessoa"] . '</td>
                                    <td class="text-center">' . $linhas["nm_perfil"] . '</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" Pessoa="'.$linhas['id_pessoa'] . '" Perfil="'.$linhas['id_perfil'].'" perfilPessoa="Pessoa:' . $linhas["nm_pessoa"] . ' Perfil: '.$linhas['nm_perfil'] .'">
                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>';
                }
                return $tabela;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    /*
     * Deleta o perfil de uma pessoa do RH
     */
    public function deletarPerfilPessoaRH() {
        try {

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $perfilPessoa = new PerfilPessoa();
            $perfilPessoa->setIdPerfil($this->idPerfil);
            $perfilPessoa->setIdPessoa($this->idPessoa);

            $deleta = $perfilPessoa->removerPerfilPessoa($pdo);
            if ($deleta) {
                $pdo->commit();
                return Metodos::retornoAjax('ok', 'html', STR_REMOCAO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'console', $deleta);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /* ************************************** Perfis RH ************************************** */

    /**
     * Carrega os perfis do RH
     * Retorna um Array.
     */
    private function carregarPerfisRH() {
        try {
            $perfis = array(
                PERFIL_RH_ZEUS => "RH Zeus",
                PERFIL_RH_USUARIO => "RH Usuário",
                PERFIL_RH => "RH Administrador"
            );
            return $perfis;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /*
     * Retorna os perfis do RH no select option
     */

    public function retornarSelectOptionPerfisRH() {
        try {
            $retorno = "";
            $perfis = $this->carregarPerfisRH();
            foreach ($perfis as $key => $valor) {
                $retorno .= "<option value='" . $key . "'>" . $valor . "</option>";
            }

            return $retorno;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /* ***************************************************************************************** */
}
