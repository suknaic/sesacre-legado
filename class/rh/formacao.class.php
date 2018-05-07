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

            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já Existe Formacao dessa Escolaridade.");
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
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
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
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
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
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerFormacao() {
        try {
            if ($this->id_formacao == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $formacao = new DaoSesFormacao();
            $formacao->setId_escolaridade_formacao($this->id_formacao);

            $busca = $formacao->retornaFormacao($pdo);

            if ($busca) {
                if (!Log::SalvaLogD('ses_escolaridade_formacao', $this->id_formacao, $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
            } else {
                $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar a Formacao.");
                $pdo->rollBack();
                return $retorno;
            }

            $result = $formacao->delete($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
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

    public function retornaTrFormacao($nome, $escolaridade = null) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $filtro = "";
            $formacao = new DaoSesFormacao();
             //*****************************************************************
            $filter = array();
            if(!empty($nome)){
                $filter[] = "f.nm_escolaridade_formacao ilike '$nome%'";
            }
            if(!empty($escolaridade)){
                $filter[] = "e.id_escolaridade = $escolaridade";
            }
            if(count($filter)>0){
                $filtro = " and " . implode(' and ', $filter) ;
            }
            //******************************************************************
            $result = $formacao->retornaFormacoes($pdo, $filtro);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idFormacao = $v['id_escolaridade_formacao'];
                    $retorno .= "<tr>";
                    $retorno .=   "<td>" . $v['nm_escolaridade_formacao'] . "</td>"
                                . "<td>" . $v['nm_escolaridade'] . "</td>"
                                . '<td style="text-align: center;">'
                                    . '<button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" escolaridade="' . $v['id_escolaridade'] . '" nome="' . $v['nm_escolaridade_formacao'] . '" value=' . $idFormacao . ' >
                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                                       </button> '
                                    . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idFormacao . ' >
                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                       </button>'
                                . '</td>'
                               . "</tr>";
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

}

?>
