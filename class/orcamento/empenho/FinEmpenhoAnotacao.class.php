<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/orcamento/empenho/DaoFinEmpenhoAnotacao.class.php";


class FinEmpenhoAnotacao {

    private $idEmpenhoAnotacao = null;
    private $dhEmpenhoAnotacao = null;
    private $dsEmpenhoAnotacao = null;
    private $idPessoa = null;
    private $idEmpenho = null;
    
    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    function getIdEmpenhoAnotacao() {
        return $this->idEmpenhoAnotacao;
    }

    function getDhEmpenhoAnotacao() {
        return $this->dhEmpenhoAnotacao;
    }

    function getDsEmpenhoAnotacao() {
        return $this->dsEmpenhoAnotacao;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdEmpenho() {
        return $this->idEmpenho;
    }

    function setIdEmpenhoAnotacao($idEmpenhoAnotacao) {
        $this->idEmpenhoAnotacao = $idEmpenhoAnotacao;
        return $this;
    }

    function setDhEmpenhoAnotacao($dhEmpenhoAnotacao) {
        $this->dhEmpenhoAnotacao = $dhEmpenhoAnotacao;
        return $this;
    }

    function setDsEmpenhoAnotacao($dsEmpenhoAnotacao) {
        $this->dsEmpenhoAnotacao = $dsEmpenhoAnotacao;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setIdEmpenho($idEmpenho) {
        $this->idEmpenho = $idEmpenho;
        return $this;
    }

    public function retornaAnotacoes(){
        $retorno = "";
        try {
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinEmpenhoAnotacao = new DaoFinEmpenhoAnotacao();
            $daoFinEmpenhoAnotacao->setIdEmpenho($this->getIdEmpenho());
            $daoFinEmpenhoAnotacao->selectPorEmpenho($pdo);
            
            if ($daoFinEmpenhoAnotacao->getSucesso()) {
                foreach ($daoFinEmpenhoAnotacao->getMsgRetorno() as $linha) {
                    $retorno .= $linha['dh_empenho_anotacao'] ." - ". $linha['nm_pessoa'] .": ".$linha['ds_empenho_anotacao']. "\n";
                }
            } else {
                $retorno = $daoFinEmpenhoAnotacao->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    public function salvaAnotacaoComRetorno(){
        try {
            $retorno = "";
            
            if (empty($this->getDsEmpenhoAnotacao())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            //Só pode Editar o empenho quem possui a Tramitação de Empenhar
            $tramitacao = new VincularTramitacao();
            $tramitacao->setIdPessoa($this->idPessoa);
            $tramitacao->setIdTramitacao($tramitacao->getTramitacaoEmpenhar());
            $tramitacao->verificaPessoaTramitacao($pdo);
            if(!$tramitacao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Usuário Não possui Permissão para Cancelar Empenho.");
            }
            
            $this->salvaAnotacao($pdo);
            if ($this->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok","html",$this->getMsgRetorno());
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro","console", $this->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    
    public function salvaAnotacao(PDO $pdo = null){
        $this->sucesso = false;
        $this->msgRetorno = null;            
        try {
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
            }
                        
            $daoFinEmpenhoAnotacao = new DaoFinEmpenhoAnotacao();
            $daoFinEmpenhoAnotacao->setIdEmpenho($this->getIdEmpenho())
                                 ->setDsEmpenhoAnotacao($this->getDsEmpenhoAnotacao())
                                 ->setIdPessoa($this->getIdPessoa());
            
            $daoFinEmpenhoAnotacao->insert($pdo);
            if ($daoFinEmpenhoAnotacao->getSucesso()) {
                $idEmpenhoAnotacao = $pdo->lastInsertId('fin_empenho_anotacao_id_empenho_anotacao_seq');
                if (!Log::SalvaLogI('fin_empenho_anotacao', $idEmpenhoAnotacao, $pdo)) {
                    $this->sucesso = false;
                    $this->msgRetorno = "Erro no Log da Anotação";
                    return;
                }
                $this->sucesso = true;
                $this->msgRetorno = "Anotação Salva com Sucesso." ;                
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível salvar uma Anotação no Pedido.";                
            }            
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();            
        }
    }

}