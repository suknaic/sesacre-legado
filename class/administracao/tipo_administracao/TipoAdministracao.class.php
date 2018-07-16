<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinTipoAdministracao.class.php";

class TipoAdministracao {
    
    private $idTipoAdministracao = null;
    private $nmTipoadministracao = null;
    
    function getIdTipoAdministracao() {
        return $this->idTipoAdministracao;
    }

    function getNmTipoadministracao() {
        return $this->nmTipoadministracao;
    }

    function setIdTipoAdministracao($idTipoAdministracao) {
        $this->idTipoAdministracao = $idTipoAdministracao;
        return $this;
    }

    function setNmTipoadministracao($nmTipoadministracao) {
        $this->nmTipoadministracao = $nmTipoadministracao;
        return $this;
    }
   
    function tipoAdministracaoOptions(){
        $retorno = "<option>Selecione o tipo de administração</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinTipoAdministracao = new DaoFinTipoAdministracao();
            $daoFinTipoAdministracao->select($pdo);
            
            if ($daoFinTipoAdministracao->getSucesso()) {
                foreach ($daoFinTipoAdministracao->getMsgRetorno() as $linha) {
                    
                    $retorno .= "<option value='".$linha['id_tipo_administracao']."'>".$linha['nm_tipo_administracao']."</option>";
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    function listaTodasAdministracoes(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinTipoAdministracao = new DaoFinTipoAdministracao();
            $daoFinTipoAdministracao->select($pdo);
            
            if ($daoFinTipoAdministracao->getSucesso()) {
                foreach ($daoFinTipoAdministracao->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-id=".$linha['id_tipo_administracao'].">"
                                . "<td>".$linha['id_tipo_administracao']."</td>"
                                . "<td>".$linha['nm_tipo_administracao']."</td>"
                                . "<td style='text-align: center;'>"
                                    . "<button type='button' class='btn btn-default btn-edit btn-xs' title='Alterar' >"
                                        . "<i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>"
                                    . "</button>"
                                    . "<button type='button' class='btn btn-default btn-remover btn-xs' title='Remover' >"
                                        . "<i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>"
                                    . "</button>"
                                . "</td>"
                            . "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    function salvarTipoAdministracao(){
        $retorno = "";
        try {
            if (empty($this->getNmTipoadministracao())) {
                return Metodos::retornoAjax("Erro", "alert",STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinTipoAdministracao = new DaoFinTipoAdministracao();
            $daoFinTipoAdministracao->setNmTipoAdministracao($this->getNmTipoadministracao());
            $daoFinTipoAdministracao->insert($pdo);
            
            if ($daoFinTipoAdministracao->getSucesso()) {
                $idTipoAdministracao = $pdo->lastInsertId('fin_tipo_administracao_id_tipo_administracao_seq');
                if (!Log::SalvaLogI('fin_tipo_administracao', $idTipoAdministracao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdTipoAdministracao($idTipoAdministracao);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console",$daoFinTipoAdministracao->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function alterarTipoAdministracao(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinTipoAdministracao = new DaoFinTipoAdministracao();
            $daoFinTipoAdministracao->setIdTipoAdministracao($this->getIdTipoAdministracao());
            $daoFinTipoAdministracao->setNmTipoAdministracao($this->getNmTipoadministracao());
            
            $daoFinTipoAdministracao->selectLinha($pdo);
            if (!$daoFinTipoAdministracao->getSucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinTipoAdministracao->getMsgRetorno());
            } 
            
           //Se não der erro na seleção da diaria, atribui à variável
            $reg_antigo = $daoFinTipoAdministracao->getMsgRetorno();

            //Atualiza os registros
            $daoFinTipoAdministracao->update($pdo);
            if ($daoFinTipoAdministracao->getSucesso()) {

                if (!Log::SalvaLogU('fin_tipo_administracao', $daoFinTipoAdministracao->getIdTipoAdministracao(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
            }
            return $retorno;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function removerTipoAdministracao(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinTipoAdministracao = new DaoFinTipoAdministracao();
            $daoFinTipoAdministracao->setIdTipoAdministracao($this->getIdTipoAdministracao());
            
            $idTipoAdministracao = $daoFinTipoAdministracao->getIdTipoAdministracao();
            if (!Log::SalvaLogD('fin_tipo_administracao', $idTipoAdministracao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoFinTipoAdministracao->delete($pdo);
            if ($daoFinTipoAdministracao->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinTipoAdministracao->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
}

