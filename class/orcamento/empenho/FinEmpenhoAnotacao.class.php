<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/pedido/DaoFinPedidoAnotacao.class.php";


class FinEmpenhoAnotacao {

    private $idPedidoAnotacao = null;
    private $dhPedidoAnotacao = null;
    private $dsPedidoAnotacao = null;
    private $idPessoa = null;
    private $idPedido = null;
    
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

    public function salvaAnotacao(){
        try {
            $retorno = "";
            
            if (empty($this->getDsPedidoAnotacao())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            
            $daoFinPedidoAnotacao = new DaoFinPedidoAnotacao();
            $daoFinPedidoAnotacao->setIdPedido($this->getIdPedido())
                                 ->setDsPedidoAnotacao($this->getDsPedidoAnotacao())
                                 ->setIdPessoa($this->getIdPessoa());
            
            $daoFinPedidoAnotacao->insert($pdo);
            if ($daoFinPedidoAnotacao->getSucesso()) {
                $idPedidoAnotacao = $pdo->lastInsertId('fin_pedido_anotacao_id_pedido_anotacao_seq');
                if (!Log::SalvaLogI('fin_pedido_anotacao', $idPedidoAnotacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdPedidoAnotacao($idPedidoAnotacao);
                
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinPedidoAnotacao->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}