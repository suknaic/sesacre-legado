<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaCategoriaPrincipal.class.php";

class Principal {

    private $idCategoriaPrincipal = null;
    private $nmCategoriaPrincipal = null;
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

    function getIdCategoriaPrincipal() {
        return $this->idCategoriaPrincipal;
    }

    function getNmCategoriaPrincipal() {
        return $this->nmCategoriaPrincipal;
    }

    function setIdCategoriaPrincipal($idCategoriaPrincipal) {
        $this->idCategoriaPrincipal = $idCategoriaPrincipal;
    }

    function setNmCategoriaPrincipal($nmCategoriaPrincipal) {
        $this->nmCategoriaPrincipal = $nmCategoriaPrincipal;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

    public function cadastrarPrincipal() {
        try {

            if ($this->nmCategoriaPrincipal == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $prin = new DaoChaCategoriaPrincipal();

            $prin->setNm_categoria_principal($this->getNmCategoriaPrincipal());

            $busca = $prin->buscaPrincipal($prin, $pdo);

            if (!$busca) {
                //return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $prin->insert($prin, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $prin->setId_categoria_principal($pdo->lastInsertId('cha_categoria_principal_id_categoria_principal_seq'));

            if (Log::SalvaLogI('cha_categoria_principal', $prin->getId_categoria_principal(), $pdo)) {
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

    public function editarPrincipal() {
        try {

            if ($this->nmCategoriaPrincipal == "" || $this->idCategoriaPrincipal == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $prin = new DaoChaCategoriaPrincipal();

            $prin->setId_categoria_principal($this->getIdCategoriaPrincipal());
            $prin->setNm_categoria_principal($this->getNmCategoriaPrincipal());

            $busca = $prin->buscaPrincipal($prin, $pdo);
            if ($busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $busca;
            }

            $busca = $prin->retornaPrincipal($pdo);

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $prin->update($prin, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('cha_categoria_principal', $prin->getId_categoria_principal(), $busca, $pdo)) {
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

    public function removerPrincipal() {
        try {

            if ($this->idCategoriaPrincipal == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $prin = new DaoChaCategoriaPrincipal();
            $prin->setId_categoria_principal($this->getIdCategoriaPrincipal());

            $busca = $prin->retornaPrincipal($pdo);

            if ($busca) {
                if (!Log::SalvaLogD('cha_categoria_principal', $prin->getId_categoria_principal(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
            } else {
                $retorno = retornoAjax("Erro", "alert", "Não Foi Possível Localizar a Categoria Principal.");
                $pdo->rollBack();
                return $retorno;
            }

            $resultDao = $prin->delete($prin, $pdo);
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
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, Contate o Administrador do Sistema.");
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function desativarPrincipal() {
        try {
            if ($this->idCategoriaPrincipal == "") {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $prin = new DaoChaCategoriaPrincipal();
            $prin->setId_categoria_principal($this->getIdCategoriaPrincipal());


            $busca = $prin->retornaPrincipal($pdo);

            $prin->verificaCategoriaPrincipal($pdo);
            if (!$prin->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Não Foi Possível Localizar a Categoria Principal.");
            }
            $resultDao = $prin->desativa($prin, $pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }
            if (Log::SalvaLogU('cha_categoria_principal', $this->getIdCategoriaPrincipal(), $busca, $pdo)) {
                $sucesso = true;
            } else {
                $sucesso = FALSE;
            }



            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, Contate o Administrador do Sistema.");
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function ativarPrincipal() {
        try {
            if ($this->idCategoriaPrincipal == "") {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $prin = new DaoChaCategoriaPrincipal();
            $prin->setId_categoria_principal($this->getIdCategoriaPrincipal());


            $busca = $prin->retornaPrincipal($pdo);

            $prin->verificaCategoriaPrincipal($pdo);
            if (!$prin->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Não Foi Possível Localizar a Categoria Principal.");
            }
            $resultDao = $prin->ativa($prin, $pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }
            if (Log::SalvaLogU('cha_categoria_principal', $this->getIdCategoriaPrincipal(), $busca, $pdo)) {
                $sucesso = true;
            } else {
                $sucesso = FALSE;
            }



            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, Contate o Administrador do Sistema.");
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTrPrincipal() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $prin = new DaoChaCategoriaPrincipal();
            $prin->listaPrincipal($pdo);

            if (!$prin->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $prin->getMsgRetorno();
            } else {
                $this->sucesso = TRUE;
                foreach ($prin->getMsgRetorno() as $v) {
                    $this->msgRetorno .= '<tr>
                                            <td class="text-center">' . $v['nm_categoria_principal'] . '</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-default btn-edit btn-xs"  title="Editar" nome="' . $v["nm_categoria_principal"] . '" value="' . $v["id_categoria_principal"] . '" >
                                                    <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $v["id_categoria_principal"] . '">
                                                     <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                </button>';
                    if ($v['st_ativo'] == '1') {
                        $this->msgRetorno .= '
                                                <button type="button" class="btn btn-default btn-desativar btn-xs" title="Desativar" value="' . $v["id_categoria_principal"] . '">
                                                    <i class="glyphicon glyphicon-off glyphicon-sm text-success" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>';
                    } else {
                        $this->msgRetorno .= '  <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" value="' . $v["id_categoria_principal"] . '">
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

    public function retornaOptionPrincipal() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $principal = new DaoChaCategoriaPrincipal();
            $result = $principal->retornaPrincipaisSelect($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_categoria_principal'] . "'>" . $v['nm_categoria_principal'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
