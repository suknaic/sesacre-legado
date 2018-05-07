<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaCondicao.class.php";

class Condicao {

    private $idCondicao = null;
    private $nmCondicao = null;
    private $stAtivo = null;

    /* --------------------------------------------------------------- */
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    /* --------------------------------------------------------------- */

    function getIdCondicao() {
        return $this->idCondicao;
    }

    function getNmCondicao() {
        return $this->nmCondicao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdCondicao($idCondicao) {
        $this->idCondicao = $idCondicao;
    }

    function setNmCondicao($nmCondicao) {
        $this->nmCondicao = $nmCondicao;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

    public function cadastrarCondicao() {
        try {

            if ($this->nmCondicao == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $con = new DaoChaCondicao();

            $con->setNmCondicao($this->getNmCondicao());

            $busca = $con->buscaCondicao($con, $pdo);

            if (!$busca) {
                //return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $con->insert($con, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $con->setIdCondicao($pdo->lastInsertId('cha_condicao_id_condicao_seq'));

            if (Log::SalvaLogI('cha_condicao', $con->getIdCondicao(), $pdo)) {
                $sucesso = true;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarCondicao() {
        try {

            if ($this->nmCondicao == "" || $this->idCondicao == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $con = new DaoChaCondicao();

            $con->setIdCondicao($this->getIdCondicao());
            $con->setNmCondicao($this->getNmCondicao());

            $busca = $con->buscaCondicao($con, $pdo);
            if ($busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $busca;
            }

            $busca = $con->retornaCondicao($pdo);

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $con->update($con, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('cha_condicao', $con->getIdCondicao(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            } else {
                $sucesso = true;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "alert", STR_EDICAO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerCondicao() {
        try {

            if ($this->idCondicao == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $con = new DaoChaCondicao();
            $con->setIdCondicao($this->getIdCondicao());

            $busca = $con->retornaCondicao($pdo);

            if ($busca) {
                if (!Log::SalvaLogD('cha_condicao', $con->getIdCondicao(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
            } else {
                $retorno = retornoAjax("Erro", "alert", "Não Foi Possível Localizar a Condição.");
                $pdo->rollBack();
                return $retorno;
            }

            $resultDao = $con->delete($con, $pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function desativarCondicao() {
        try {
            if ($this->idCondicao == "") {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $con = new DaoChaCondicao();
            $con->setIdCondicao($this->getIdCondicao());


            $busca = $con->retornaCondicao($pdo);

            $con->verificaCondicao($pdo);
            if (!$con->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Não Foi Possível Localizar a Condição.");
            }
            $resultDao = $con->desativa($con, $pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }
            if (Log::SalvaLogU('cha_condicao', $this->getIdCondicao(), $busca, $pdo)) {
                $sucesso = true;
            } else {
                $sucesso = FALSE;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function ativarCondicao() {
        try {
            if ($this->idCondicao == "") {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $con = new DaoChaCondicao();
            $con->setIdCondicao($this->getIdCondicao());


            $busca = $con->retornaCondicao($pdo);

            $con->verificaCondicao($pdo);
            if (!$con->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Não Foi Possível Localizar a Condição.");
            }
            $resultDao = $con->ativa($con, $pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }
            if (Log::SalvaLogU('cha_condicao', $this->getIdCondicao(), $busca, $pdo)) {
                $sucesso = true;
            } else {
                $sucesso = FALSE;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTrCondicao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $con = new DaoChaCondicao();
            $con->listaCondicao($pdo);

            if (!$con->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $con->getMsgRetorno();
            } else {
                $this->sucesso = TRUE;
                foreach ($con->getMsgRetorno() as $v) {
                    $this->msgRetorno .= '<tr>
                                            <td class="text-center">' . $v['nm_condicao'] . '</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-default btn-edit btn-xs"  title="Editar" nome="' . $v["nm_condicao"] . '" value="' . $v["id_condicao"] . '" >
                                                    <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $v["id_condicao"] . '">
                                                     <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                </button>';
                    if ($v['st_ativo'] == '1') {
                        $this->msgRetorno .= '
                                                <button type="button" class="btn btn-default btn-desativar btn-xs" title="Desativar" value="' . $v["id_condicao"] . '">
                                                    <i class="glyphicon glyphicon-off glyphicon-sm text-success" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>';
                    } else {
                        $this->msgRetorno .= '  <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" value="' . $v["id_condicao"] . '">
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

    public function retornaOptionCondicao() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $condicao = new DaoChaCondicao();
            $result = $condicao->retornaCondicoes($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_condicao'] . "'>" . $v['nm_condicao'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
