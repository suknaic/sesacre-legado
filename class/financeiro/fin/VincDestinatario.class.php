<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinVincDestinatario.class.php";

class VincDestinatario {

    private $idVincDestinatario = null;
    private $idDocTipoDestinatario = null;
    private $idLotacao = null;
    private $idPessoa = null;
    
    function getIdVincDestinatario() {
        return $this->idVincDestinatario;
    }

    function getIdDocTipoDestinatario() {
        return $this->idDocTipoDestinatario;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function setIdVincDestinatario($idVincDestinatario) {
        $this->idVincDestinatario = $idVincDestinatario;
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

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    public function cadastrar(){
        try {  
            
            if (empty($this->getIdLotacao()) or empty($this->getIdPessoa()) or empty($this->getIdDocTipoDestinatario())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinVincDestinatario = new DaoFinVincDestinatario();
            $daoFinVincDestinatario->setIdDocTipoDestinatario($this->getIdDocTipoDestinatario())
                                   ->setIdLotacao($this->getIdLotacao())
                                   ->setIdPessoa($this->getIdPessoa());
            
            $daoFinVincDestinatario->insert($pdo);
            
            if ($daoFinVincDestinatario->getSucesso()) {
                
                $idVincDestinatario = $pdo->lastInsertId('fin_vinc_destinatario_id_vinc_destinatario_seq');
                if (!Log::SalvaLogI('fin_vinc_destinatario', $idVincDestinatario, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                $this->setIdVincDestinatario($idVincDestinatario);
                $pdo->commit();
                
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinVincDestinatario->getMsgRetorno());
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
            
            $daoFinVincDestinatario = new DaoFinVincDestinatario();
            $daoFinVincDestinatario->setIdVincDestinatario($this->getIdVincDestinatario());
            
            $idVincDestinatario = $daoFinVincDestinatario->getIdVincDestinatario();
            if (!Log::SalvaLogD('fin_vinc_destinatario', $idVincDestinatario, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoFinVincDestinatario->delete($pdo);
            if ($daoFinVincDestinatario->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinVincDestinatario->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }

    function listaTodos() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinVincDestinatario = new DaoFinVincDestinatario();
            
            if ($this->getIdVincDestinatario()) {
                $daoFinVincDestinatario->setIdVincDestinatario($this->getIdVincDestinatario());
            }
            if ($this->getIdDocTipoDestinatario()) {
                $daoFinVincDestinatario->setIdDocTipoDestinatario($this->getIdDocTipoDestinatario());
            }
            if ($this->getIdPessoa()) {
                $daoFinVincDestinatario->setIdPessoa($this->getIdPessoa());
            }
            if ($this->getIdLotacao()) {
                $daoFinVincDestinatario->setIdLotacao($this->getIdLotacao());
            }
            $daoFinVincDestinatario->select($pdo);
            
            if ($daoFinVincDestinatario->getSucesso()) {
                foreach ($daoFinVincDestinatario->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='". json_encode($linha)."'>"
                                    . "<td>".$linha['nm_pessoa']."</td>"
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