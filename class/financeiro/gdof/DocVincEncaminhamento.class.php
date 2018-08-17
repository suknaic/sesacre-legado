<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocVincEncaminhamento.class.php";

class DocVincEncaminhamento {

    private $idDocVincEncaminhamento = null;
    private $idDocLotacao = null;
    private $idPessoa = null;
    
    function getIdDocVincEncaminhamento() {
        return $this->idDocVincEncaminhamento;
    }

    function getIdDocLotacao() {
        return $this->idDocLotacao;
    }


    function getIdPessoa() {
        return $this->idPessoa;
    }

    function setIdDocVincEncaminhamento($idDocVincEncaminhamento) {
        $this->idDocVincEncaminhamento = $idDocVincEncaminhamento;
        return $this;
    }

    function setIdDocLotacao($idDocLotacao) {
        $this->idDocLotacao = $idDocLotacao;
        return $this;
    }


    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    public function cadastrar(){
        try {  
            
            if (empty($this->getIdPessoa()) or empty($this->getIdDocLotacao())){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinDocVincEncaminhamento = new DaoFinDocVincEncaminhamento();
            $daoFinDocVincEncaminhamento->setIdDocLotacao($this->getIdDocLotacao())
                                   ->setIdPessoa($this->getIdPessoa());
            
            //verifica se já existe o registro, o banco já possui a constraint, para informar o usuário
            //'1' é passado fixo para o select filtrar apenas os 'Encaminhamentos'
            $daoFinDocVincEncaminhamento->select($pdo,1);
            
            if ($daoFinDocVincEncaminhamento->getSucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "O registro já existe, não é possível incluir outro.");
            }
            
            $daoFinDocVincEncaminhamento->insert($pdo);
            
            if ($daoFinDocVincEncaminhamento->getSucesso()) {
                
                $idDocVincEncaminhamento = $pdo->lastInsertId('fin_doc_vinc_encaminhamento_id_doc_vinc_encaminhamento_seq');
                if (!Log::SalvaLogI('fin_doc_vinc_encaminhamento', $idDocVincEncaminhamento, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                $this->setIdDocVincEncaminhamento($idDocVincEncaminhamento);
                $pdo->commit();
                
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocVincEncaminhamento->getMsgRetorno());
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
            
            $daoFinDocVincEncaminhamento = new DaoFinDocVincEncaminhamento();
            $daoFinDocVincEncaminhamento->setIdDocVincEncaminhamento($this->getIdDocVincEncaminhamento());
            
            $idDocVincEncaminhamento = $daoFinDocVincEncaminhamento->getIdDocVincEncaminhamento();
            if (!Log::SalvaLogD('fin_doc_vinc_encaminhamento', $idDocVincEncaminhamento, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoFinDocVincEncaminhamento->delete($pdo);
            if ($daoFinDocVincEncaminhamento->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocVincEncaminhamento->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }

    function listaTodos(int $tipoTramitacao = 0) {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinDocVincEncaminhamento = new DaoFinDocVincEncaminhamento();
            
            if ($this->getIdDocVincEncaminhamento()) {
                $daoFinDocVincEncaminhamento->setIdDocVincEncaminhamento($this->getIdDocVincEncaminhamento());
            }
            if ($this->getIdDocLotacao()) {
                $daoFinDocVincEncaminhamento->setIdDocLotacao($this->getIdDocLotacao());
            }
            if ($this->getIdPessoa()) {
                $daoFinDocVincEncaminhamento->setIdPessoa($this->getIdPessoa());
            }

            
            $daoFinDocVincEncaminhamento->select($pdo,$tipoTramitacao);
            
            if ($daoFinDocVincEncaminhamento->getSucesso()) {
                foreach ($daoFinDocVincEncaminhamento->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='". json_encode($linha)."'>"
                                    . "<td>".$linha['nm_pessoa']."</td>"
                                    . "<td>".$linha['ds_tramitacao']."</td>"
                                    . "<td>".$linha['nm_lotacao']."</td>"
                                    . "<td>".$linha['nm_doc_tipo_lotacao']."</td>"
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