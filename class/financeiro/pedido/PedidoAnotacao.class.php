<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/pedido/DaoFinPedidoAnotacao.class.php";

class PedidoAnotacao {

    private $idPedidoAnotacao = null;
    private $dhPedidoAnotacao = null;
    private $dsPedidoAnotacao = null;
    private $idPessoa = null;
    private $idPedido = null;
    private $sucesso = false;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    function sucesso() {
        return $this->sucesso;
    }
    
    function getIdPedidoAnotacao() {
        return $this->idPedidoAnotacao;
    }

    function getDhPedidoAnotacao() {
        return $this->dhPedidoAnotacao;
    }

    function getDsPedidoAnotacao() {
        return $this->dsPedidoAnotacao;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdPedido() {
        return $this->idPedido;
    }

    function setIdPedidoAnotacao($idPedidoAnotacao) {
        $this->idPedidoAnotacao = $idPedidoAnotacao;
        return $this;
    }

    function setDhPedidoAnotacao($dhPedidoAnotacao) {
        $this->dhPedidoAnotacao = $dhPedidoAnotacao;
        return $this;
    }

    function setDsPedidoAnotacao($dsPedidoAnotacao) {
        $this->dsPedidoAnotacao = $dsPedidoAnotacao;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
        return $this;
    }
    
    public function retornaAnotacoes(){
        $retorno = "";
        try {
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinPedidoAnotacao = new DaoFinPedidoAnotacao();
            $daoFinPedidoAnotacao->setIdPedido($this->getIdPedido());
            $daoFinPedidoAnotacao->selectPorPedido($pdo);
            
            if ($daoFinPedidoAnotacao->getSucesso()) {
                foreach ($daoFinPedidoAnotacao->getMsgRetorno() as $linha) {
                    $retorno .= $linha['dh_pedido_anotacao'] ." - ". $linha['nm_pessoa'] .": ".$linha['ds_pedido_anotacao']. "\n";
                }
            } else {
                $retorno = $daoFinPedidoAnotacao->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    public function salvaAnotacao(PDO $pdo = null){
        try {
            $retorno = "";
            
            if (empty($this->getDsPedidoAnotacao())){
                $this->sucesso = false;
                $this->msgRetorno = "Não existe descritivo para a anotação.";
                return;
            }
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
            }
                        
            $daoFinPedidoAnotacao = new DaoFinPedidoAnotacao();
            $daoFinPedidoAnotacao->setIdPedido($this->getIdPedido())
                                 ->setDsPedidoAnotacao($this->getDsPedidoAnotacao())
                                 ->setIdPessoa($this->getIdPessoa());
            
            $daoFinPedidoAnotacao->insert($pdo);
            if ($daoFinPedidoAnotacao->getSucesso()) {
                $idPedidoAnotacao = $pdo->lastInsertId('fin_pedido_anotacao_id_pedido_anotacao_seq');
                if (!Log::SalvaLogI('fin_pedido_anotacao', $idPedidoAnotacao, $pdo)) {
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


    public function salvaAnotacaoComRetornoAjax(PDO $pdo = null){
        try {
            
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
            }
            
            $this->salvaAnotacao($pdo);
            if ($this->sucesso()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok","html", $this->getMsgRetorno());
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro","alert", $this->getMsgRetorno());
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro","console", $exc->getMessage());
        }
    }

}

