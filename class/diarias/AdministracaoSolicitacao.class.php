<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinTipoAdministracao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinTipoSolicitacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinAdministracaoSolicitacao.class.php";

class AdministracaoSolicitacao {

    private $idAdministracaoSolicitacao = null;
    private $idTipoAdministracao = null;
    private $idTipoSolicitacao = null;
    
    function getIdAdministracaoSolicitacao() {
        return $this->idAdministracaoSolicitacao;
    }

    function getIdTipoAdministracao() {
        return $this->idTipoAdministracao;
    }

    function getIdTipoSolicitacao() {
        return $this->idTipoSolicitacao;
    }

    function setIdAdministracaoSolicitacao($idAdministracaoSolicitacao) {
        $this->idAdministracaoSolicitacao = $idAdministracaoSolicitacao;
    }

    function setIdTipoAdministracao($idTipoAdministracao) {
        $this->idTipoAdministracao = $idTipoAdministracao;
    }

    function setIdTipoSolicitacao($idTipoSolicitacao) {
        $this->idTipoSolicitacao = $idTipoSolicitacao;
    }

    function retornaTipoAdministracaoOptions(){
        $retorno = "";
        try {
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinTipoAdministracao = new DaoFinTipoAdministracao();
            $daoFinTipoAdministracao->select($pdo);
            
            if ($daoFinTipoAdministracao->getSucesso()) {
                foreach ($daoFinTipoAdministracao->getMsgRetorno() as $linha) {
                    $retorno .= "<option value='".$linha['id_tipo_administracao']."'>".$linha['nm_tipo_administracao']."</option>";
                }
            } else {
                $retorno = $daoFinTipoAdministracao->getMsgRetorno(); 
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    function retornaTipoSolicitacaoOptions(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinTipoSolicitacao = new DaoFinTipoSolicitacao();
            $daoFinTipoSolicitacao->select($pdo);
            
            if ($daoFinTipoSolicitacao->getSucesso()) {
                foreach ($daoFinTipoSolicitacao->getMsgRetorno() as $linha) {
                    $retorno .= "<option value='".$linha['id_tipo_solicitacao']."'>".$linha['nm_tipo_solicitacao']."</option>";
                }
            } else {
                $retorno = $daoFinTipoSolicitacao->getMsgRetorno();
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    function retornaListaAdministracaoSolicitacao(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinAdministracaoSolicitacao = new DaoFinAdministracaoSolicitacao();
            $daoFinAdministracaoSolicitacao->select($pdo);
            
            if ($daoFinAdministracaoSolicitacao->getSucesso()) {
                foreach ($daoFinAdministracaoSolicitacao->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-id=".$linha['id_administracao_solicitacao'].">"
                                . "<td>".$linha['nm_tipo_administracao']."</td>"
                                . "<td>".$linha['nm_tipo_solicitacao']."</td>"
                                . "<td style='text-align: center;'>"
                                .    "<button type='button' class='btn btn-default btn-remover btn-xs' title='Remover' >"
                                .      "<i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>"
                                .    "</button>"
                                . "</td>"
                            . "</tr>";
                }
            } else {
                $retorno = $daoFinAdministracaoSolicitacao->getMsgRetorno();
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    function salvarAdministracaoSolicitacao(){
        $retorno = "";
        try {
            if (empty($this->getIdTipoAdministracao()) or empty($this->getIdTipoSolicitacao())) {
                return Metodos::retornoAjax("Erro", "alert","Por favor preencha todos os campos necessários.");
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinAdministracaoSolicitacao = new DaoFinAdministracaoSolicitacao();
            $daoFinAdministracaoSolicitacao->setIdTipoAdministracao($this->getIdTipoAdministracao());
            $daoFinAdministracaoSolicitacao->setIdTipoSolicitacao($this->getIdTipoSolicitacao());
            $daoFinAdministracaoSolicitacao->insert($pdo);
            
            if ($daoFinAdministracaoSolicitacao->getSucesso()) {
                $idAdministracaoSolicitacao = $pdo->lastInsertId('fin_administracao_solicitacao_id_administracao_solicitacao_seq');
                if (!Log::SalvaLogI('fin_administracao_solicitacao', $idAdministracaoSolicitacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdAdministracaoSolicitacao($idAdministracaoSolicitacao);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Vinculação Administração/Solicitação concluída com sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console",$daoFinAdministracaoSolicitacao->getMsgRetorno());
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function excluirAdministracaoSolicitacao(){
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinAdministracaoSolicitacao = new DaoFinAdministracaoSolicitacao();
            $daoFinAdministracaoSolicitacao->setIdAdministracaoSolicitacao($this->getIdAdministracaoSolicitacao());
            
            $idAdministracaoSolicitacao = $daoFinAdministracaoSolicitacao->getIdAdministracaoSolicitacao();
            if (!Log::SalvaLogD('fin_administracao_solicitacao', $idAdministracaoSolicitacao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoFinAdministracaoSolicitacao->delete($pdo);
            if ($daoFinAdministracaoSolicitacao->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Exclusão realizada com Sucesso.");
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAdministracaoSolicitacao->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }

}
