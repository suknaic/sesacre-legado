<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocLotacao.class.php";

class DocLotacao {

    private $idDocLotacao = null;
    private $idDocTipoLotacao = null;
    private $idLotacao = null;
    
    function getIdDocLotacao() {
        return $this->idDocLotacao;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setIdDocLotacao($idDocLotacao) {
        $this->idDocLotacao = $idDocLotacao;
        return $this;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    public function cadastrar(){
        try {  
            
            if (empty($this->getIdLotacao()) or empty($this->getIdDocTipoLotacao())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinDocLotacao = new DaoFinDocLotacao();
            $daoFinDocLotacao->setIdLotacao($this->getIdLotacao())
                                  ->setIdDocTipoLotacao($this->getIdDocTipoLotacao());
            $daoFinDocLotacao->insert($pdo);
            
            if ($daoFinDocLotacao->getSucesso()) {
                $idDocLotacao = $pdo->lastInsertId('fin_doc_lotacao_id_doc_lotacao_seq');
                if (!Log::SalvaLogI('fin_doc_lotacao', $idDocLotacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdDocLotacao($idDocLotacao);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocLotacao->getMsgRetorno());
            }
            return $retorno;                                                                                                        
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    function excluir(){
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinDocLotacao = new DaoFinDocLotacao();
            $daoFinDocLotacao->setIdDocLotacao($this->getIdDocLotacao());
            
            $idDocLotacao = $daoFinDocLotacao->getIdDocLotacao();
            if (!Log::SalvaLogD('fin_doc_lotacao', $idDocLotacao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoFinDocLotacao->delete($pdo);
            if ($daoFinDocLotacao->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocLotacao->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function optionsTipoLotacao(){
        try {
            $retorno = "<option value=0>Selecione um Tipo de Remetente/Tipo de Destinatário</option>";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinDocLotacao = new DaoFinDocLotacao();
            
            if ($this->getIdDocTipoLotacao()) {
                $daoFinDocLotacao->setIdDocTipoLotacao($this->getIdDocTipoLotacao());
            }
            $daoFinDocLotacao->select($pdo);
            
            if ($daoFinDocLotacao->getSucesso()) {
                foreach ($daoFinDocLotacao->getMsgRetorno() as $linha) {
                    $retorno .= "<option data-objeto='". json_encode($linha)."' value=".$linha['id_doc_lotacao'].">". $linha['nm_doc_tipo_lotacao'] ." / ".$linha['nm_lotacao']."</option>";
                }
            } else {
                $retorno = $daoFinDocLotacao->getMsgRetorno();
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function listaTodos() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinDocLotacao = new DaoFinDocLotacao();
            $daoFinDocLotacao->select($pdo);
            
            if ($daoFinDocLotacao->getSucesso()) {
                foreach ($daoFinDocLotacao->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='". json_encode($linha)."'>"
                                    . "<td>".$linha['nm_doc_tipo_lotacao']."</td>"
                                    . "<td>".$linha['nm_lotacao']."</td>"
                                    . "<td class='text-center'>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-excluir'><i class='fa fa-trash fa-lg text-danger' aria-hidden=true></i></button>"
                                    . "</td>"
                             . "</tr>";
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
}