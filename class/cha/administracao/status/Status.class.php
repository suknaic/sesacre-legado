<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaStatus.class.php";

class Status {

    private $idStatus = null;
    private $nmStatus = null;
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

    function getIdStatus() {
        return $this->idStatus;
    }

    function getNmStatus() {
        return $this->nmStatus;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdStatus($idStatus) {
        $this->idStatus = $idStatus;
    }

    function setNmStatus($nmStatus) {
        $this->nmStatus = $nmStatus;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

    public function cadastrarStatus() {
        try {

            if ($this->nmStatus == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $sta = new DaoChaStatus();

            $sta->setNmStatus($this->getNmStatus());

            $busca = $sta->buscaStatus($sta, $pdo);

            if (!$busca) {
                //return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $sta->insert($sta, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $sta->setIdStatus($pdo->lastInsertId('cha_status_id_status_seq'));

            if (Log::SalvaLogI('cha_status', $sta->getIdStatus(), $pdo)) {
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

    public function editarStatus() {
        try {

            if ($this->nmStatus == "" || $this->idStatus == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $sta = new DaoChaStatus();

            $sta->setIdStatus($this->getIdStatus());
            $sta->setNmStatus($this->getNmStatus());

            $busca = $sta->buscaStatus($sta, $pdo);
            if ($busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $busca;
            }

            $busca = $sta->retornaStatus($pdo);

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $sta->update($sta, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('cha_status', $sta->getIdStatus(), $busca, $pdo)) {
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

    public function removerStatus() {
        try {

            if ($this->idStatus == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $sta = new DaoChaStatus();
            $sta->setIdStatus($this->getIdStatus());

            $busca = $sta->retornaStatus($pdo);

            if ($busca) {
                if (!Log::SalvaLogD('cha_status', $sta->getIdStatus(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
            } else {
                $retorno = retornoAjax("Erro", "alert", "Não Foi Possível Localizar o Status.");
                $pdo->rollBack();
                return $retorno;
            }

            $resultDao = $sta->delete($sta, $pdo);
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

    public function desativarStatus() {
        try {
            if ($this->idStatus == "") {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $sta = new DaoChaStatus();
            $sta->setIdStatus($this->getIdStatus());


            $busca = $sta->retornaStatus($pdo);

            $sta->verificaStatus($pdo);
            if (!$sta->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Não Foi Possível Localizar o Status.");
            }
            $resultDao = $sta->desativa($sta, $pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }
            if (Log::SalvaLogU('cha_status', $this->getIdStatus(), $busca, $pdo)) {
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

    public function ativarStatus() {
        try {
            if ($this->idStatus == "") {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $sta = new DaoChaStatus();
            $sta->setIdStatus($this->getIdStatus());


            $busca = $sta->retornaStatus($pdo);

            $sta->verificaStatus($pdo);
            if (!$sta->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Não Foi Possível Localizar o Status.");
            }
            $resultDao = $sta->ativa($sta, $pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }
            if (Log::SalvaLogU('cha_status', $this->getIdStatus(), $busca, $pdo)) {
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

    public function retornaTrStatus() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $sta = new DaoChaStatus();
            $sta->listaStatus($pdo);

            if (!$sta->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $sta->getMsgRetorno();
            } else {
                $this->sucesso = TRUE;
                foreach ($sta->getMsgRetorno() as $v) {
                    $this->msgRetorno .= '<tr>
                                            <td class="text-center">' . $v['nm_status'] . '</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-default btn-edit btn-xs"  title="Editar" nome="' . $v["nm_status"] . '" value="' . $v["id_status"] . '" >
                                                    <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $v["id_status"] . '">
                                                     <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                </button>';
                    if ($v['st_ativo'] == '1') {
                        $this->msgRetorno .= '
                                                <button type="button" class="btn btn-default btn-desativar btn-xs" title="Desativar" value="' . $v["id_status"] . '">
                                                    <i class="glyphicon glyphicon-off glyphicon-sm text-success" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>';
                    } else {
                        $this->msgRetorno .= '  <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" value="' . $v["id_status"] . '">
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

    public function retornaOptionStatus() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $status = new DaoChaStatus();
            $result = $status->retornaStatuss($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_status'] . "'>" . $v['nm_status'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
