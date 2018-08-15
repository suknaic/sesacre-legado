<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinDocVincRecebimento.class.php";

class DocVincRecebimento {

    private $idDocVincRecebimento = null;
    private $idDocTipoLotacao = null;
    private $idLotacao = null;
    private $idPessoa = null;
    
    function getIdDocVincRecebimento() {
        return $this->idDocVincRecebimento;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function setIdDocVincRecebimento($idDocVincRecebimento) {
        $this->idDocVincRecebimento = $idDocVincRecebimento;
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

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    public function cadastrar(){
        try {  
            
            if (empty($this->getIdLotacao()) or empty($this->getIdPessoa()) or empty($this->getIdDocTipoLotacao())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinDocVincRecebimento = new DaoFinDocVincRecebimento();
            $daoFinDocVincRecebimento->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                                   ->setIdLotacao($this->getIdLotacao())
                                   ->setIdPessoa($this->getIdPessoa());
            
            //verifica se já existe o registro, o banco já possui a constraint, para informar o usuário
            $daoFinDocVincRecebimento->select($pdo);
            

            if ($daoFinDocVincRecebimento->getSucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "O registro já existe, não é possível incluir outro.");
            }
            
            $daoFinDocVincRecebimento->insert($pdo);
            
            if ($daoFinDocVincRecebimento->getSucesso()) {
                
                $idDocVincRecebimento = $pdo->lastInsertId('fin_doc_vinc_recebimento_id_doc_vinc_recebimento_seq');
                if (!Log::SalvaLogI('fin_doc_vinc_recebimento', $idDocVincRecebimento, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                $this->setIdDocVincRecebimento($idDocVincRecebimento);
                $pdo->commit();
                
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocVincRecebimento->getMsgRetorno());
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
            
            $daoFinDocVincRecebimento = new DaoFinDocVincRecebimento();
            $daoFinDocVincRecebimento->setIdDocVincRecebimento($this->getIdDocVincRecebimento());
            
            $idDocVincRecebimento = $daoFinDocVincRecebimento->getIdDocVincRecebimento();
            if (!Log::SalvaLogD('fin_doc_vinc_recebimento', $idDocVincRecebimento, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoFinDocVincRecebimento->delete($pdo);
            if ($daoFinDocVincRecebimento->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocVincRecebimento->getMsgRetorno());
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
            
            $daoFinDocVincRecebimento = new DaoFinDocVincRecebimento();
            
            if ($this->getIdDocVincRecebimento()) {
                $daoFinDocVincRecebimento->setIdDocVincRecebimento($this->getIdDocVincRecebimento());
            }
            if ($this->getIdDocTipoLotacao()) {
                $daoFinDocVincRecebimento->setIdDocTipoLotacao($this->getIdDocTipoLotacao());
            }
            if ($this->getIdPessoa()) {
                $daoFinDocVincRecebimento->setIdPessoa($this->getIdPessoa());
            }
            if ($this->getIdLotacao()) {
                $daoFinDocVincRecebimento->setIdLotacao($this->getIdLotacao());
            }
            
            $daoFinDocVincRecebimento->select($pdo);
            
            if ($daoFinDocVincRecebimento->getSucesso()) {
                foreach ($daoFinDocVincRecebimento->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='". json_encode($linha)."'>"
                                    . "<td>".$linha['nm_pessoa']."</td>"
                                    . "<td>Receber</td>"
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