<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinDocDestinatario.class.php";

class DocDestinatario {

    private $idDocDestinatario = null;
    private $idDocTipoDestinatario = null;
    private $idLotacao = null;
    
    function getIdDocDestinatario() {
        return $this->idDocDestinatario;
    }

    function getIdDocTipoDestinatario() {
        return $this->idDocTipoDestinatario;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setIdDocDestinatario($idDocDestinatario) {
        $this->idDocDestinatario = $idDocDestinatario;
        return $this;
    }

    function setIdDocTipoDestinatario($idDocTipoDestinatario) {
        $this->idDocTipoDestinatario = $idDocTipoDestinatario;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    public function cadastrar(){
        try {  
            
            if (empty($this->getIdLotacao()) or empty($this->getIdDocTipoDestinatario())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinDocDestinatario = new DaoFinDocDestinatario();
            $daoFinDocDestinatario->setIdLotacao($this->getIdLotacao())
                                  ->setIdDocTipoDestinatario($this->getIdDocTipoDestinatario());
            $daoFinDocDestinatario->insert($pdo);
            
            if ($daoFinDocDestinatario->getSucesso()) {
                $idDocDestinatario = $pdo->lastInsertId('fin_doc_destinatario_id_doc_destinatario_seq');
                if (!Log::SalvaLogI('fin_doc_destinatario', $idDocDestinatario, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdDocDestinatario($idDocDestinatario);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Valor incluído com sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocDestinatario->getMsgRetorno());
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
            
            $daoFinDocDestinatario = new DaoFinDocDestinatario();
            $daoFinDocDestinatario->setIdDocDestinatario($this->getIdDocDestinatario());
            
            $idDocDestinatario = $daoFinDocDestinatario->getIdDocDestinatario();
            if (!Log::SalvaLogD('fin_doc_destinatario', $idDocDestinatario, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoFinDocDestinatario->delete($pdo);
            if ($daoFinDocDestinatario->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Exclusão realizada com Sucesso.");
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocDestinatario->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function optionsDestinatario(){
        try {
            $retorno = "<option value=0>Selecione um Destinatário</option>";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinDocDestinatario = new DaoFinDocDestinatario();
            
            if ($this->getIdDocTipoDestinatario()) {
                $daoFinDocDestinatario->setIdDocTipoDestinatario($this->getIdDocTipoDestinatario());
            }
            $daoFinDocDestinatario->select($pdo);
            
            if ($daoFinDocDestinatario->getSucesso()) {
                foreach ($daoFinDocDestinatario->getMsgRetorno() as $linha) {
                    $retorno .= "<option value=".$linha['id_lotacao'].">".$linha['nm_lotacao']."</option>";
                }
            } else {
                $retorno = $daoFinDocDestinatario->getMsgRetorno();
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
            
            $daoFinDocDestinatario = new DaoFinDocDestinatario();
            $daoFinDocDestinatario->select($pdo);
            
            if ($daoFinDocDestinatario->getSucesso()) {
                foreach ($daoFinDocDestinatario->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='". json_encode($linha)."'>"
                                    . "<td>".$linha['nm_doc_tipo_destinatario']."</td>"
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