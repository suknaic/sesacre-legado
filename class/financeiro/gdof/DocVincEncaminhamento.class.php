<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocVincEncaminhamento.class.php";

class DocVincEncaminhamento {

    private $idDocVincEncaminhamento = null;
    private $idDocLotacao = null;
    private $idPessoa = null;    
    private $sucesso = false;
    private $msgRetorno = null;        
    
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
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
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
    

    public function optionsLotacaoEncaminhamentoPorUsuarioETipo(int $idLotacao = 0) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $options = '';

            $daoFinDocVincEncaminhamento = new DaoFinDocVincEncaminhamento();
            $daoFinDocVincEncaminhamento->setIdPessoa($this->idPessoa);
            $daoFinDocVincEncaminhamento->retornaLotacaoTipoEncaminhamentoPorUsuario($pdo);
            if ($daoFinDocVincEncaminhamento->getSucesso()) {
                foreach ($daoFinDocVincEncaminhamento->getMsgRetorno() as $linha) {

                    if ($linha["id_doc_lotacao"] == $idLotacao) {
                        $options .= '<option value="' . $linha["id_lotacao"] . '" selected="true" id_doc_lotacao ="' . $linha["id_doc_lotacao"] . '" >'
                                . $linha["nm_doc_tipo_lotacao"] . ' / ' . $linha["nm_lotacao"] . '</option>';
                    } else {
                        $options .= '<option value="' . $linha["id_lotacao"] . '"  id_doc_lotacao ="' . $linha["id_doc_lotacao"] . '" >'
                                . $linha["nm_doc_tipo_lotacao"] . ' / ' . $linha["nm_lotacao"] . '</option>';
                    }
                }
            }
            return $options;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function retornaIdLotacaoUsuarioEncaminhamento() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinDocVincEncaminhamento = new DaoFinDocVincEncaminhamento();
            $daoFinDocVincEncaminhamento->setIdPessoa($this->idPessoa);
            $daoFinDocVincEncaminhamento->retornaLotacaoTipoEncaminhamentoPorUsuario($pdo);
            return $daoFinDocVincEncaminhamento->getMsgRetorno();
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    
    
    function excluirTodosDocLotacao(PDO $pdo = null){
        $this->sucesso = false;
        try {
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
            }
                                                
            /**
             * Lista todos os Doc Vinc Encaminhamento, de acordo com o ID Doc Lotação
             * 
             */           
                                    
            $daoFinDocVincEncaminhamento = new DaoFinDocVincEncaminhamento();
            $daoFinDocVincEncaminhamento->setIdDocLotacao($this->idDocLotacao);
            $daoFinDocVincEncaminhamento->retornaTodosDocLotacao($pdo);
            if(!$daoFinDocVincEncaminhamento->getSucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $daoFinDocVincEncaminhamento->getMsgRetorno(); 
                return;
            }
            
            $result = $daoFinDocVincEncaminhamento->getMsgRetorno();
            if(empty($result)){
                $this->sucesso = true;
                $this->msgRetorno = "Não possui Registro";
                return;
            }
            
            foreach ($result as $key => $value) {
                $daoFinDocVincEncaminhamento->setIdDocVincEncaminhamento($value['id_doc_vinc_encaminhamento']);
                if (!Log::SalvaLogD('fin_doc_vinc_encaminhamento', $daoFinDocVincEncaminhamento->getIdDocVincEncaminhamento(), $pdo)) {                    
                    $this->sucesso = false;
                    $this->msgRetorno = "Erro no LOG";
                    return;
                }
                $daoFinDocVincEncaminhamento->delete($pdo);
                if (!$daoFinDocVincEncaminhamento->getSucesso()) {
                    $this->sucesso = false;
                    $this->msgRetorno = $daoFinDocVincEncaminhamento->getMsgRetorno();
                    return;                    
                }
            }
            
            $this->sucesso = true;
            $this->msgRetorno = "Excluido geral";                                               
            
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();            

        }
    }

}