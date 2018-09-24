<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesVinculo.class.php";

class Vinculo {

    private $idVinculo = null;
    private $nmVinculo = null;

    function getIdVinculo() {
        return $this->idVinculo;
    }

    function getNmVinculo() {
        return $this->nmVinculo;
    }

    function setIdVinculo($idVinculo) {
        $this->idVinculo = $idVinculo;
    }

    function setNmVinculo($nmVinculo) {
        $this->nmVinculo = $nmVinculo;
    }

    public function cadastrarVinculo() {
        try {

            if ($this->nmVinculo == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $vinculo = new DaoSesVinculo();

            $vinculo->setNmVinculo($this->nmVinculo);

            $busca = $vinculo->buscaVinculoPorNome($vinculo, $pdo);

            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $vinculo->insert($vinculo, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $vinculo->setIdVinculo($pdo->lastInsertId('ses_vinculo_id_vinculo_seq'));

            if (Log::SalvaLogI('ses_vinculo', $vinculo->getIdVinculo(), $pdo)) {
                $sucesso = true;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarVinculo() {
        try {

            if ($this->nmVinculo == "" || $this->idVinculo == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $vinculo = new DaoSesVinculo();

            $vinculo->setIdVinculo($this->idVinculo);
            $vinculo->setNmVinculo($this->nmVinculo);

            $busca = $vinculo->buscaVinculoPorNome($vinculo, $pdo);
            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            $busca = $vinculo->retornaVinculo($pdo);

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $vinculo->update($vinculo, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('ses_vinculo', $vinculo->getIdVinculo(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            } else {
                $sucesso = true;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerVinculo() {
        try {

            if ($this->idVinculo == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $vinculo = new DaoSesVinculo();
            $vinculo->setIdVinculo($this->idVinculo);

            $busca = $vinculo->retornaVinculo($pdo);

            if (!$busca) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogD('ses_vinculo', $vinculo->getIdVinculo(), $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $resultDao = $vinculo->delete($vinculo, $pdo);
            if ($resultDao === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", 'O Vínculo Não Pode ser Removido pois está vinculado a um Funcionário.');
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function desativarVinculo() {
        try {
            if (empty($this->idVinculo)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $vinculo = new DaoSesVinculo();
            $vinculo->setIdVinculo($this->idVinculo);

            $busca = $vinculo->retornaVinculo($pdo);
            if (!$busca) {
                $pdo->rollBack();
                return retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_vinculo', $vinculo->getIdVinculo(), $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $desativa = $vinculo->desativar($vinculo, $pdo);
            if ($desativa) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
            } else {
                $pdo->rollBack();
                return retornoAjax("Erro", "alert", $desativa);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function ativarVinculo() {
        try {
            if (empty($this->idVinculo)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $vinculo = new DaoSesVinculo();
            $vinculo->setIdVinculo($this->idVinculo);

            $busca = $vinculo->retornaVinculo($pdo);
            if (!$busca) {
                $pdo->rollBack();
                return retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_vinculo', $vinculo->getIdVinculo(), $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $desativa = $vinculo->ativar($pdo);
            if ($desativa) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
            } else {
                $pdo->rollBack();
                return retornoAjax("Erro", "alert", $desativa);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function retornaTrVinculos() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $vinculo = new DaoSesVinculo();

            $result = $vinculo->retornaVinculos($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idVinculo = $v['id_vinculo'];
                    $retorno .= '<tr>
                                    <td>' . $v['nm_vinculo'] . '</td>                          
                                    <td style="text-align: center;">                           
                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" nome="' . $v['nm_vinculo'] . '" value=' . $idVinculo . ' >
                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                                        </button> 
                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idVinculo . ' >
                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                        </button>';
                    if ($v['st_ativo'] == '0') {
                        $retorno .= "    <button type='button' class='btn btn-default btn-ativar btn-xs' title='Ativar' nome='" . $v['nm_vinculo'] . "' value='" . $idVinculo . "' >
                                            <i class='ion-checkmark-round text-success' aria-hidden='true'></i>                                
                                        </button>";
                    } else {
                        $retorno .= "    <button type='button' class='btn btn-default btn-desativar btn-xs' title='Desativar' nome='" . $v['nm_vinculo'] . "' value='" . $idVinculo . "' >
                                            <i class='ion-close-round text-danger' aria-hidden='true'></i>                                
                                        </button>";
                    }
                    $retorno .= '   </td>
                                </tr>';
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionVinculo($id) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $vinculo = new DaoSesVinculo();
            $result = $vinculo->retornaVinculos($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($v['st_ativo'] == '1') {
                        if ($v['id_vinculo'] == $id) {
                            $retorno .= "<option selected value = '" . $v['id_vinculo'] . "'>" . $v['nm_vinculo'] . "</option>";
                        } else {
                            $retorno .= "<option value = '" . $v['id_vinculo'] . "'>" . $v['nm_vinculo'] . "</option>";
                        }
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
