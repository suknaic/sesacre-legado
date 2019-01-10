<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesFormacao.class.php";

class Formacao {

    private $id_formacao = null;
    private $nm_formacao = null;
    private $id_escolaridade = null;
    private $st_ativo = null;

//*******************************************************************************
    function getId_escolaridade() {
        return $this->id_escolaridade;
    }

    function setId_escolaridade($id_escolaridade) {
        $this->id_escolaridade = $id_escolaridade;
    }

    function getNm_formacao() {
        return $this->nm_formacao;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_formacao($id_formacao) {
        $this->id_formacao = $id_formacao;
    }

    function setNm_formacao($nm_formacao) {
        $this->nm_formacao = $nm_formacao;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

//*******************************************************************************
    public function cadastrarFormacao() {
        try {

            if ($this->nm_formacao == "" || $this->id_escolaridade == 0 || $this->id_escolaridade == null) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $formacao = new DaoSesFormacao();

            $formacao->setNm_escolaridade_formacao($this->nm_formacao);
            $formacao->setId_escolaridade($this->id_escolaridade);
            $busca = $formacao->buscaFormacaoPorNome($pdo);

            if ($this->id_escolaridade == 2) {
                return Metodos::retornoAjax("Erro", "alert", "Não é Permitido o Cadastro de Curso com Escolaridade Ensino Fundamental.");
            }

            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $formacao->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $formacao->setId_escolaridade_formacao($pdo->lastInsertId('ses_escolaridade_formacao_id_escolaridade_formacao_seq'));

            if (Log::SalvaLogI('ses_escolaridade_formacao', $formacao->getId_escolaridade_formacao(), $pdo)) {
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

    public function editarFormacao() {
        try {
            if ($this->nm_formacao == "" || $this->id_formacao == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $formacao = new DaoSesFormacao();

            $formacao->setId_escolaridade_formacao($this->id_formacao);
            $formacao->setNm_escolaridade_formacao($this->nm_formacao);
            $formacao->setId_escolaridade($this->id_escolaridade);

            // *** Bloqueio para permitir a edição de formação com escolaridade ensino fundamental ***
            if ($this->id_escolaridade == 2) {
                return Metodos::retornoAjax("Erro", "alert", "Não é Permitido realizar a Edição de Curso com Escolaridade de Ensino Fundamental.");
            }
            //****************************************************************************************

            $busca = $formacao->buscaFormacaoPorNome($pdo);
            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já Existe Formacao dessa Escolaridade.");
                $pdo->rollBack();
                return $retorno;
            }
            $busca = $formacao->retornaFormacao($pdo);
            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $formacao->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('ses_escolaridade_formacao', $formacao->getId_escolaridade_formacao(), $busca, $pdo)) {
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

    public function removerFormacao() {
        try {
            if (empty($this->id_formacao)) {
                return Metodos::retornoAjax("Erro", "console", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $formacao = new DaoSesFormacao();
            $formacao->setId_escolaridade_formacao($this->id_formacao);

            $busca = $formacao->retornaFormacao($pdo);

            if ($busca === FALSE) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogD('ses_escolaridade_formacao', $this->id_formacao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $result = $formacao->delete($pdo);
            if ($result === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            }else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Realizar a Exclusão desse Curso. Este registro está Vinculado a uma Pessoa.");
            }

            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function desativarFormacao() {
        try {
            if (empty($this->id_formacao)) {
                return Metodos::retornoAjax("Erro", "console", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $formacao = new DaoSesFormacao();
            $formacao->setId_escolaridade_formacao($this->id_formacao);

            $busca = $formacao->retornaFormacao($pdo);

            if ($busca === FALSE) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_escolaridade_formacao', $this->id_formacao, $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $result = $formacao->desativar($pdo);
            if ($result === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
            }else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function ativarFormacao() {
        try {
            if (empty($this->id_formacao)) {
                return Metodos::retornoAjax("Erro", "console", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $formacao = new DaoSesFormacao();
            $formacao->setId_escolaridade_formacao($this->id_formacao);

            $busca = $formacao->retornaFormacao($pdo);

            if ($busca === FALSE) {
                $pdo->rollBack();
                return Metodos::retornoAjax('Erro', 'alert', STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_escolaridade_formacao', $this->id_formacao, $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $result = $formacao->ativar($pdo);
            if ($result === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
            }else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function retornaTrFormacao($nome, $escolaridade = null) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $filtro = "";
            $formacao = new DaoSesFormacao();
            //*****************************************************************
            $filter = array();
            if (!empty($nome)) {
                $filter[] = "f.nm_escolaridade_formacao ilike '$nome%'";
            }
            if (!empty($escolaridade)) {
                $filter[] = "e.id_escolaridade = $escolaridade";
            }
            if (count($filter) > 0) {
                $filtro = " and " . implode(' and ', $filter);
            }
            //******************************************************************
            $result = $formacao->retornaFormacoes($pdo, $filtro);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idFormacao = $v['id_escolaridade_formacao'];
                    $retorno .= "<tr>
                                    <td>" . $v['nm_escolaridade_formacao'] . "</td>
                                    <td>" . $v['nm_escolaridade'] . "</td>
                                    <td style='text-align: center;'>
                                        <button type='button' class='btn btn-default btn-edit btn-xs' title='Editar' escolaridade='" . $v['id_escolaridade'] . "' nome='" . $v['nm_escolaridade_formacao'] . "' value='" . $idFormacao . "' >
                                            <i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>                                
                                        </button> 
                                        <button type='button' class='btn btn-default btn-remover btn-xs' title='Remover' value='" . $idFormacao . "' >
                                            <i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>
                                       </button>";
                    if ($v['st_ativo'] == '0') {
                        $retorno .= "    <button type='button' class='btn btn-default btn-ativar btn-xs' title='Ativar' nome='" . $v['nm_escolaridade_formacao'] . "' value='" . $idFormacao . "' >
                                            <i class='ion-checkmark-round text-success' aria-hidden='true'></i>                                
                                        </button>";
                    } else {
                        $retorno .= "   <button type='button' class='btn btn-default btn-desativar btn-xs' title='Desativar' nome='" . $v['nm_escolaridade_formacao'] . "' value='" . $idFormacao  . "' >
                                            <i class='ion-close-round text-danger' aria-hidden='true'></i>                                
                                        </button>";
                    }
                    $retorno .= "   </td>
                                 </tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionFormacao() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $lotacao = new DaoSesFormacao();
            $result = $lotacao->retornaFuncoes($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_formacao'] . "'>" . $v['nm_formacao'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornarFormacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $formacao = new DaoSesFormacao();
            $formacao->setId_escolaridade_formacao($this->id_formacao);

            $verifica = $formacao->retornaFormacao($pdo);
            if ($verifica === FALSE) {
                return '';
            } else {
                return $verifica;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}

?>
