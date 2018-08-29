<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesFuncao.class.php";

class Funcao {

    private $id_funcao = null;
    private $nm_funcao = null;
    private $st_ativo = null;

//*******************************************************************************
    function getId_funcao() {
        return $this->id_funcao;
    }

    function getNm_funcao() {
        return $this->nm_funcao;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_funcao($id_funcao) {
        $this->id_funcao = $id_funcao;
    }

    function setNm_funcao($nm_funcao) {
        $this->nm_funcao = $nm_funcao;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

//*******************************************************************************
    public function cadastrarFuncao() {
        try {

            if ($this->nm_funcao == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $funcao = new DaoSesFuncao();

            $funcao->setNm_funcao($this->nm_funcao);

            $busca = $funcao->buscaFuncaoPorNome($pdo);

            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }
            $result = $funcao->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $funcao->setId_funcao($pdo->lastInsertId('ses_funcao_id_funcao_seq'));

            if (Log::SalvaLogI('ses_funcao', $funcao->getId_funcao(), $pdo)) {
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

            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarFuncao() {
        try {
            if ($this->nm_funcao == "" || $this->id_funcao == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $funcao = new DaoSesFuncao();

            $funcao->setId_funcao($this->id_funcao);
            $funcao->setNm_funcao($this->nm_funcao);
            $busca = $funcao->buscaFuncaoPorNome($pdo);
            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            $busca = $funcao->retornaFuncao($pdo);

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $funcao->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('ses_funcao', $funcao->getId_funcao(), $busca, $pdo)) {
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

            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerFuncao() {
        try {
            if (empty($this->id_funcao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $funcao = new DaoSesFuncao();
            $funcao->setId_funcao($this->id_funcao);

            $busca = $funcao->retornaFuncao($pdo);

            if (!$busca) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            if (!Log::SalvaLogD('ses_funcao', $this->id_funcao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $result = $funcao->delete($pdo);
            if ($result === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Realizar a Exclusão dessa Escolaridade. Este registro está Vinculado a um Funcionário.");
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function desativarFuncao() {
        try {
            if (empty($this->id_funcao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $funcao = new DaoSesFuncao();
            $funcao->setId_funcao($this->id_funcao);

            $busca = $funcao->retornaFuncao($pdo);

            if ($busca === FALSE) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_funcao', $this->id_funcao, $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $result = $funcao->desativar($pdo);
            if ($result === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $result);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function ativarFuncao() {
        try {
            if (empty($this->id_funcao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $funcao = new DaoSesFuncao();
            $funcao->setId_funcao($this->id_funcao);

            $busca = $funcao->retornaFuncao($pdo);

            if ($busca == FALSE) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_funcao', $this->id_funcao, $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $result = $funcao->ativar($pdo);
            if ($result === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $result);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function retornaTrFuncao() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $funcao = new DaoSesFuncao();
            $result = $funcao->retornaFuncoes($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idFuncao = $v['id_funcao'];
                    $retorno .= '<tr>
                                    <td>' . $v['nm_funcao'] . '</td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" nome="' . $v['nm_funcao'] . '" value=' . $idFuncao . ' >
                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                                        </button> 
                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idFuncao . ' >
                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                        </button>';
                    if ($v['st_ativo'] == '0') {
                        $retorno .= "    <button type='button' class='btn btn-default btn-ativar btn-xs' title='Ativar' nome='" . $v['nm_funcao'] . "' value='" . $idFuncao . "' >
                                            <i class='ion-checkmark-round text-success' aria-hidden='true'></i>                                
                                        </button>";
                    } else {
                        $retorno .= "   <button type='button' class='btn btn-default btn-desativar btn-xs' title='Desativar' nome='" . $v['nm_funcao'] . "' value='" . $idFuncao  . "' >
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

    public function retornaOptionFuncao() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $lotacao = new DaoSesFuncao();
            $result = $lotacao->retornaFuncoesOption($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_funcao'] . "'>" . $v['nm_funcao'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }
}

?>
