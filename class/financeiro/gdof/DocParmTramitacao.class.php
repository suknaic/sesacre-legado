<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocParmTramitacao.class.php";

class DocParmTramitacao {

    private $idDocParmTramitacao = null;
    private $idDocTipoRemetente = null;
    private $idDocTipoDestinatario = null;
    private $tpDocParmTramitacao = null;
    private $idDocumentoSituacao = null;
    
    function getIdDocParmTramitacao() {
        return $this->idDocParmTramitacao;
    }

    function getIdDocTipoRemetente() {
        return $this->idDocTipoRemetente;
    }

    function getIdDocTipoDestinatario() {
        return $this->idDocTipoDestinatario;
    }

    function getTpDocParmTramitacao() {
        return $this->tpDocParmTramitacao;
    }

    function getIdDocumentoSituacao() {
        return $this->idDocumentoSituacao;
    }

    function setIdDocParmTramitacao($idDocParmTramitacao) {
        $this->idDocParmTramitacao = $idDocParmTramitacao;
        return $this;
    }

    function setIdDocTipoRemetente($idDocTipoRemetente) {
        $this->idDocTipoRemetente = $idDocTipoRemetente;
        return $this;
    }

    function setIdDocTipoDestinatario($idDocTipoDestinatario) {
        $this->idDocTipoDestinatario = $idDocTipoDestinatario;
        return $this;
    }

    function setTpDocParmTramitacao($tpDocParmTramitacao) {
        $this->tpDocParmTramitacao = $tpDocParmTramitacao;
        return $this;
    }

    function setIdDocumentoSituacao($idDocumentoSituacao) {
        $this->idDocumentoSituacao = $idDocumentoSituacao;
        return $this;
    }

    public function cadastrar(){
        try {  
            
            if (empty($this->getIdDocTipoRemetente()) || empty($this->getIdDocTipoDestinatario()) || empty($this->getIdDocumentoSituacao()) || empty($this->getTpDocParmTramitacao())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinDocParmTramitacao = new DaoFinDocParmTramitacao();
            $daoFinDocParmTramitacao->setIdDocTipoDestinatario($this->getIdDocTipoDestinatario())
                                ->setIdDocTipoRemetente($this->getIdDocTipoRemetente())
                                ->setIdDocumentoSituacao($this->getIdDocumentoSituacao())
                                ->setTpDocParmTramitacao($this->getTpDocParmTramitacao());
            $daoFinDocParmTramitacao->insert($pdo);
            
            if ($daoFinDocParmTramitacao->getSucesso()) {
                $idDocParmTramitacao = $pdo->lastInsertId('fin_doc_parm_tramitacao_id_doc_parm_tramitacao_seq');
                if (!Log::SalvaLogI('fin_doc_parm_tramitacao', $idDocParmTramitacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdDocParmTramitacao($idDocParmTramitacao);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocParmTramitacao->getMsgRetorno());
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
            
            $daoFinDocParmTramitacao = new DaoFinDocParmTramitacao();
            $daoFinDocParmTramitacao->setIdDocParmTramitacao($this->getIdDocParmTramitacao());
            
            $idDocParmTramitacao = $daoFinDocParmTramitacao->getIdDocParmTramitacao();
            if (!Log::SalvaLogD('fin_doc_parm_tramitacao', $idDocParmTramitacao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoFinDocParmTramitacao->delete($pdo);
            if ($daoFinDocParmTramitacao->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocParmTramitacao->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$ex->getMessage());
        }
    }
    
    function listaTodos() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinDocParmTramitacao = new DaoFinDocParmTramitacao();
            $daoFinDocParmTramitacao->select($pdo);
            
            if ($daoFinDocParmTramitacao->getSucesso()) {
                foreach ($daoFinDocParmTramitacao->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='". json_encode($linha)."'>"
                                    . "<td>".$linha['nm_tipo_remetente']."</td>"
                                    . "<td>".$linha['tramitacao']."</td>"
                                    . "<td>".$linha['nm_tipo_destinatario']."</td>"
                                    . "<td>".$linha['nm_situacao']."</td>"
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